<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business\Model;

use Generated\Shared\Transfer\ShoppingListItemCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;

interface ShoppingListItemOperationInterface
{
    /**
     * @deprecated Use {@link addShoppingListItem()} instead. Will be removed with next major release.
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function addItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;

    public function addShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer;

    public function addItems(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer;

    public function deleteShoppingListItems(ShoppingListTransfer $shoppingListTransfer): void;

    public function deleteShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer;

    public function removeItemById(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer;

    /**
     * @deprecated Use {@link updateShoppingListItem()} instead. Will be removed with next major release.
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function saveShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;

    public function updateShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer;

    public function updateShoppingListItemByUuid(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer;

    public function saveShoppingListItemWithoutPermissionsCheck(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;

    public function saveShoppingListItemBulk(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): void;
}
