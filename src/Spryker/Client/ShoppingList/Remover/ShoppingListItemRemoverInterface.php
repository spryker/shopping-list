<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList\Remover;

use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;

interface ShoppingListItemRemoverInterface
{
    public function remove(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer;
}
