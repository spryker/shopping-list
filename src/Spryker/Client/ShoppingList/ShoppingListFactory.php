<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ShoppingList\Calculation\ShoppingListSubtotalCalculator;
use Spryker\Client\ShoppingList\Calculation\ShoppingListSubtotalCalculatorInterface;
use Spryker\Client\ShoppingList\Cart\CartHandler;
use Spryker\Client\ShoppingList\Cart\CartHandlerInterface;
use Spryker\Client\ShoppingList\Creator\ShoppingListCreator;
use Spryker\Client\ShoppingList\Creator\ShoppingListCreatorInterface;
use Spryker\Client\ShoppingList\Creator\ShoppingListItemCreator;
use Spryker\Client\ShoppingList\Creator\ShoppingListItemCreatorInterface;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToCartClientInterface;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToCustomerClientInterface;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToMessengerClientInterface;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToPriceProductClientInterface;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToProductClientInterface;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToSessionClientInterface;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface;
use Spryker\Client\ShoppingList\PermissionUpdater\PermissionUpdater;
use Spryker\Client\ShoppingList\PermissionUpdater\PermissionUpdaterInterface;
use Spryker\Client\ShoppingList\Product\ProductStorage;
use Spryker\Client\ShoppingList\Product\ProductStorageInterface;
use Spryker\Client\ShoppingList\Remover\ShoppingListItemRemover;
use Spryker\Client\ShoppingList\Remover\ShoppingListItemRemoverInterface;
use Spryker\Client\ShoppingList\Remover\ShoppingListRemover;
use Spryker\Client\ShoppingList\Remover\ShoppingListRemoverInterface;
use Spryker\Client\ShoppingList\Remover\ShoppingListSessionRemover;
use Spryker\Client\ShoppingList\Remover\ShoppingListSessionRemoverInterface;
use Spryker\Client\ShoppingList\ShoppingList\ShoppingListAddItemExpander;
use Spryker\Client\ShoppingList\ShoppingList\ShoppingListAddItemExpanderInterface;
use Spryker\Client\ShoppingList\Updater\ShoppingListUpdater;
use Spryker\Client\ShoppingList\Updater\ShoppingListUpdaterInterface;
use Spryker\Client\ShoppingList\Zed\ShoppingListStub;
use Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface;

class ShoppingListFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface
     */
    public function createShoppingListStub(): ShoppingListStubInterface
    {
        return new ShoppingListStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ShoppingList\Product\ProductStorageInterface
     */
    public function createProductStorage(): ProductStorageInterface
    {
        return new ProductStorage(
            $this->getProductClient(),
            $this->getPriceProductClient(),
        );
    }

    /**
     * @return \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToProductClientInterface
     */
    public function getProductClient(): ShoppingListToProductClientInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::CLIENT_PRODUCT);
    }

    /**
     * @return \Spryker\Client\ShoppingList\Cart\CartHandlerInterface
     */
    public function createCartHandler(): CartHandlerInterface
    {
        return new CartHandler(
            $this->getCartClient(),
            $this->createShoppingListStub(),
            $this->getMessengerClient(),
            $this->getShoppingListItemToItemMapperPlugins(),
            $this->getQuoteItemToItemMapperPlugins(),
        );
    }

    /**
     * @return \Spryker\Client\ShoppingList\ShoppingList\ShoppingListAddItemExpanderInterface
     */
    public function createShoppingListAddItemExpander(): ShoppingListAddItemExpanderInterface
    {
        return new ShoppingListAddItemExpander(
            $this->getAddItemShoppingListItemMapperPlugins(),
        );
    }

    /**
     * @return \Spryker\Client\ShoppingList\Calculation\ShoppingListSubtotalCalculatorInterface
     */
    public function createShoppingListSubtotalCalculator(): ShoppingListSubtotalCalculatorInterface
    {
        return new ShoppingListSubtotalCalculator();
    }

    /**
     * @return \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToCustomerClientInterface
     */
    public function getCustomerClient(): ShoppingListToCustomerClientInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::CLIENT_CUSTOMER);
    }

    /**
     * @return \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToPriceProductClientInterface
     */
    public function getPriceProductClient(): ShoppingListToPriceProductClientInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::CLIENT_PRICE_PRODUCT);
    }

    /**
     * @return \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface
     */
    public function getZedRequestClient(): ShoppingListToZedRequestClientInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::CLIENT_ZED_REQUEST);
    }

    /**
     * @return \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToCartClientInterface
     */
    public function getCartClient(): ShoppingListToCartClientInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::CLIENT_CART);
    }

    /**
     * @return \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToMessengerClientInterface
     */
    public function getMessengerClient(): ShoppingListToMessengerClientInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::CLIENT_MESSENGER);
    }

    /**
     * @return \Spryker\Client\ShoppingList\PermissionUpdater\PermissionUpdaterInterface
     */
    public function createPermissionUpdater(): PermissionUpdaterInterface
    {
        return new PermissionUpdater($this->getCustomerClient());
    }

    /**
     * @return array<\Spryker\Client\ShoppingListExtension\Dependency\Plugin\ShoppingListItemToItemMapperPluginInterface>
     */
    public function getShoppingListItemToItemMapperPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_SHOPPING_LIST_ITEM_TO_ITEM_MAPPER);
    }

    /**
     * @return array<\Spryker\Client\ShoppingListExtension\Dependency\Plugin\QuoteItemToItemMapperPluginInterface>
     */
    public function getQuoteItemToItemMapperPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_QUOTE_ITEM_TO_ITEM_MAPPER);
    }

    /**
     * @return array<\Spryker\Client\ShoppingListExtension\Dependency\Plugin\ShoppingListItemMapperPluginInterface>
     */
    public function getAddItemShoppingListItemMapperPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_ADD_ITEM_SHOPPING_LIST_ITEM_MAPPER);
    }

    /**
     * @return \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToSessionClientInterface
     */
    public function getSessionClient(): ShoppingListToSessionClientInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::CLIENT_SESSION);
    }

    /**
     * @return \Spryker\Client\ShoppingList\Remover\ShoppingListSessionRemoverInterface
     */
    public function createShoppingListSessionRemover(): ShoppingListSessionRemoverInterface
    {
        return new ShoppingListSessionRemover(
            $this->getSessionClient(),
        );
    }

    /**
     * @return \Spryker\Client\ShoppingList\Creator\ShoppingListCreatorInterface
     */
    public function createShoppingListCreator(): ShoppingListCreatorInterface
    {
        return new ShoppingListCreator(
            $this->createShoppingListStub(),
            $this->getZedRequestClient(),
            $this->createPermissionUpdater(),
            $this->createShoppingListSessionRemover(),
        );
    }

    /**
     * @return \Spryker\Client\ShoppingList\Creator\ShoppingListItemCreatorInterface
     */
    public function createShoppingListItemCreator(): ShoppingListItemCreatorInterface
    {
        return new ShoppingListItemCreator(
            $this->createShoppingListStub(),
            $this->getZedRequestClient(),
            $this->createPermissionUpdater(),
            $this->createShoppingListSessionRemover(),
            $this->createShoppingListAddItemExpander(),
            $this->getShoppingListExpanderPlugins(),
        );
    }

    /**
     * @return \Spryker\Client\ShoppingList\Updater\ShoppingListUpdaterInterface
     */
    public function createShoppingListUpdater(): ShoppingListUpdaterInterface
    {
        return new ShoppingListUpdater(
            $this->createShoppingListStub(),
            $this->getZedRequestClient(),
            $this->createPermissionUpdater(),
            $this->createShoppingListSessionRemover(),
        );
    }

    /**
     * @return \Spryker\Client\ShoppingList\Remover\ShoppingListRemoverInterface
     */
    public function createShoppingListRemover(): ShoppingListRemoverInterface
    {
        return new ShoppingListRemover(
            $this->createShoppingListStub(),
            $this->getZedRequestClient(),
            $this->createPermissionUpdater(),
            $this->createShoppingListSessionRemover(),
        );
    }

    /**
     * @return \Spryker\Client\ShoppingList\Remover\ShoppingListItemRemoverInterface
     */
    public function createShoppingListItemRemover(): ShoppingListItemRemoverInterface
    {
        return new ShoppingListItemRemover(
            $this->createShoppingListStub(),
            $this->getZedRequestClient(),
            $this->createShoppingListSessionRemover(),
        );
    }

    /**
     * @return array<\Spryker\Client\ShoppingListExtension\Dependency\Plugin\ShoppingListExpanderPluginInterface>
     */
    public function getShoppingListExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_SHOPPING_LIST_EXPANDER);
    }
}
