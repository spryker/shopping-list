<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\ShoppingList;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class ShoppingListConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const PERMISSION_GROUP_READ_ONLY = 'READ_ONLY';

    /**
     * @var string
     */
    public const PERMISSION_GROUP_FULL_ACCESS = 'FULL_ACCESS';

    /**
     * @var string
     */
    public const PERMISSION_CONFIG_ID_SHOPPING_LIST_COLLECTION = 'id_shopping_list_collection';

    /**
     * @var string
     */
    public const READ_SHOPPING_LIST_PERMISSION_PLUGIN_KEY = 'ReadShoppingListPermissionPlugin';

    /**
     * @var string
     */
    public const WRITE_SHOPPING_LIST_PERMISSION_PLUGIN_KEY = 'WriteShoppingListPermissionPlugin';
}
