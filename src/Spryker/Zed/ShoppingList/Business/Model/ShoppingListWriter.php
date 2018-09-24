<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business\Model;

use Generated\Shared\Transfer\EventEntityTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Zed\Kernel\PermissionAwareTrait;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToEventFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToMessengerFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToProductFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\ShoppingListEvents;
use Spryker\Zed\ShoppingList\Persistence\ShoppingListEntityManagerInterface;
use Spryker\Zed\ShoppingList\Persistence\ShoppingListRepositoryInterface;
use Spryker\Zed\ShoppingList\ShoppingListConfig;

class ShoppingListWriter implements ShoppingListWriterInterface
{
    use TransactionTrait;

    use PermissionAwareTrait;

    protected const DUPLICATE_NAME_SHOPPING_LIST = 'customer.account.shopping_list.error.duplicate_name';
    protected const CANNOT_UPDATE_SHOPPING_LIST = 'customer.account.shopping_list.error.cannot_update';
    protected const GLOSSARY_KEY_CUSTOMER_ACCOUNT_SHOPPING_LIST_CREATE_SUCCESS = 'customer.account.shopping_list.create.success';
    protected const GLOSSARY_PARAM_NAME = '%name%';
    protected const GLOSSARY_KEY_CUSTOMER_ACCOUNT_SHOPPING_LIST_DELETE_FAILED = 'customer.account.shopping_list.delete.failed';
    protected const GLOSSARY_KEY_SHOPPING_LIST_NOT_FOUND = 'shopping_list.not_found';
    protected const CUSTOM_EVENT_COL_CUSTOMER_REFERENCE = 'spy_shopping_list.customer_reference';

    /**
     * @var \Spryker\Zed\ShoppingList\Persistence\ShoppingListEntityManagerInterface
     */
    protected $shoppingListEntityManager;

    /**
     * @var \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToProductFacadeInterface
     */
    protected $productFacade;

    /**
     * @var \Spryker\Zed\ShoppingList\Persistence\ShoppingListRepositoryInterface
     */
    protected $shoppingListRepository;

    /**
     * @var \Spryker\Zed\ShoppingList\ShoppingListConfig
     */
    protected $shoppingListConfig;

    /**
     * @var \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToMessengerFacadeInterface
     */
    protected $messengerFacade;

    /**
     * @var \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToEventFacadeInterface
     */
    protected $eventFacade;

    /**
     * @param \Spryker\Zed\ShoppingList\Persistence\ShoppingListEntityManagerInterface $shoppingListEntityManager
     * @param \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToProductFacadeInterface $productFacade
     * @param \Spryker\Zed\ShoppingList\Persistence\ShoppingListRepositoryInterface $shoppingListRepository
     * @param \Spryker\Zed\ShoppingList\ShoppingListConfig $shoppingListConfig
     * @param \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToMessengerFacadeInterface $messengerFacade
     * @param \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToEventFacadeInterface $eventFacade
     */
    public function __construct(
        ShoppingListEntityManagerInterface $shoppingListEntityManager,
        ShoppingListToProductFacadeInterface $productFacade,
        ShoppingListRepositoryInterface $shoppingListRepository,
        ShoppingListConfig $shoppingListConfig,
        ShoppingListToMessengerFacadeInterface $messengerFacade,
        ShoppingListToEventFacadeInterface $eventFacade
    ) {
        $this->shoppingListEntityManager = $shoppingListEntityManager;
        $this->productFacade = $productFacade;
        $this->shoppingListRepository = $shoppingListRepository;
        $this->shoppingListConfig = $shoppingListConfig;
        $this->messengerFacade = $messengerFacade;
        $this->eventFacade = $eventFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function validateAndSaveShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        $shoppingListResponseTransfer = new ShoppingListResponseTransfer();
        $shoppingListResponseTransfer->setIsSuccess(false);

        if ($this->checkShoppingListWithSameName($shoppingListTransfer)) {
            $shoppingListResponseTransfer->addError(static::DUPLICATE_NAME_SHOPPING_LIST);

            return $shoppingListResponseTransfer;
        }

        if (!$this->checkWritePermission($shoppingListTransfer)) {
            $shoppingListResponseTransfer->addError(static::CANNOT_UPDATE_SHOPPING_LIST);

            return $shoppingListResponseTransfer;
        }

        $shoppingListResponseTransfer->setIsSuccess(true);
        $shoppingListResponseTransfer->setShoppingList($this->saveShoppingList($shoppingListTransfer));

        return $shoppingListResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function removeShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        $shoppingListTransfer = $this->shoppingListRepository->findShoppingListById($shoppingListTransfer);

        if (!$shoppingListTransfer) {
            return $this->createShoppingListErrorResponseTransfer(static::GLOSSARY_KEY_SHOPPING_LIST_NOT_FOUND);
        }

        if (!$this->checkWritePermission($shoppingListTransfer)) {
            return $this->createShoppingListErrorResponseTransfer(static::GLOSSARY_KEY_CUSTOMER_ACCOUNT_SHOPPING_LIST_DELETE_FAILED);
        }

        return $this->getTransactionHandler()->handleTransaction(
            function () use ($shoppingListTransfer) {
                return $this->executeRemoveShoppingListTransaction($shoppingListTransfer);
            }
        );
    }

