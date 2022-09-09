<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList\Zed;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ShoppingListCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListDismissRequestTransfer;
use Generated\Shared\Transfer\ShoppingListFromCartRequestTransfer;
use Generated\Shared\Transfer\ShoppingListItemCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListOverviewRequestTransfer;
use Generated\Shared\Transfer\ShoppingListOverviewResponseTransfer;
use Generated\Shared\Transfer\ShoppingListPermissionGroupCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListShareRequestTransfer;
use Generated\Shared\Transfer\ShoppingListShareResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface;

class ShoppingListStub implements ShoppingListStubInterface
{
    /**
     * @var \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \Spryker\Client\ShoppingList\Dependency\Client\ShoppingListToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ShoppingListToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::createShoppingListAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function createShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListResponseTransfer $shoppingListResponseTransfer */
        $shoppingListResponseTransfer = $this->zedRequestClient->call('/shopping-list/gateway/create-shopping-list', $shoppingListTransfer);

        return $shoppingListResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::updateShoppingListAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function updateShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListResponseTransfer $shoppingListResponseTransfer */
        $shoppingListResponseTransfer = $this->zedRequestClient->call('/shopping-list/gateway/update-shopping-list', $shoppingListTransfer);

        return $shoppingListResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::removeShoppingListAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function removeShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListResponseTransfer $shoppingListResponseTransfer */
        $shoppingListResponseTransfer = $this->zedRequestClient->call('/shopping-list/gateway/remove-shopping-list', $shoppingListTransfer);

        return $shoppingListResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::clearShoppingListAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function clearShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListResponseTransfer $shoppingListResponseTransfer */
        $shoppingListResponseTransfer = $this->zedRequestClient->call('/shopping-list/gateway/clear-shopping-list', $shoppingListTransfer);

        return $shoppingListResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::addShoppingListItemAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function addShoppingListItem(
        ShoppingListItemTransfer $shoppingListItemTransfer
    ): ShoppingListItemResponseTransfer {
        /** @var \Generated\Shared\Transfer\ShoppingListItemResponseTransfer $shoppingListItemResponseTransfer */
        $shoppingListItemResponseTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/add-shopping-list-item',
            $shoppingListItemTransfer,
        );

        return $shoppingListItemResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::updateShoppingListItemByIdAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function updateShoppingListItemById(
        ShoppingListItemTransfer $shoppingListItemTransfer
    ): ShoppingListItemResponseTransfer {
        /** @var \Generated\Shared\Transfer\ShoppingListItemResponseTransfer $shoppingListItemResponseTransfer */
        $shoppingListItemResponseTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/update-shopping-list-item-by-id',
            $shoppingListItemTransfer,
        );

        return $shoppingListItemResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::addItemAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function addItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer */
        $shoppingListItemTransfer = $this->zedRequestClient->call('/shopping-list/gateway/add-item', $shoppingListItemTransfer);

        return $shoppingListItemTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::addItemsAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function addItems(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListResponseTransfer $shoppingListResponseTransfer */
        $shoppingListResponseTransfer = $this->zedRequestClient->call('/shopping-list/gateway/add-items', $shoppingListTransfer);

        return $shoppingListResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::removeItemByIdAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function removeItemById(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListItemResponseTransfer $shoppingListItemResponseTransfer */
        $shoppingListItemResponseTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/remove-item-by-id',
            $shoppingListItemTransfer,
        );

        return $shoppingListItemResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::getShoppingListAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    public function getShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer */
        $shoppingListTransfer = $this->zedRequestClient->call('/shopping-list/gateway/get-shopping-list', $shoppingListTransfer);

        return $shoppingListTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::getShoppingListOverviewAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListOverviewResponseTransfer
     */
    public function getShoppingListOverview(ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer): ShoppingListOverviewResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListOverviewResponseTransfer $shoppingListOverviewResponseTransfer */
        $shoppingListOverviewResponseTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/get-shopping-list-overview',
            $shoppingListOverviewRequestTransfer,
        );

