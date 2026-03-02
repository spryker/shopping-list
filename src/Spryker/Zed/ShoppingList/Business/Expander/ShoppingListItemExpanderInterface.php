<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business\Expander;

use Generated\Shared\Transfer\ShoppingListCollectionTransfer;

interface ShoppingListItemExpanderInterface
{
    public function expandShoppingListCollectionWithShoppingListItems(
        ShoppingListCollectionTransfer $shoppingListCollectionTransfer
    ): ShoppingListCollectionTransfer;
}