    /**
     * @param string $message
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    protected function createShoppingListErrorResponseTransfer(string $message): ShoppingListResponseTransfer
    {
        $shoppingListResponseTransfer = new ShoppingListResponseTransfer();
        $shoppingListResponseTransfer->addError($message);
        $shoppingListResponseTransfer->setIsSuccess(false);

        return $shoppingListResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    public function saveShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListTransfer
    {
        return $this->shoppingListEntityManager->saveShoppingList($shoppingListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return bool
     */
    protected function checkShoppingListWithSameName(ShoppingListTransfer $shoppingListTransfer): bool
    {
        $foundShoppingListTransfer = $this->findCustomerShoppingListByName($shoppingListTransfer);

        return $foundShoppingListTransfer && ($foundShoppingListTransfer->getIdShoppingList() !== $shoppingListTransfer->getIdShoppingList());
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer|null
     */
    public function findCustomerShoppingListByName(ShoppingListTransfer $shoppingListTransfer): ?ShoppingListTransfer
    {
        $shoppingListTransfer->requireName();
        $shoppingListTransfer->requireCustomerReference();

        return $this->shoppingListRepository->findCustomerShoppingListByName($shoppingListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return bool
     */
    protected function checkWritePermission(ShoppingListTransfer $shoppingListTransfer): bool
    {
        if (!$shoppingListTransfer->getIdShoppingList()) {
            return true;
        }

        if (!$shoppingListTransfer->getIdCompanyUser()) {
            return false;
        }

        return $this->can(
            'WriteShoppingListPermissionPlugin',
            $shoppingListTransfer->getIdCompanyUser(),
            $shoppingListTransfer->getIdShoppingList()
        );
    }

    /**
     * @param string $shoppingListName
     *
     * @return void
     */
    protected function addCreateSuccessMessage(string $shoppingListName): void
    {
        $this->messengerFacade->addSuccessMessage(
            (new MessageTransfer())
                ->setValue(static::GLOSSARY_KEY_CUSTOMER_ACCOUNT_SHOPPING_LIST_CREATE_SUCCESS)
                ->setParameters([static::GLOSSARY_PARAM_NAME => $shoppingListName])
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    protected function executeRemoveShoppingListTransaction(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        $this->shoppingListEntityManager->deleteShoppingListItems($shoppingListTransfer);
        $this->shoppingListEntityManager->deleteShoppingListCompanyUsers($shoppingListTransfer);
        $this->shoppingListEntityManager->deleteShoppingListCompanyBusinessUnits($shoppingListTransfer);
        $this->shoppingListEntityManager->deleteShoppingListByName($shoppingListTransfer);
        $this->triggerShoppingListUnpublishEvent($shoppingListTransfer);

        return (new ShoppingListResponseTransfer())->setIsSuccess(true);
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return void
     */
    protected function triggerShoppingListUnpublishEvent(ShoppingListTransfer $shoppingListTransfer): void
    {
        $eventTransfer = (new EventEntityTransfer())
            ->setName(ShoppingListEvents::SHOPPING_LIST_UNPUBLISH)
            ->setId($shoppingListTransfer->getIdShoppingList())
            ->setEvent(ShoppingListEvents::SHOPPING_LIST_UNPUBLISH)
            ->setModifiedColumns([
                 $shoppingListTransfer->getCustomerReference() => ShoppingListTransfer::CUSTOMER_REFERENCE,
            ]);
        $this->eventFacade->trigger(ShoppingListEvents::SHOPPING_LIST_UNPUBLISH, $eventTransfer);
    }
}
