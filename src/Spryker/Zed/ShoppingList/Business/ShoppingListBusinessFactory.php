<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\ShoppingList\Business\Installer\ShoppingListPermissionInstaller;
use Spryker\Zed\ShoppingList\Business\Installer\ShoppingListPermissionInstallerInterface;
use Spryker\Zed\ShoppingList\Business\Model\Reader;
use Spryker\Zed\ShoppingList\Business\Model\ReaderInterface;
use Spryker\Zed\ShoppingList\Business\Model\Writer;
use Spryker\Zed\ShoppingList\Business\Model\WriterInterface;
use Spryker\Zed\ShoppingList\Dependency\Client\ShoppingListToCustomerClientInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToPermissionFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToProductFacadeInterface;
use Spryker\Zed\ShoppingList\ShoppingListDependencyProvider;

/**
 * @method \Spryker\Zed\ShoppingList\Persistence\ShoppingListEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\ShoppingList\Persistence\ShoppingListRepositoryInterface getRepository()
 * @method \Spryker\Zed\ShoppingList\ShoppingListConfig getConfig()
 */
class ShoppingListBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\ShoppingList\Business\Model\ReaderInterface
     */
    public function createReader(): ReaderInterface
    {
        return new Reader(
            $this->getRepository(),
            $this->getProductFacade(),
            $this->getItemExpanderPlugins()
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Business\Model\WriterInterface
     */
    public function createWriter(): WriterInterface
    {
        return new Writer(
            $this->getEntityManager(),
            $this->getRepository(),
            $this->getConfig(),
            $this->getProductFacade()
        );
    }

    /**
     * @return \Spryker\Zed\ShoppingList\Dependency\Plugin\ItemExpanderPluginInterface[]
     */
    public function getItemExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::PLUGINS_ITEM_EXPANDER);
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
     * @return \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToPermissionFacadeInterface
     */
    public function getPermissionFacade(): ShoppingListToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(ShoppingListDependencyProvider::FACADE_PERMISSION);
    }
}
