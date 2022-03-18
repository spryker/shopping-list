<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\ShoppingList\Business\Installer\ShoppingListPermissionInstaller;
use Spryker\Zed\ShoppingList\Business\Installer\ShoppingListPermissionInstallerInterface;
use Spryker\Zed\ShoppingList\Business\Model\QuoteToShoppingListConverter;
use Spryker\Zed\ShoppingList\Business\Model\QuoteToShoppingListConverterInterface;
use Spryker\Zed\ShoppingList\Business\Model\ShoppingListItemOperation;
use Spryker\Zed\ShoppingList\Business\Model\ShoppingListItemOperationInterface;
use Spryker\Zed\ShoppingList\Business\Model\ShoppingListReader;
use Spryker\Zed\ShoppingList\Business\Model\ShoppingListReaderInterface;
use Spryker\Zed\ShoppingList\Business\Model\ShoppingListResolver;
use Spryker\Zed\ShoppingList\Business\Model\ShoppingListResolverInterface;
use Spryker\Zed\ShoppingList\Business\Model\ShoppingListSharer;
use Spryker\Zed\ShoppingList\Business\Model\ShoppingListSharerInterface;
use Spryker\Zed\ShoppingList\Business\Model\ShoppingListWriter;
use Spryker\Zed\ShoppingList\Business\Model\ShoppingListWriterInterface;
use Spryker\Zed\ShoppingList\Business\Product\ProductConcreteIsActiveChecker;
use Spryker\Zed\ShoppingList\Business\Product\ProductConcreteIsActiveCheckerInterface;
use Spryker\Zed\ShoppingList\Business\ShoppingList\ShoppingListShareDeleter;
use Spryker\Zed\ShoppingList\Business\ShoppingList\ShoppingListShareDeleterInterface;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Messenger\ShoppingListItemMessageAdder;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Messenger\ShoppingListItemMessageAdderInterface;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\ShoppingListItemChecker;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\ShoppingListItemCheckerInterface;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\ShoppingListItemPluginExecutor;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\ShoppingListItemPluginExecutorInterface;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemAddOperationValidator;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemAddOperationValidatorInterface;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemDeleteOperationValidator;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemDeleteOperationValidatorInterface;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemOperationValidator;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemOperationValidatorInterface;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemPermissionValidator;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemPermissionValidatorInterface;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemUpdateOperationValidator;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemUpdateOperationValidatorInterface;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemValidator;
use Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemValidatorInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToCompanyUserFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToEventFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToMessengerFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToPermissionFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToPersistentCartFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToProductFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToStoreFacadeInterface;
use Spryker\Zed\ShoppingList\ShoppingListDependencyProvider;

/**
 * @method \Spryker\Zed\ShoppingList\Persistence\ShoppingListEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\ShoppingList\Persistence\ShoppingListRepositoryInterface getRepository()
 * @method \Spryker\Zed\ShoppingList\ShoppingListConfig getConfig()
 */
class ShoppingListBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\ShoppingList\Business\Model\ShoppingListReaderInterface
     */
    public function createShoppingListReader(): ShoppingListReaderInterface
    {
        return new ShoppingListReader(
            $this->getRepository(),
            $this->getProductFacade(),
            $this->getCompanyUserFacade(),
            $this->createShoppingListItemPluginExecutor(),
            $this->getMessengerFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\Model\ShoppingListWriterInterface
     */
    public function createShoppingListWriter(): ShoppingListWriterInterface
    {
        return new ShoppingListWriter(
            $this->getEntityManager(),
            $this->getRepository(),
            $this->getEventFacade(),
            $this->createShoppingListItemOperation(),
            $this->createShoppingListReader(),
            $this->createShoppingListItemPluginExecutor(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\Model\ShoppingListResolverInterface
     */
    public function createShoppingListResolver(): ShoppingListResolverInterface
    {
        return new ShoppingListResolver(
            $this->getEntityManager(),
            $this->getRepository(),
            $this->getMessengerFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\Model\ShoppingListItemOperationInterface
     */
    public function createShoppingListItemOperation(): ShoppingListItemOperationInterface
    {
        return new ShoppingListItemOperation(
            $this->getEntityManager(),
            $this->getRepository(),
            $this->createShoppingListResolver(),
            $this->createShoppingListItemOperationValidator(),
            $this->createShoppingListItemPluginExecutor(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\Product\ProductConcreteIsActiveCheckerInterface
     */
    public function createProductConcreteIsActiveChecker(): ProductConcreteIsActiveCheckerInterface
    {
        return new ProductConcreteIsActiveChecker($this->getProductFacade());
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\ShoppingListItem\ShoppingListItemPluginExecutorInterface
     */
    public function createShoppingListItemPluginExecutor(): ShoppingListItemPluginExecutorInterface
    {
        return new ShoppingListItemPluginExecutor(
            $this->getMessengerFacade(),
            $this->getShoppingListItemBeforeDeletePlugins(),
            $this->getShoppingListItemPostSavePlugins(),
            $this->getAddItemPreCheckPlugins(),
            $this->getItemExpanderPlugins(),
            $this->getItemCollectionExpanderPlugins(),
            $this->getShoppingListItemBulkPostSavePlugins(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\Model\QuoteToShoppingListConverterInterface
     */
    public function createQuoteToShoppingListConverter(): QuoteToShoppingListConverterInterface
    {
        return new QuoteToShoppingListConverter(
            $this->createShoppingListResolver(),
            $this->getRepository(),
            $this->getPersistentCartFacade(),
            $this->createShoppingListItemOperation(),
            $this->getQuoteItemExpanderPlugins(),
            $this->getItemToShoppingListItemMapperPlugins(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\Model\ShoppingListSharerInterface
     */
    public function createShoppingListSharer(): ShoppingListSharerInterface
    {
        return new ShoppingListSharer(
            $this->getEntityManager(),
            $this->getRepository(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemOperationValidatorInterface
     */
    public function createShoppingListItemOperationValidator(): ShoppingListItemOperationValidatorInterface
    {
        return new ShoppingListItemOperationValidator(
            $this->createShoppingListItemAddOperationValidator(),
            $this->createShoppingListItemUpdateOperationValidator(),
            $this->createShoppingListItemDeleteOperationValidator(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemAddOperationValidatorInterface
     */
    public function createShoppingListItemAddOperationValidator(): ShoppingListItemAddOperationValidatorInterface
    {
        return new ShoppingListItemAddOperationValidator(
            $this->createShoppingListItemValidator(),
            $this->createShoppingListItemMessageAdder(),
            $this->createShoppingListItemPluginExecutor(),
            $this->createShoppingListItemPermissionValidator(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemUpdateOperationValidatorInterface
     */
    public function createShoppingListItemUpdateOperationValidator(): ShoppingListItemUpdateOperationValidatorInterface
    {
        return new ShoppingListItemUpdateOperationValidator($this->createShoppingListItemValidator());
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemDeleteOperationValidatorInterface
     */
    public function createShoppingListItemDeleteOperationValidator(): ShoppingListItemDeleteOperationValidatorInterface
    {
        return new ShoppingListItemDeleteOperationValidator($this->createShoppingListItemValidator());
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemValidatorInterface
     */
    public function createShoppingListItemValidator(): ShoppingListItemValidatorInterface
    {
        return new ShoppingListItemValidator(
            $this->getRepository(),
            $this->createShoppingListItemPermissionValidator(),
            $this->getProductFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemPermissionValidatorInterface
     */
    public function createShoppingListItemPermissionValidator(): ShoppingListItemPermissionValidatorInterface
    {
        return new ShoppingListItemPermissionValidator();
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\ShoppingListItem\Messenger\ShoppingListItemMessageAdderInterface
     */
    public function createShoppingListItemMessageAdder(): ShoppingListItemMessageAdderInterface
    {
        return new ShoppingListItemMessageAdder($this->getMessengerFacade());
    }

    /**
     * @return array<\Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ItemExpanderPluginInterface>
     */
    public function getItemExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_ITEM_EXPANDER);
    }

    /**
     * @return array<\Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ShoppingListItemCollectionExpanderPluginInterface>
     */
    public function getItemCollectionExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_ITEM_COLLECTION_EXPANDER);
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToProductFacadeInterface
     */
    public function getProductFacade(): ShoppingListToProductFacadeInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\Installer\ShoppingListPermissionInstallerInterface
     */
    public function createShoppingListPermissionInstaller(): ShoppingListPermissionInstallerInterface
    {
        return new ShoppingListPermissionInstaller($this->getConfig(), $this->getEntityManager(), $this->getPermissionFacade());
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\ShoppingList\ShoppingListShareDeleterInterface
     */
    public function createShoppingListShareDeleter(): ShoppingListShareDeleterInterface
    {
        return new ShoppingListShareDeleter(
            $this->getEntityManager(),
            $this->getRepository(),
            $this->getCompanyUserFacade(),
            $this->getEventFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToPermissionFacadeInterface
     */
    public function getPermissionFacade(): ShoppingListToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::FACADE_PERMISSION);
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToCompanyUserFacadeInterface
     */
    public function getCompanyUserFacade(): ShoppingListToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::FACADE_COMPANY_USER);
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToPersistentCartFacadeInterface
     */
    public function getPersistentCartFacade(): ShoppingListToPersistentCartFacadeInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::FACADE_PERSISTENT_CART);
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToMessengerFacadeInterface
     */
    public function getMessengerFacade(): ShoppingListToMessengerFacadeInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::FACADE_MESSENGER);
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToEventFacadeInterface
     */
    public function getEventFacade(): ShoppingListToEventFacadeInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::FACADE_EVENT);
    }

    /**
     * @return array<\Spryker\Zed\ShoppingListExtension\Dependency\Plugin\QuoteItemsPreConvertPluginInterface>
     */
    public function getQuoteItemExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_QUOTE_ITEM_EXPANDER);
    }

    /**
     * @return array<\Spryker\Zed\ShoppingListExtension\Dependency\Plugin\AddItemPreCheckPluginInterface>
     */
    public function getAddItemPreCheckPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_ADD_ITEM_PRE_CHECK);
    }

    /**
     * @return array<\Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ShoppingListItemPostSavePluginInterface>
     */
    public function getShoppingListItemPostSavePlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_SHOPPING_LIST_ITEM_POST_SAVE);
    }

    /**
     * @return array<\Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ShoppingListItemBulkPostSavePluginInterface>
     */
    public function getShoppingListItemBulkPostSavePlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_SHOPPING_LIST_ITEM_BULK_POST_SAVE);
    }

    /**
     * @return array<\Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ShoppingListItemBeforeDeletePluginInterface>
     */
    public function getShoppingListItemBeforeDeletePlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_SHOPPING_LIST_ITEM_BEFORE_DELETE);
    }

    /**
     * @return array<\Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ItemToShoppingListItemMapperPluginInterface>
     */
    public function getItemToShoppingListItemMapperPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_ITEM_TO_SHOPPING_LIST_ITEM_MAPPER);
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\ShoppingListItem\ShoppingListItemCheckerInterface
     */
    public function createShoppingListItemChecker(): ShoppingListItemCheckerInterface
    {
        return new ShoppingListItemChecker(
            $this->getStoreFacade(),
            $this->getProductFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToStoreFacadeInterface
     */
    public function getStoreFacade(): ShoppingListToStoreFacadeInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::FACADE_STORE);
    }
}
