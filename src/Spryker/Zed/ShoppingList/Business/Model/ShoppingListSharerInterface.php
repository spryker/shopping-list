<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business\Model;

use Generated\Shared\Transfer\ShoppingListShareRequestTransfer;
use Generated\Shared\Transfer\ShoppingListShareResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;

interface ShoppingListSharerInterface
{
    public function shareShoppingListWithCompanyBusinessUnit(
        ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer
    ): ShoppingListShareResponseTransfer;

    public function shareShoppingListWithCompanyUser(ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer): ShoppingListShareResponseTransfer;

    public function unShareShoppingListCompanyBusinessUnit(
        ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer
    ): ShoppingListShareResponseTransfer;

    public function unShareCompanyUserShoppingLists(ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer): ShoppingListShareResponseTransfer;

    public function updateShoppingListSharedEntities(ShoppingListTransfer $shoppingListTransfer): ShoppingListShareResponseTransfer;
}
