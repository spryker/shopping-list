<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator;

use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;

interface ShoppingListItemPermissionValidatorInterface
{
    public function validatePermissionForPerformingOperation(
        ShoppingListTransfer $shoppingListTransfer,
        ShoppingListItemResponseTransfer $shoppingListItemResponseTransfer
    ): ShoppingListItemResponseTransfer;

    public function checkWritePermission(ShoppingListTransfer $shoppingListTransfer): bool;
}
