<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Persistence;

use Generated\Shared\Transfer\PermissionTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyBusinessUnitBlacklistTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyUserTransfer;
use Generated\Shared\Transfer\ShoppingListItemCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Generated\Shared\Transfer\SpyShoppingListPermissionGroupEntityTransfer;

interface ShoppingListEntityManagerInterface
{
    public function saveShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListTransfer;

    public function deleteShoppingListByName(ShoppingListTransfer $shoppingListTransfer): void;

    public function deleteShoppingListItems(ShoppingListTransfer $shoppingListTransfer): void;

    public function saveShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;

    public function saveShoppingListItemByUuid(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;

    public function deleteShoppingListItem(int $idShoppingListItem): void;

    public function saveShoppingListPermissionGroup(
        SpyShoppingListPermissionGroupEntityTransfer $shoppingListPermissionGroupEntityTransfer
    ): SpyShoppingListPermissionGroupEntityTransfer;

    public function saveShoppingListPermissionGroupToPermission(
        SpyShoppingListPermissionGroupEntityTransfer $shoppingListPermissionGroupEntityTransfer,
        PermissionTransfer $permissionTransfer
    ): void;

    public function saveShoppingListCompanyBusinessUnit(ShoppingListCompanyBusinessUnitTransfer $shoppingListCompanyBusinessUnitTransfer): void;

    public function saveShoppingListCompanyUser(ShoppingListCompanyUserTransfer $shoppingListCompanyUserTransfer): void;

    public function deleteShoppingListCompanyUser(ShoppingListCompanyUserTransfer $shoppingListCompanyUserTransfer): void;

    public function deleteShoppingListCompanyUsers(ShoppingListTransfer $shoppingListTransfer): void;

    public function deleteShoppingListCompanyBusinessUnits(ShoppingListTransfer $shoppingListTransfer): void;

    public function deleteShoppingListCompanyBusinessUnitsByCompanyBusinessUnitId(int $idCompanyBusinessUnit): void;

    public function deleteShoppingListsCompanyUserByCompanyUserId(int $idCompanyUser): void;

    public function deleteShoppingListCompanyBusinessUnit(ShoppingListCompanyBusinessUnitTransfer $shoppingListCompanyBusinessUnitTransfer): void;

    public function createShoppingListCompanyBusinessUnitBlacklist(
        ShoppingListCompanyBusinessUnitBlacklistTransfer $shoppingListCompanyBusinessUnitBlacklistTransfer
    ): void;

    public function deleteCompanyBusinessUnitBlacklistByShoppingListId(int $idShoppingList): void;

    public function deleteCompanyBusinessUnitBlacklistByBusinessUnitId(int $idCompanyBusinessUnit): void;

    public function deleteShoppingListCompanyBusinessUnitBlacklistsByIdCompanyUser(int $idCompanyUser): void;

    public function saveShoppingListItems(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListItemCollectionTransfer;
}
