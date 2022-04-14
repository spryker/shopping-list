<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList\Deleter;

use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface;
use Spryker\Client\ShoppingList\Session\ShoppingListSessionDeleterInterface;
use Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface;

class ShoppingListItemDeleter implements ShoppingListItemDeleterInterface
{
    /**
     * @var \Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface
     */
    protected $shoppingListStub;

    /**
     * @var \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @var \Spryker\Client\ShoppingList\Session\ShoppingListSessionDeleterInterface
     */
    protected $shoppingListSessionDeleter;

    /**
     * @param \Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface $shoppingListStub
     * @param \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface $zedRequestClient
     * @param \Spryker\Client\ShoppingList\Session\ShoppingListSessionDeleterInterface $shoppingListSessionDeleter
     */
    public function __construct(
        ShoppingListStubInterface $shoppingListStub,
        ShoppingListToZedRequestClientInterface $zedRequestClient,
        ShoppingListSessionDeleterInterface $shoppingListSessionDeleter
    ) {
        $this->shoppingListStub = $shoppingListStub;
        $this->zedRequestClient = $zedRequestClient;
        $this->shoppingListSessionDeleter = $shoppingListSessionDeleter;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function remove(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer
    {
        $shoppingListItemResponseTransfer = $this->shoppingListStub->removeItemById($shoppingListItemTransfer);

        $this->zedRequestClient->addResponseMessagesToMessenger();

        if (!$shoppingListItemResponseTransfer->getIsSuccess()) {
            return $shoppingListItemResponseTransfer;
        }

        $this->shoppingListSessionDeleter->removeShoppingListCollection();

        return $shoppingListItemResponseTransfer;
    }
}
