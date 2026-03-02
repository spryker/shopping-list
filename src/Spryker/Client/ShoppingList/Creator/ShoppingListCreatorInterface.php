<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList\Creator;

use Generated\Shared\Transfer\ShoppingListFromCartRequestTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;

interface ShoppingListCreatorInterface
{
    public function create(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer;

    public function createFromQuote(
        ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer
    ): ShoppingListTransfer;
}
