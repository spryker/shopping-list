<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business\Model;

use Generated\Shared\Transfer\ItemCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShoppingListFromCartRequestTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToPersistentCartFacadeInterface;

class QuoteToShoppingListConverter implements QuoteToShoppingListConverterInterface
{
    use TransactionTrait;

    /**
     * @var \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToPersistentCartFacadeInterface
     */
    protected $persistentCartFacade;

    /**
     * @var \Spryker\Zed\ShoppingList\Business\Model\ShoppingListResolverInterface
     */
    protected $shoppingListResolver;

    /**
     * @var \Spryker\Zed\ShoppingList\Business\Model\ShoppingListItemOperationInterface
     */
    protected $shoppingListItemOperation;

    /**
     * @var \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\QuoteItemsPreConvertPluginInterface[]
     */
    protected $quoteItemExpanderPlugins;

    /**
     * @var \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ItemToShoppingListItemMapperPluginInterface[]
     */
    protected $itemToShoppingListItemMapperPlugins;

    /**
     * @param \Spryker\Zed\ShoppingList\Business\Model\ShoppingListResolverInterface $shoppingListResolver
     * @param \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToPersistentCartFacadeInterface $persistentCartFacade
     * @param \Spryker\Zed\ShoppingList\Business\Model\ShoppingListItemOperationInterface $shoppingListItemOperation
     * @param \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\QuoteItemsPreConvertPluginInterface[] $quoteItemExpanderPlugins
     * @param \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ItemToShoppingListItemMapperPluginInterface[] $itemToShoppingListItemMapperPlugins
     */
    public function __construct(
        ShoppingListResolverInterface $shoppingListResolver,
        ShoppingListToPersistentCartFacadeInterface $persistentCartFacade,
        ShoppingListItemOperationInterface $shoppingListItemOperation,
        array $quoteItemExpanderPlugins,
        array $itemToShoppingListItemMapperPlugins
    ) {
        $this->persistentCartFacade = $persistentCartFacade;
        $this->shoppingListResolver = $shoppingListResolver;
        $this->shoppingListItemOperation = $shoppingListItemOperation;
        $this->shoppingListItemOperation = $shoppingListItemOperation;
        $this->quoteItemExpanderPlugins = $quoteItemExpanderPlugins;
        $this->itemToShoppingListItemMapperPlugins = $itemToShoppingListItemMapperPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    public function createShoppingListFromQuote(ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer): ShoppingListTransfer
    {
        $shoppingListFromCartRequestTransfer->requireShoppingListName()->requireIdQuote();

        return $this->getTransactionHandler()->handleTransaction(function () use ($shoppingListFromCartRequestTransfer) {
            return $this->executeCreateShoppingListFromQuoteTransaction($shoppingListFromCartRequestTransfer);
        });
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    protected function executeCreateShoppingListFromQuoteTransaction(
        ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer
    ): ShoppingListTransfer {
        $quoteResponseTransfer = $this->persistentCartFacade->findQuote(
            $shoppingListFromCartRequestTransfer->getIdQuote(),
            $shoppingListFromCartRequestTransfer->getCustomer()
        );

        $shoppingListTransfer = $this->shoppingListResolver->createShoppingListIfNotExists(
            $shoppingListFromCartRequestTransfer->getCustomer()->getCustomerReference(),
            $shoppingListFromCartRequestTransfer->getShoppingListName()
        );

        $itemTransferCollection = $this->getQuoteItems($quoteResponseTransfer->getQuoteTransfer());

        $this->createShoppingListItems($itemTransferCollection, $shoppingListTransfer);

        return $shoppingListTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ItemCollectionTransfer
     */
    protected function getQuoteItems(QuoteTransfer $quoteTransfer): ItemCollectionTransfer
    {
        $itemTransferCollection = (new ItemCollectionTransfer())
            ->setItems($quoteTransfer->getItems());

        foreach ($this->quoteItemExpanderPlugins as $expanderPlugin) {
            $itemTransferCollection = $expanderPlugin->expand($itemTransferCollection, $quoteTransfer);
        }

        return $itemTransferCollection;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemCollectionTransfer $itemCollectionTransfer
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return void
     */
    protected function createShoppingListItems(
        ItemCollectionTransfer $itemCollectionTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): void {
        foreach ($itemCollectionTransfer->getItems() as $item) {
            $shoppingListItemTransfer = (new ShoppingListItemTransfer())
                ->setFkShoppingList($shoppingListTransfer->getIdShoppingList())
                ->setQuantity($item->getQuantity())
                ->setSku($item->getSku());

            foreach ($this->itemToShoppingListItemMapperPlugins as $itemToShoppingListItemMapperPlugin) {
                $shoppingListItemTransfer = $itemToShoppingListItemMapperPlugin->map($item, $shoppingListItemTransfer);
            }

            $this->shoppingListItemOperation->saveShoppingListItemWithoutPermissionsCheck($shoppingListItemTransfer);
        }
    }
}
