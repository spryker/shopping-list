<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Persistence;

use Orm\Zed\Permission\Persistence\SpyPermissionQuery;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListCompanyBusinessUnitBlacklistQuery;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListCompanyBusinessUnitQuery;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListCompanyUserQuery;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListItemQuery;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListPermissionGroupQuery;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListPermissionGroupToPermissionQuery;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListCompanyBusinessUnitMapper;
use Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListCompanyBusinessUnitMapperInterface;
use Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListCompanyUserMapper;
use Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListCompanyUserMapperInterface;
use Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListItemMapper;
use Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListItemMapperInterface;
use Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListMapper;
use Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListMapperInterface;
use Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListPermissionGroupMapper;
use Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListPermissionGroupMapperInterface;

/**
 * @method \Spryker\Zed\ShoppingList\ShoppingListConfig getConfig()
 * @method \Spryker\Zed\ShoppingList\Persistence\ShoppingListEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\ShoppingList\Persistence\ShoppingListRepositoryInterface getRepository()
 */
class ShoppingListPersistenceFactory extends AbstractPersistenceFactory
{
    public function createShoppingListQuery(): SpyShoppingListQuery
    {
        return SpyShoppingListQuery::create();
    }

    public function createShoppingListItemQuery(): SpyShoppingListItemQuery
    {
        return SpyShoppingListItemQuery::create();
    }

    public function createShoppingListPermissionGroupQuery(): SpyShoppingListPermissionGroupQuery
    {
        return SpyShoppingListPermissionGroupQuery::create();
    }

    public function createPermissionQuery(): SpyPermissionQuery
    {
        return SpyPermissionQuery::create();
    }

    public function createShoppingListPermissionGroupToPermissionQuery(): SpyShoppingListPermissionGroupToPermissionQuery
    {
        return SpyShoppingListPermissionGroupToPermissionQuery::create();
    }

    public function createShoppingListCompanyBusinessUnitQuery(): SpyShoppingListCompanyBusinessUnitQuery
    {
        return SpyShoppingListCompanyBusinessUnitQuery::create();
    }

    public function createShoppingListCompanyUserQuery(): SpyShoppingListCompanyUserQuery
    {
        return SpyShoppingListCompanyUserQuery::create();
    }

    public function createShoppingListCompanyBusinessUnitBlacklistPropelQuery(): SpyShoppingListCompanyBusinessUnitBlacklistQuery
    {
        return SpyShoppingListCompanyBusinessUnitBlacklistQuery::create();
    }

    public function createShoppingListMapper(): ShoppingListMapperInterface
    {
        return new ShoppingListMapper(
            $this->createShoppingListItemMapper(),
        );
    }

    public function createShoppingListItemMapper(): ShoppingListItemMapperInterface
    {
        return new ShoppingListItemMapper();
    }

    public function createShoppingListPermissionGroupMapper(): ShoppingListPermissionGroupMapperInterface
    {
        return new ShoppingListPermissionGroupMapper();
    }

    public function createShoppingListCompanyBusinessUnitMapper(): ShoppingListCompanyBusinessUnitMapperInterface
    {
        return new ShoppingListCompanyBusinessUnitMapper();
    }

    public function createShoppingListCompanyUserMapper(): ShoppingListCompanyUserMapperInterface
    {
        return new ShoppingListCompanyUserMapper();
    }
}
