<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Persistence;

use Generated\Shared\Transfer\ShoppingListCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyBusinessUnitBlacklistTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyBusinessUnitCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyUserCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyUserTransfer;
use Generated\Shared\Transfer\ShoppingListCriteriaTransfer;
use Generated\Shared\Transfer\ShoppingListItemCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemCriteriaTransfer;
use Generated\Shared\Transfer\ShoppingListOverviewRequestTransfer;
use Generated\Shared\Transfer\ShoppingListOverviewResponseTransfer;
use Generated\Shared\Transfer\ShoppingListPermissionGroupCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;

/**
 * @method \Spryker\Zed\ShoppingList\Persistence\ShoppingListPersistenceFactory getFactory()
 */
interface ShoppingListRepositoryInterface
{
    public function findCustomerShoppingListByName(ShoppingListTransfer $shoppingListTransfer): ?ShoppingListTransfer;

    public function findCustomerShoppingListById(ShoppingListTransfer $shoppingListTransfer): ?ShoppingListTransfer;

    public function findShoppingListPaginatedItems(
        ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer
    ): ShoppingListOverviewResponseTransfer;

    public function findCustomerShoppingLists(string $customerReference): ShoppingListCollectionTransfer;

    public function findShoppingListById(ShoppingListTransfer $shoppingListTransfer): ?ShoppingListTransfer;

    public function findShoppingListByUuid(ShoppingListTransfer $shoppingListTransfer): ?ShoppingListTransfer;

    public function findShoppingListItemsByIdShoppingList(int $idShoppingList): ShoppingListItemCollectionTransfer;

    /**
     * @param array<int> $shoppingListIds
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function findCustomerShoppingListsItemsByIds(array $shoppingListIds): ShoppingListItemCollectionTransfer;

    /**
     * @param array<int> $shoppingListItemIds
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function findShoppingListItemsByIds(array $shoppingListItemIds): ShoppingListItemCollectionTransfer;

    /**
     * @param array<string> $shoppingListItemUuids
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function getShoppingListItemsByUuids(array $shoppingListItemUuids): ShoppingListItemCollectionTransfer;

    public function getShoppingListPermissionGroups(): ShoppingListPermissionGroupCollectionTransfer;

    public function getShoppingListCollection(ShoppingListCriteriaTransfer $shoppingListCriteriaTransfer): ShoppingListCollectionTransfer;

    public function getShoppingListItemCollection(ShoppingListItemCriteriaTransfer $shoppingListItemCriteriaTransfer): ShoppingListItemCollectionTransfer;

    public function isShoppingListSharedWithCompanyBusinessUnit(int $idShoppingList, int $idCompanyBusinessUnit): bool;

    public function isShoppingListSharedWithCompanyUser(int $idShoppingList, int $idCompanyUser): bool;

    /**
     * @param int $idCompanyBusinessUnit
     *
     * @return array<\Orm\Zed\ShoppingList\Persistence\SpyShoppingListCompanyBusinessUnit>
     */
    public function findCompanyBusinessUnitSharedShoppingListsIds(int $idCompanyBusinessUnit);

    /**
     * @param int $idCompanyBusinessUnit
     * @param string $shoppingListPermissionGroupName
     *
     * @return array<int>
     */
    public function getCompanyBusinessUnitSharedShoppingListIdsByPermissionGroupName(
        int $idCompanyBusinessUnit,
        string $shoppingListPermissionGroupName
    ): array;

    /**
     * @param int $idCompanyUser
     *
     * @return array<\Orm\Zed\ShoppingList\Persistence\SpyShoppingListCompanyUser>
     */
    public function findCompanyUserSharedShoppingListsIds(int $idCompanyUser);

    /**
     * @param int $idCompanyUser
     * @param string $shoppingListPermissionGroupName
     *
     * @return array<int>
     */
    public function getCompanyUserSharedShoppingListIdsByPermissionGroupName(int $idCompanyUser, string $shoppingListPermissionGroupName): array;

    public function findCompanyUserSharedShoppingLists(int $idCompanyUser): ShoppingListCollectionTransfer;

    public function findCompanyBusinessUnitSharedShoppingLists(int $idCompanyBusinessUnit): ShoppingListCollectionTransfer;

    public function isCompanyBusinessUnitSharedWithShoppingLists(int $idCompanyBusinessUnit): bool;

    public function getShoppingListCompanyBusinessUnitsByShoppingListId(
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListCompanyBusinessUnitCollectionTransfer;

    public function getShoppingListCompanyUsersByShoppingListId(ShoppingListTransfer $shoppingListTransfer): ShoppingListCompanyUserCollectionTransfer;

    public function findShoppingListCompanyUser(ShoppingListCompanyUserTransfer $shoppingListCompanyUserTransfer): ?ShoppingListCompanyUserTransfer;

    public function findShoppingListCompanyBusinessUnitBlackList(
        ShoppingListCompanyBusinessUnitBlacklistTransfer $shoppingListCompanyBusinessUnitBlacklistTransfer
    ): ?ShoppingListCompanyBusinessUnitBlacklistTransfer;

    /**
     * @param int $idCompanyUser
     *
     * @return array<int>
     */
    public function getBlacklistedShoppingListIdsByIdCompanyUser(int $idCompanyUser): array;
}
