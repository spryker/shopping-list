<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList;

use Generated\Shared\Transfer\ShoppingListAddToCartRequestCollectionTransfer;
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
use Spryker\Client\Kernel\AbstractClient;
use Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface;

/**
 * @method \Spryker\Client\ShoppingList\ShoppingListFactory getFactory()
 */
class ShoppingListClient extends AbstractClient implements ShoppingListClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function createShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFactory()
            ->createShoppingListCreator()
            ->create($shoppingListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function updateShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFactory()
            ->createShoppingListUpdater()
            ->update($shoppingListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function removeShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFactory()
            ->createShoppingListRemover()
            ->remove($shoppingListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function clearShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFactory()
            ->createShoppingListUpdater()
            ->clearShoppingList($shoppingListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     * @param array<string, mixed> $params
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function addItem(ShoppingListItemTransfer $shoppingListItemTransfer, array $params = []): ShoppingListItemTransfer
    {
        return $this->addShoppingListItem($shoppingListItemTransfer, $params)->getShoppingListItem() ?? $shoppingListItemTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     * @param array<string, mixed> $params
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function addShoppingListItem(
        ShoppingListItemTransfer $shoppingListItemTransfer,
        array $params = []
    ): ShoppingListItemResponseTransfer {
        return $this->getFactory()
            ->createShoppingListItemCreator()
            ->addItem($shoppingListItemTransfer, $params);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function addItems(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFactory()
            ->createShoppingListItemCreator()
            ->addItems($shoppingListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function removeItemById(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer
    {
        return $this->getFactory()
            ->createShoppingListItemRemover()
            ->remove($shoppingListItemTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    public function getShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListTransfer
    {
        $shoppingListTransfer = $this->getZedStub()->getShoppingList($shoppingListTransfer);

        $this->getFactory()->getZedRequestClient()->addResponseMessagesToMessenger();

        return $shoppingListTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListOverviewResponseTransfer
     */
    public function getShoppingListOverviewWithoutProductDetails(
        ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer
    ): ShoppingListOverviewResponseTransfer {
        return $this->getZedStub()->getShoppingListOverview($shoppingListOverviewRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListOverviewResponseTransfer
     */
    public function getShoppingListOverview(ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer): ShoppingListOverviewResponseTransfer
    {
        $shoppingListOverviewResponseTransfer = $this->getShoppingListOverviewWithoutProductDetails($shoppingListOverviewRequestTransfer);

        return $this->getFactory()->createProductStorage()->expandProductDetails($shoppingListOverviewResponseTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\ShoppingListCollectionTransfer
     */
    public function getCustomerShoppingListCollection(): ShoppingListCollectionTransfer
    {
        $customerTransfer = $this->getFactory()
            ->getCustomerClient()
            ->getCustomer();

        return $this->getZedStub()->getCustomerShoppingListCollection($customerTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListCollectionTransfer $shoppingListCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function getShoppingListItemCollection(ShoppingListCollectionTransfer $shoppingListCollectionTransfer): ShoppingListItemCollectionTransfer
    {
        return $this->getZedStub()->getShoppingListItemCollection($shoppingListCollectionTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function getShoppingListItemCollectionTransfer(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
    ): ShoppingListItemCollectionTransfer {
        return $this->getZedStub()->getShoppingListItemCollectionTransfer($shoppingListItemCollectionTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListAddToCartRequestCollectionTransfer $shoppingListAddToCartRequestCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListAddToCartRequestCollectionTransfer
     */
    public function addItemCollectionToCart(
        ShoppingListAddToCartRequestCollectionTransfer $shoppingListAddToCartRequestCollectionTransfer
    ): ShoppingListAddToCartRequestCollectionTransfer {
        return $this->getFactory()->createCartHandler()->addItemCollectionToCart($shoppingListAddToCartRequestCollectionTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function updateShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer
    {
        return $this->updateShoppingListItemById($shoppingListItemTransfer)->getShoppingListItem() ?? $shoppingListItemTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function updateShoppingListItemById(
        ShoppingListItemTransfer $shoppingListItemTransfer
    ): ShoppingListItemResponseTransfer {
        return $this->getZedStub()->updateShoppingListItemById($shoppingListItemTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    public function createShoppingListFromQuote(ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer): ShoppingListTransfer
    {
        return $this->getFactory()
            ->createShoppingListCreator()
            ->createFromQuote($shoppingListFromCartRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\ShoppingListPermissionGroupCollectionTransfer
     */
    public function getShoppingListPermissionGroups(): ShoppingListPermissionGroupCollectionTransfer
    {
        return $this->getZedStub()->getShoppingListPermissionGroups();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListShareResponseTransfer
     */
    public function shareShoppingList(ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer): ShoppingListShareResponseTransfer
    {
        if ($shoppingListShareRequestTransfer->getIdCompanyBusinessUnit()) {
            return $this->getZedStub()->shareShoppingListWithCompanyBusinessUnit($shoppingListShareRequestTransfer);
        }
        if ($shoppingListShareRequestTransfer->getIdCompanyUser()) {
            return $this->getZedStub()->shareShoppingListWithCompanyUser($shoppingListShareRequestTransfer);
        }

        return (new ShoppingListShareResponseTransfer())->setIsSuccess(false);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListShareResponseTransfer
     */
    public function updateShoppingListSharedEntities(ShoppingListTransfer $shoppingListTransfer): ShoppingListShareResponseTransfer
    {
        return $this->getZedStub()->updateShoppingListSharedEntities($shoppingListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListDismissRequestTransfer $shoppingListDismissRequest
     *
     * @return \Generated\Shared\Transfer\ShoppingListShareResponseTransfer
     */
    public function dismissShoppingListSharing(ShoppingListDismissRequestTransfer $shoppingListDismissRequest): ShoppingListShareResponseTransfer
    {
        $shoppingListShareResponseTransfer = $this->getZedStub()->dismissShoppingListSharing($shoppingListDismissRequest);

        $this->updatePermissions();

        return $shoppingListShareResponseTransfer;
    }

    /**
     * @return \Spryker\Client\ShoppingList\Zed\ShoppingListStubInterface
     */
    protected function getZedStub(): ShoppingListStubInterface
    {
        return $this->getFactory()->createShoppingListStub();
    }

    /**
     * @return void
     */
    protected function updatePermissions(): void
    {
        $this->getFactory()->createPermissionUpdater()->updateCompanyUserPermissions();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function updateCustomerPermission(): void
    {
        $this->getFactory()->createPermissionUpdater()->updateCompanyUserPermissions();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\ProductViewTransfer> $shoppingListItemProductViews
     *
     * @return int
     */
    public function calculateShoppingListSubtotal(array $shoppingListItemProductViews): int
    {
        return $this->getFactory()
            ->createShoppingListSubtotalCalculator()
            ->calculateShoppingListSubtotal($shoppingListItemProductViews);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * {@internal will work if uuid field is provided.}
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function findShoppingListByUuid(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getZedStub()->findShoppingListByUuid($shoppingListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * {@internal will work if uuid field is provided.}
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function updateShoppingListItemByUuid(
        ShoppingListItemTransfer $shoppingListItemTransfer
    ): ShoppingListItemResponseTransfer {
        return $this->getZedStub()->updateShoppingListItemByUuid($shoppingListItemTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * {@internal will work if uuid field is provided.}
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function getShoppingListItemCollectionByUuid(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
    ): ShoppingListItemCollectionTransfer {
        return $this->getZedStub()->getShoppingListItemCollectionByUuid($shoppingListItemCollectionTransfer);
    }
}
