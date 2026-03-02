<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Communication\Controller;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ShoppingListCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListCriteriaTransfer;
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
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Spryker\Zed\ShoppingList\Business\ShoppingListFacadeInterface getFacade()
 * @method \Spryker\Zed\ShoppingList\Persistence\ShoppingListRepositoryInterface getRepository()
 * @method \Spryker\Zed\ShoppingList\Communication\ShoppingListCommunicationFactory getFactory()
 */
class GatewayController extends AbstractGatewayController
{
    public function createShoppingListAction(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFacade()->createShoppingList($shoppingListTransfer);
    }

    public function updateShoppingListAction(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFacade()->updateShoppingList($shoppingListTransfer);
    }

    public function removeShoppingListAction(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFacade()->removeShoppingList($shoppingListTransfer);
    }

    public function clearShoppingListAction(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFacade()->clearShoppingList($shoppingListTransfer);
    }

    /**
     * @deprecated Use GatewayController::addShoppingListItemAction instead. Will be removed with next major release.
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function addItemAction(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer
    {
        return $this->getFacade()->addItem($shoppingListItemTransfer);
    }

    public function addShoppingListItemAction(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer
    {
        return $this->getFacade()->addShoppingListItem($shoppingListItemTransfer);
    }

    public function addItemsAction(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFacade()->addItems($shoppingListTransfer);
    }

    public function removeItemByIdAction(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer
    {
        return $this->getFacade()->removeItemById($shoppingListItemTransfer);
    }

    public function getShoppingListAction(ShoppingListTransfer $shoppingListTransfer): ShoppingListTransfer
    {
        return $this->getFacade()->getShoppingList($shoppingListTransfer);
    }

    public function getShoppingListCollectionAction(ShoppingListCriteriaTransfer $shoppingListCriteriaTransfer): ShoppingListCollectionTransfer
    {
        return $this->getFacade()->getShoppingListCollection($shoppingListCriteriaTransfer);
    }

    public function getShoppingListOverviewAction(
        ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer
    ): ShoppingListOverviewResponseTransfer {
        return $this->getFacade()->getShoppingListOverview($shoppingListOverviewRequestTransfer);
    }

    public function getCustomerShoppingListCollectionAction(CustomerTransfer $customerTransfer): ShoppingListCollectionTransfer
    {
        return $this->getFacade()->getCustomerShoppingListCollection($customerTransfer);
    }

    public function getShoppingListItemCollectionAction(ShoppingListCollectionTransfer $shoppingListCollectionTransfer): ShoppingListItemCollectionTransfer
    {
        return $this->getFacade()->getShoppingListItemCollection($shoppingListCollectionTransfer);
    }

    public function getShoppingListItemCollectionTransferAction(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
    ): ShoppingListItemCollectionTransfer {
        return $this->getFacade()->getShoppingListItemCollectionTransfer($shoppingListItemCollectionTransfer);
    }

    public function updateShoppingListItemByIdAction(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer
    {
        return $this->getFacade()->updateShoppingListItemById($shoppingListItemTransfer);
    }

    public function createShoppingListFromQuoteAction(ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer): ShoppingListTransfer
    {
        return $this->getFacade()->createShoppingListFromQuote($shoppingListFromCartRequestTransfer);
    }

    public function getShoppingListPermissionGroupCollectionAction(): ShoppingListPermissionGroupCollectionTransfer
    {
        return $this->getFacade()->getShoppingListPermissionGroups();
    }

    public function shareShoppingListWithCompanyBusinessUnitAction(
        ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer
    ): ShoppingListShareResponseTransfer {
        return $this->getFacade()->shareShoppingListWithCompanyBusinessUnit($shoppingListShareRequestTransfer);
    }

    public function shareShoppingListWithCompanyUserAction(
        ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer
    ): ShoppingListShareResponseTransfer {
        return $this->getFacade()->shareShoppingListWithCompanyUser($shoppingListShareRequestTransfer);
    }

    public function updateShoppingListSharedEntitiesAction(ShoppingListTransfer $shoppingListTransfer): ShoppingListShareResponseTransfer
    {
        return $this->getFacade()->updateShoppingListSharedEntities($shoppingListTransfer);
    }

    public function dismissShoppingListSharingAction(ShoppingListDismissRequestTransfer $shoppingListDismissRequest): ShoppingListShareResponseTransfer
    {
        return $this->getFacade()->dismissShoppingListSharing($shoppingListDismissRequest);
    }

    public function findShoppingListByUuidAction(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFacade()->findShoppingListByUuid($shoppingListTransfer);
    }

    public function updateShoppingListItemByUuidAction(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer
    {
        return $this->getFacade()->updateShoppingListItemByUuid($shoppingListItemTransfer);
    }

    public function getShoppingListItemCollectionByUuidAction(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
    ): ShoppingListItemCollectionTransfer {
        return $this->getFacade()->getShoppingListItemCollectionByUuid($shoppingListItemCollectionTransfer);
    }
}
