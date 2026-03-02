<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business\ShoppingListItem;

use Generated\Shared\Transfer\ShoppingListItemCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListPreAddItemCheckResponseTransfer;

interface ShoppingListItemPluginExecutorInterface
{
    public function executeBeforeDeletePlugins(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;

    public function executePostSavePlugins(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;

    public function executeBulkPostSavePlugins(ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer): ShoppingListItemCollectionTransfer;

    /**
     * @deprecated Use {@link \Spryker\Zed\ShoppingList\Business\ShoppingListItem\ShoppingListItemPluginExecutorInterface::executeShoppingListItemCollectionExpanderPlugins()} instead.
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function executeItemExpanderPlugins(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;

    public function executeShoppingListItemCollectionExpanderPlugins(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
    ): ShoppingListItemCollectionTransfer;

    public function executeAddShoppingListItemPreCheckPlugins(
        ShoppingListItemTransfer $shoppingListItemTransfer
    ): ShoppingListPreAddItemCheckResponseTransfer;

    /**
     * @deprecated Use {@link executeAddShoppingListItemPreCheckPlugins()} instead. Will be removed with next major release.
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return bool
     */
    public function executeAddItemPreCheckPlugins(ShoppingListItemTransfer $shoppingListItemTransfer): bool;
}
