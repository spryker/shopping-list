<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business\Model;

use Generated\Shared\Transfer\EventEntityTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Zed\Kernel\PermissionAwareTrait;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\ShoppingListItemPluginExecutorInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToEventFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\ShoppingListEvents;
use Spryker\Zed\ShoppingList\Persistence\ShoppingListEntityManagerInterface;
use Spryker\Zed\ShoppingList\Persistence\ShoppingListRepositoryInterface;

class ShoppingListWriter implements ShoppingListWriterInterface
{
    use TransactionTrait;
    use PermissionAwareTrait;

    /**
     * @var string
     */
    protected const DUPLICATE_NAME_SHOPPING_LIST = 'customer.account.shopping_list.error.duplicate_name';

    /**
     * @var string
     */
    protected const CANNOT_UPDATE_SHOPPING_LIST = 'customer.account.shopping_list.error.cannot_update';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_CUSTOMER_ACCOUNT_SHOPPING_LIST_DELETE_FAILED = 'customer.account.shopping_list.delete.failed';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_SHOPPING_LIST_NOT_FOUND = 'shopping_list.not_found';

    /**
     * @var \Spryker\Zed\ShoppingList\Persistence\ShoppingListEntityManagerInterface
     */
    protected $shoppingListEntityManager;

    /**
     * @var \Spryker\Zed\ShoppingList\Persistence\ShoppingListRepositoryInterface
     */
    protected $shoppingListRepository;

    /**
     * @var \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToEventFacadeInterface
     */
    protected $eventFacade;

    /**
     * @var \Spryker\Zed\ShoppingList\Business\Model\ShoppingListItemOperationInterface
     */
    protected $shoppingListItemOperation;

    /**
     * @var \Spryker\Zed\ShoppingList\Business\Model\ShoppingListReaderInterface
     */
    protected $shoppingListReader;

    /**
     * @var \Spryker\Zed\ShoppingList\Business\ShoppingListItem\ShoppingListItemPluginExecutorInterface
     */
    protected $pluginExecutor;

    public function __construct(
        ShoppingListEntityManagerInterface $shoppingListEntityManager,
        ShoppingListRepositoryInterface $shoppingListRepository,
        ShoppingListToEventFacadeInterface $eventFacade,
        ShoppingListItemOperationInterface $shoppingListItemOperation,
        ShoppingListReaderInterface $shoppingListReader,
        ShoppingListItemPluginExecutorInterface $pluginExecutor
    ) {
        $this->shoppingListEntityManager = $shoppingListEntityManager;
        $this->shoppingListRepository = $shoppingListRepository;
        $this->eventFacade = $eventFacade;
        $this->shoppingListItemOperation = $shoppingListItemOperation;
        $this->shoppingListReader = $shoppingListReader;
        $this->pluginExecutor = $pluginExecutor;
    }

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
            },
        );
    }

    protected function createShoppingListErrorResponseTransfer(string $message): ShoppingListResponseTransfer
    {
        $shoppingListResponseTransfer = new ShoppingListResponseTransfer();
        $shoppingListResponseTransfer->addError($message);
        $shoppingListResponseTransfer->setIsSuccess(false);

        return $shoppingListResponseTransfer;
    }

    public function saveShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListTransfer
    {
        return $this->getTransactionHandler()->handleTransaction(
            function () use ($shoppingListTransfer) {
                return $this->executeSaveShoppingListTransaction($shoppingListTransfer);
            },
        );
    }

    public function clearShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        $shoppingListTransfer = $this->shoppingListReader->getShoppingList($shoppingListTransfer);

        if (!$this->checkWritePermission($shoppingListTransfer)) {
            return (new ShoppingListResponseTransfer())->setIsSuccess(false);
        }

        return $this->deleteShoppingListItems($shoppingListTransfer);
    }

    protected function deleteShoppingListItems(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        $this->getTransactionHandler()->handleTransaction(function () use ($shoppingListTransfer) {
            $this->executeDeleteShoppingListItemsTransaction($shoppingListTransfer);
        });

        return (new ShoppingListResponseTransfer())->setIsSuccess(true);
    }

    protected function checkShoppingListWithSameName(ShoppingListTransfer $shoppingListTransfer): bool
    {
        $foundShoppingListTransfer = $this->findCustomerShoppingListByName($shoppingListTransfer);

        return $foundShoppingListTransfer && ($foundShoppingListTransfer->getIdShoppingList() !== $shoppingListTransfer->getIdShoppingList());
    }

    public function findCustomerShoppingListByName(ShoppingListTransfer $shoppingListTransfer): ?ShoppingListTransfer
    {
        $shoppingListTransfer->requireName();
        $shoppingListTransfer->requireCustomerReference();

        return $this->shoppingListRepository->findCustomerShoppingListByName($shoppingListTransfer);
    }

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
            $shoppingListTransfer->getIdShoppingList(),
        );
    }

    protected function executeRemoveShoppingListTransaction(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        $this->shoppingListItemOperation->deleteShoppingListItems($shoppingListTransfer);
        $this->shoppingListEntityManager->deleteShoppingListCompanyUsers($shoppingListTransfer);
        $this->shoppingListEntityManager->deleteCompanyBusinessUnitBlacklistByShoppingListId($shoppingListTransfer->getIdShoppingList());
        $this->shoppingListEntityManager->deleteShoppingListCompanyBusinessUnits($shoppingListTransfer);
        $this->shoppingListEntityManager->deleteShoppingListByName($shoppingListTransfer);
        $this->triggerShoppingListUnpublishEvent($shoppingListTransfer);

        return (new ShoppingListResponseTransfer())->setIsSuccess(true);
    }

    protected function executeSaveShoppingListTransaction(ShoppingListTransfer $shoppingListTransfer): ShoppingListTransfer
    {
        $shoppingListTransfer = $this->shoppingListEntityManager->saveShoppingList($shoppingListTransfer);

        if (!$shoppingListTransfer->getItems()->count()) {
            return $shoppingListTransfer;
        }

        foreach ($shoppingListTransfer->getItems() as $shoppingListItemTransfer) {
            $this->shoppingListItemOperation->saveShoppingListItemWithoutPermissionsCheck($shoppingListItemTransfer);
        }

        return $shoppingListTransfer;
    }

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

    protected function executeDeleteShoppingListItemsTransaction(ShoppingListTransfer $shoppingListTransfer): void
    {
        foreach ($shoppingListTransfer->getItems() as $shoppingListItemTransfer) {
            $this->deleteShoppingListItem($shoppingListItemTransfer);
        }
    }

    protected function deleteShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): void
    {
        $shoppingListItemTransfer->requireIdShoppingListItem();

        $shoppingListItemTransfer = $this->pluginExecutor->executeBeforeDeletePlugins($shoppingListItemTransfer);
        $this->shoppingListEntityManager->deleteShoppingListItem($shoppingListItemTransfer->getIdShoppingListItem());
    }
}
