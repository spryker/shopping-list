<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business\Model;

use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListPreAddItemCheckResponseTransfer;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToMessengerFacadeInterface;

class ShoppingListItemPluginExecutor implements ShoppingListItemPluginExecutorInterface
{
    /**
     * @var \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ShoppingListItemBeforeDeletePluginInterface[]
     */
    protected $beforeDeletePlugins;

    /**
     * @var \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ShoppingListItemPostSavePluginInterface[]
     */
    protected $postSavePlugins;

    /**
     * @var \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\AddItemPreCheckPluginInterface[]
     */
    protected $addItemPreCheckPlugins;

    /**
     * @var \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToMessengerFacadeInterface
     */
    protected $messengerFacade;

    /**
     * @var \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ItemExpanderPluginInterface[]
     */
    protected $itemExpanderPlugins;

    /**
     * @param \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToMessengerFacadeInterface $messengerFacade
     * @param \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ShoppingListItemBeforeDeletePluginInterface[] $beforeDeletePlugins
     * @param \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ShoppingListItemPostSavePluginInterface[] $postSavePlugins
     * @param \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\AddItemPreCheckPluginInterface[] $addItemPreCheckPlugins
     * @param \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ItemExpanderPluginInterface[] $itemExpanderPlugins
     */
    public function __construct(
        ShoppingListToMessengerFacadeInterface $messengerFacade,
        array $beforeDeletePlugins,
        array $postSavePlugins,
        array $addItemPreCheckPlugins,
        array $itemExpanderPlugins
    ) {
        $this->beforeDeletePlugins = $beforeDeletePlugins;
        $this->postSavePlugins = $postSavePlugins;
        $this->addItemPreCheckPlugins = $addItemPreCheckPlugins;
        $this->messengerFacade = $messengerFacade;
        $this->itemExpanderPlugins = $itemExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return void
     */
    public function executeBeforeDeletePlugins(ShoppingListItemTransfer $shoppingListItemTransfer): void
    {
        foreach ($this->beforeDeletePlugins as $beforeDeletePlugin) {
            $beforeDeletePlugin->execute($shoppingListItemTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return void
     */
    public function executePostSavePlugins(ShoppingListItemTransfer $shoppingListItemTransfer): void
    {
        foreach ($this->postSavePlugins as $postSavePlugin) {
            $postSavePlugin->execute($shoppingListItemTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function executeItemExpanderPlugins(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer
    {
        foreach ($this->itemExpanderPlugins as $itemExpanderPlugin) {
            $shoppingListItemTransfer = $itemExpanderPlugin->expandItem($shoppingListItemTransfer);
        }

        return $shoppingListItemTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return bool
     */
    public function executeAddItemPreCheckPlugins(ShoppingListItemTransfer $shoppingListItemTransfer): bool
    {
        $isValid = true;
        foreach ($this->addItemPreCheckPlugins as $preAddItemCheckPlugin) {
            $shoppingListPreAddItemCheckResponseTransfer = $preAddItemCheckPlugin->check($shoppingListItemTransfer);
            if (!$shoppingListPreAddItemCheckResponseTransfer->getIsSuccess()) {
                $this->processErrorMessages($shoppingListPreAddItemCheckResponseTransfer);
                $isValid = false;
            }
        }

        return $isValid;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListPreAddItemCheckResponseTransfer $shoppingListPreAddItemCheckResponseTransfer
     *
     * @return void
     */
    protected function processErrorMessages(ShoppingListPreAddItemCheckResponseTransfer $shoppingListPreAddItemCheckResponseTransfer): void
    {
        foreach ($shoppingListPreAddItemCheckResponseTransfer->getMessages() as $messageTransfer) {
            $this->messengerFacade->addErrorMessage($messageTransfer);
        }
    }
}
