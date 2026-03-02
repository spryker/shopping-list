<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Dependency\Facade;

use Generated\Shared\Transfer\PermissionTransfer;

interface ShoppingListToPermissionFacadeInterface
{
    public function findPermissionByKey(string $key): ?PermissionTransfer;

    public function syncPermissionPlugins(): void;
}