        return $shoppingListOverviewResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::getCustomerShoppingListCollectionAction()
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListCollectionTransfer
     */
    public function getCustomerShoppingListCollection(CustomerTransfer $customerTransfer): ShoppingListCollectionTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListCollectionTransfer $shoppingListCollectionTransfer */
        $shoppingListCollectionTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/get-customer-shopping-list-collection',
            $customerTransfer,
        );

        return $shoppingListCollectionTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::getShoppingListItemCollectionAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListCollectionTransfer $shoppingListCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function getShoppingListItemCollection(ShoppingListCollectionTransfer $shoppingListCollectionTransfer): ShoppingListItemCollectionTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer */
        $shoppingListItemCollectionTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/get-shopping-list-item-collection',
            $shoppingListCollectionTransfer,
        );

        return $shoppingListItemCollectionTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::getShoppingListItemCollectionTransferAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function getShoppingListItemCollectionTransfer(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
    ): ShoppingListItemCollectionTransfer {
        /** @var \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer */
        $shoppingListItemCollectionTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/get-shopping-list-item-collection-transfer',
            $shoppingListItemCollectionTransfer,
        );

        return $shoppingListItemCollectionTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::createShoppingListFromQuoteAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    public function createShoppingListFromQuote(ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer): ShoppingListTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer */
        $shoppingListTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/create-shopping-list-from-quote',
            $shoppingListFromCartRequestTransfer,
        );

        return $shoppingListTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::getShoppingListPermissionGroupCollectionAction()
     *
     * @return \Generated\Shared\Transfer\ShoppingListPermissionGroupCollectionTransfer
     */
    public function getShoppingListPermissionGroups(): ShoppingListPermissionGroupCollectionTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListPermissionGroupCollectionTransfer $shoppingListPermissionGroupCollectionTransfer */
        $shoppingListPermissionGroupCollectionTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/get-shopping-list-permission-group-collection',
            new ShoppingListPermissionGroupCollectionTransfer(),
        );

        return $shoppingListPermissionGroupCollectionTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::shareShoppingListWithCompanyBusinessUnitAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListShareResponseTransfer
     */
    public function shareShoppingListWithCompanyBusinessUnit(
        ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer
    ): ShoppingListShareResponseTransfer {
        /** @var \Generated\Shared\Transfer\ShoppingListShareResponseTransfer $shoppingListShareResponseTransfer */
        $shoppingListShareResponseTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/share-shopping-list-with-company-business-unit',
            $shoppingListShareRequestTransfer,
        );

        return $shoppingListShareResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::shareShoppingListWithCompanyUserAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListShareResponseTransfer
     */
    public function shareShoppingListWithCompanyUser(ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer): ShoppingListShareResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListShareResponseTransfer $shoppingListShareResponseTransfer */
        $shoppingListShareResponseTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/share-shopping-list-with-company-user',
            $shoppingListShareRequestTransfer,
        );

        return $shoppingListShareResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::updateShoppingListSharedEntitiesAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListShareResponseTransfer
     */
    public function updateShoppingListSharedEntities(ShoppingListTransfer $shoppingListTransfer): ShoppingListShareResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListShareResponseTransfer $shoppingListResponseTransfer */
        $shoppingListResponseTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/update-shopping-list-shared-entities',
            $shoppingListTransfer,
        );

        return $shoppingListResponseTransfer;
    }

    /**
     * @return array<\Generated\Shared\Transfer\MessageTransfer>
     */
    public function getLastResponseErrorMessages(): array
    {
        return $this->zedRequestClient->getLastResponseErrorMessages();
    }

    /**
     * @return array<\Generated\Shared\Transfer\MessageTransfer>
     */
    public function getResponsesErrorMessages(): array
    {
        return $this->zedRequestClient->getResponsesErrorMessages();
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::dismissShoppingListSharingAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListDismissRequestTransfer $shoppingListDismissRequest
     *
     * @return \Generated\Shared\Transfer\ShoppingListShareResponseTransfer
     */
    public function dismissShoppingListSharing(ShoppingListDismissRequestTransfer $shoppingListDismissRequest): ShoppingListShareResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListShareResponseTransfer $shoppingListShareResponseTransfer */
        $shoppingListShareResponseTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/dismiss-shopping-list-sharing',
            $shoppingListDismissRequest,
        );

        return $shoppingListShareResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::findShoppingListByUuid()
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function findShoppingListByUuid(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ShoppingListResponseTransfer $shoppingListResponseTransfer */
        $shoppingListResponseTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/find-shopping-list-by-uuid',
            $shoppingListTransfer,
        );

        return $shoppingListResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::updateShoppingListItemByUuidAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function updateShoppingListItemByUuid(
        ShoppingListItemTransfer $shoppingListItemTransfer
    ): ShoppingListItemResponseTransfer {
        /** @var \Generated\Shared\Transfer\ShoppingListItemResponseTransfer $shoppingListItemResponseTransfer */
        $shoppingListItemResponseTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/update-shopping-list-item-by-uuid',
            $shoppingListItemTransfer,
        );

        return $shoppingListItemResponseTransfer;
    }

    /**
     * @uses \Spryker\Zed\ShoppingList\Communication\Controller\GatewayController::getShoppingListItemCollectionByUuidAction()
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function getShoppingListItemCollectionByUuid(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
    ): ShoppingListItemCollectionTransfer {
        /** @var \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer */
        $shoppingListItemCollectionTransfer = $this->zedRequestClient->call(
            '/shopping-list/gateway/get-shopping-list-item-collection-by-uuid',
            $shoppingListItemCollectionTransfer,
        );

        return $shoppingListItemCollectionTransfer;
    }
}
