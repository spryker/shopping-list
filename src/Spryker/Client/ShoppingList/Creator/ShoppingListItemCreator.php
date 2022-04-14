<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList\Creator;

use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface;
use Spryker\Client\ShoppingList\PermissionUpdater\PermissionUpdaterInterface;
use Spryker\Client\ShoppingList\Session\ShoppingListSessionDeleterInterface;
use Spryker\Client\ShoppingList\ShoppingList\ShoppingListAddItemExpanderInterface;
use Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface;

class ShoppingListItemCreator implements ShoppingListItemCreatorInterface
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
     * @var \Spryker\Client\ShoppingList\PermissionUpdater\PermissionUpdaterInterface
     */
    protected $permissionUpdater;

    /**
     * @var \Spryker\Client\ShoppingList\Session\ShoppingListSessionDeleterInterface
     */
    protected $shoppingListSessionDeleter;

    /**
     * @var \Spryker\Client\ShoppingList\ShoppingList\ShoppingListAddItemExpanderInterface
     */
    protected $shoppingListAddItemExpander;

    /**
     * @param \Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface $shoppingListStub
     * @param \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface $zedRequestClient
     * @param \Spryker\Client\ShoppingList\PermissionUpdater\PermissionUpdaterInterface $permissionUpdater
     * @param \Spryker\Client\ShoppingList\Session\ShoppingListSessionDeleterInterface $shoppingListSessionDeleter
     * @param \Spryker\Client\ShoppingList\ShoppingList\ShoppingListAddItemExpanderInterface $shoppingListAddItemExpander
     */
    public function __construct(
        ShoppingListStubInterface $shoppingListStub,
        ShoppingListToZedRequestClientInterface $zedRequestClient,
        PermissionUpdaterInterface $permissionUpdater,
        ShoppingListSessionDeleterInterface $shoppingListSessionDeleter,
        ShoppingListAddItemExpanderInterface $shoppingListAddItemExpander
    ) {
        $this->shoppingListStub = $shoppingListStub;
        $this->zedRequestClient = $zedRequestClient;
        $this->permissionUpdater = $permissionUpdater;
        $this->shoppingListSessionDeleter = $shoppingListSessionDeleter;
        $this->shoppingListAddItemExpander = $shoppingListAddItemExpander;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     * @param array $params
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function addItem(
        ShoppingListItemTransfer $shoppingListItemTransfer,
        array $params = []
    ): ShoppingListItemTransfer {
        $shoppingListItemTransfer = $this->shoppingListAddItemExpander
            ->expandShoppingListAddItem($shoppingListItemTransfer, $params);

        $shoppingListItemTransfer = $this->shoppingListStub->addItem($shoppingListItemTransfer);

        $this->zedRequestClient->addResponseMessagesToMessenger();
        $this->permissionUpdater->updateCompanyUserPermissions();

        $this->shoppingListSessionDeleter->removeShoppingListCollection();

        return $shoppingListItemTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function addItems(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        $shoppingListResponseTransfer = $this->shoppingListStub->addItems($shoppingListTransfer);

        $this->zedRequestClient->addFlashMessagesFromLastZedRequest();
        $this->permissionUpdater->updateCompanyUserPermissions();

        if (!$shoppingListResponseTransfer->getIsSuccess()) {
            return $shoppingListResponseTransfer;
        }

        $this->shoppingListSessionDeleter->removeShoppingListCollection();

        return $shoppingListResponseTransfer;
    }
}
