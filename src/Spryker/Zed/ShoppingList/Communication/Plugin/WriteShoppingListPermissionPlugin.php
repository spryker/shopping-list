<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Communication\Plugin;

use Spryker\Shared\PermissionExtension\Dependency\Plugin\ExecutablePermissionPluginInterface;
use Spryker\Shared\PermissionExtension\Dependency\Plugin\InfrastructuralPermissionPluginInterface;
use Spryker\Shared\ShoppingList\ShoppingListConfig;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\ShoppingList\Business\ShoppingListFacadeInterface getFacade()
 * @method \Spryker\Zed\ShoppingList\Communication\ShoppingListCommunicationFactory getFactory()
 * @method \Spryker\Zed\ShoppingList\ShoppingListConfig getConfig()
 */
class WriteShoppingListPermissionPlugin extends AbstractPlugin implements ExecutablePermissionPluginInterface, InfrastructuralPermissionPluginInterface
{
    public const KEY = ShoppingListConfig::WRITE_SHOPPING_LIST_PERMISSION_PLUGIN_KEY;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getKey(): string
    {
        return static::KEY;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<string, mixed> $configuration
     * @param int|null $context ID shopping list.
     *
     * @return bool
     */
    public function can(array $configuration, $context = null): bool
    {
        if (!$context) {
            return false;
        }

        return in_array($context, $configuration[ShoppingListConfig::PERMISSION_CONFIG_ID_SHOPPING_LIST_COLLECTION]);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return array
     */
    public function getConfigurationSignature(): array
    {
        return [];
    }
}
