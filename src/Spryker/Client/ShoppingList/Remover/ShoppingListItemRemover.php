<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList\Remover;

use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface;
use Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface;

class ShoppingListItemRemover implements ShoppingListItemRemoverInterface
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
     * @var \Spryker\Client\ShoppingList\Remover\ShoppingListSessionRemoverInterface
     */
    protected $shoppingListSessionRemover;

    public function __construct(
        ShoppingListStubInterface $shoppingListStub,
        ShoppingListToZedRequestClientInterface $zedRequestClient,
        ShoppingListSessionRemoverInterface $shoppingListSessionRemover
    ) {
        $this->shoppingListStub = $shoppingListStub;
        $this->zedRequestClient = $zedRequestClient;
        $this->shoppingListSessionRemover = $shoppingListSessionRemover;
    }

    public function remove(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer
    {
        $shoppingListItemResponseTransfer = $this->shoppingListStub->removeItemById($shoppingListItemTransfer);

        $this->zedRequestClient->addResponseMessagesToMessenger();

        if ($shoppingListItemResponseTransfer->getIsSuccess()) {
            $this->shoppingListSessionRemover->removeShoppingListCollection();
        }

        return $shoppingListItemResponseTransfer;
    }
}
