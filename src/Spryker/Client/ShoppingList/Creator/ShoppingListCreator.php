<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList\Creator;

use Generated\Shared\Transfer\ShoppingListFromCartRequestTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface;
use Spryker\Client\ShoppingList\PermissionUpdater\PermissionUpdaterInterface;
use Spryker\Client\ShoppingList\Remover\ShoppingListSessionRemoverInterface;
use Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface;

class ShoppingListCreator implements ShoppingListCreatorInterface
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
     * @var \Spryker\Client\ShoppingList\Remover\ShoppingListSessionRemoverInterface
     */
    protected $shoppingListSessionRemover;

    /**
     * @param \Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface $shoppingListStub
     * @param \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface $zedRequestClient
     * @param \Spryker\Client\ShoppingList\PermissionUpdater\PermissionUpdaterInterface $permissionUpdater
     * @param \Spryker\Client\ShoppingList\Remover\ShoppingListSessionRemoverInterface $shoppingListSessionRemover
     */
    public function __construct(
        ShoppingListStubInterface $shoppingListStub,
        ShoppingListToZedRequestClientInterface $zedRequestClient,
        PermissionUpdaterInterface $permissionUpdater,
        ShoppingListSessionRemoverInterface $shoppingListSessionRemover
    ) {
        $this->shoppingListStub = $shoppingListStub;
        $this->zedRequestClient = $zedRequestClient;
        $this->permissionUpdater = $permissionUpdater;
        $this->shoppingListSessionRemover = $shoppingListSessionRemover;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function create(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        $shoppingListResponseTransfer = $this->shoppingListStub->createShoppingList($shoppingListTransfer);

        $this->zedRequestClient->addResponseMessagesToMessenger();
        $this->permissionUpdater->updateCompanyUserPermissions();

        if ($shoppingListResponseTransfer->getIsSuccess()) {
            $this->shoppingListSessionRemover->removeShoppingListCollection();
        }

        return $shoppingListResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    public function createFromQuote(
        ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer
    ): ShoppingListTransfer {
        $shoppingListTransfer = $this->shoppingListStub->createShoppingListFromQuote($shoppingListFromCartRequestTransfer);

        $this->zedRequestClient->addResponseMessagesToMessenger();
        $this->permissionUpdater->updateCompanyUserPermissions();
        $this->shoppingListSessionRemover->removeShoppingListCollection();

        return $shoppingListTransfer;
    }
}
