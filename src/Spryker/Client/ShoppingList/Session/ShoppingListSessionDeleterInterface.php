<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList\Session;

interface ShoppingListSessionDeleterInterface
{
    /**
     * @return void
     */
    public function removeShoppingListCollection(): void;
}
