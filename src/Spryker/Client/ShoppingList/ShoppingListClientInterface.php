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

interface ShoppingListClientInterface
{
    /**
     * Specification:
     * - Makes Zed request.
     * - Creates new shopping list entity if it does not exist.
     * - Updates customer permissions.
     * - Gets messages from Zed request and put them to session.
     * - Removes outdated shopping lists collection from session, if response is successful.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function createShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer;

    /**
     * Specification:
     * - Makes Zed request.
     * - Updates shopping list entity if it exist or create new.
     * - Updates customer permissions.
     * - Gets messages from Zed request and put them to session.
     * - Removes outdated shopping lists collection from session, if response is successful.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function updateShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer;

    /**
     * Specification:
     * - Makes Zed request.
     * - Removes shopping list.
     * - Updates customer permissions.
     * - Gets messages from Zed request and put them to session.
     * - Removes outdated shopping lists collection from session, if response is successful.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function removeShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer;

    /**
     * Specification:
     * - Requires `ShoppingListTransfer.items.idShoppingListItem` to be set.
     * - Makes Zed request.
     * - Removes all shopping list items.
     * - Gets messages from Zed request and put them to session.
     * - Removes outdated shopping lists collection from session, if response is successful.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function clearShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Hydrates ShoppingListItem with provided optional params.
     *  - Add item to shopping list.
     *  - Updates customer permissions.
     *  - Get messages from zed request and put them to session.
     *
     * @api
     *
     * @deprecated Use {@link addShoppingListItem()} instead. Will be removed with next major release.
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     * @param array<string, mixed> $params
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function addItem(ShoppingListItemTransfer $shoppingListItemTransfer, array $params = []): ShoppingListItemTransfer;

    /**
     * Specification:
     * - Requires `ShoppingListItemTransfer.quantity` to be set.
     * - Requires `ShoppingListItemTransfer.sku` to be set.
     * - Makes Zed request.
     * - Hydrates ShoppingListItem with provided optional params.
     * - Adds item to shopping list.
     * - Updates customer permissions.
     * - Gets messages from Zed request and put them to session.
     * - Removes outdated shopping lists collection from session, if response is successful.
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
    ): ShoppingListItemResponseTransfer;

    /**
     * Specification:
     * - Requires `ShoppingListTransfer.idCompanyUser` to be set.
     * - Requires `ShoppingListTransfer.customerReference` to be set.
     * - Executes {@link \Spryker\Client\ShoppingListExtension\Dependency\Plugin\ShoppingListExpanderPluginInterface} plugin stack.
     * - Makes Zed request.
     * - Adds items to shopping list.
     * - Updates customer permissions.
     * - Gets messages from Zed request and put them to session.
     * - Removes outdated shopping lists collection from session, if response is successful.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function addItems(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer;

    /**
     * Specification:
     * - Requires `ShoppingListItemTransfer.idShoppingListItem` to be set.
     * - Requires `ShoppingListItemTransfer.fkShoppingList` to be set.
     * - Makes Zed request.
     * - Removes item by id.
     * - Updates customer permissions.
     * - Gets messages from Zed request and put them to session.
     * - Removes outdated shopping lists collection from session, if response is successful.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function removeItemById(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Load shopping list by id.
     *  - Updates customer permissions.
     *  - Get messages from zed request and put them to session.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    public function getShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Create new shopping list entity if it does not exist.
     *  - Updates customer permissions.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListOverviewResponseTransfer
     */
    public function getShoppingListOverviewWithoutProductDetails(
        ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer
    ): ShoppingListOverviewResponseTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Get shopping list detail information.
     *  - Updates customer permissions.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListOverviewResponseTransfer
     */
    public function getShoppingListOverview(ShoppingListOverviewRequestTransfer $shoppingListOverviewRequestTransfer): ShoppingListOverviewResponseTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Get shopping list collection by customer.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\ShoppingListCollectionTransfer
     */
    public function getCustomerShoppingListCollection(): ShoppingListCollectionTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Add shopping list items to cart.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListAddToCartRequestCollectionTransfer $shoppingListAddToCartRequestCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListAddToCartRequestCollectionTransfer
     */
    public function addItemCollectionToCart(
        ShoppingListAddToCartRequestCollectionTransfer $shoppingListAddToCartRequestCollectionTransfer
    ): ShoppingListAddToCartRequestCollectionTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Get items collection for shopping list collection.
     *  - Updates customer permissions.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListCollectionTransfer $shoppingListCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function getShoppingListItemCollection(ShoppingListCollectionTransfer $shoppingListCollectionTransfer): ShoppingListItemCollectionTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Get shopping list item collection by ids.
     *  - Updates customer permissions.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function getShoppingListItemCollectionTransfer(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
    ): ShoppingListItemCollectionTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Update shopping list item.
     *  - Updates customer permissions.
     *
     * @api
     *
     * @deprecated Use {@link updateShoppingListItemById()} instead. Will be removed with next major release.
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function updateShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Updates shopping list item.
     *  - Updates customer permissions.
     *  - Get messages from Zed request and put them to session.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function updateShoppingListItemById(
        ShoppingListItemTransfer $shoppingListItemTransfer
    ): ShoppingListItemResponseTransfer;

    /**
     * Specification:
     * - Requires `ShoppingListFromCartRequestTransfer.idQuote` to be set.
     * - Requires `ShoppingListFromCartRequestTransfer.customer` to be set.
     * - Requires `ShoppingListFromCartRequestTransfer.shoppingListName` to be set, if a shopping list given ID does not exist or the customer does not have write permission.
     * - Makes Zed request.
     * - Pushes items from quote to shopping list.
     * - Updates customer permissions.
     * - Gets messages from Zed request and put them to session.
     * - Removes outdated shopping lists collection from session.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    public function createShoppingListFromQuote(ShoppingListFromCartRequestTransfer $shoppingListFromCartRequestTransfer): ShoppingListTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Get shopping list permission groups.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\ShoppingListPermissionGroupCollectionTransfer
     */
    public function getShoppingListPermissionGroups(): ShoppingListPermissionGroupCollectionTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Share shopping list with company users from business unit or exact company user.
     *  - Updates customer permissions.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListShareResponseTransfer
     */
    public function shareShoppingList(ShoppingListShareRequestTransfer $shoppingListShareRequestTransfer): ShoppingListShareResponseTransfer;

    /**
     * Specification:
     *  - Makes Zed request.
     *  - Updates share shopping list with company users from business unit or exact company user.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListShareResponseTransfer
     */
    public function updateShoppingListSharedEntities(ShoppingListTransfer $shoppingListTransfer): ShoppingListShareResponseTransfer;

    /**
     * Specification:
     *  - Makes zed request.
     *  - Removes shopping list to company user relation if exists.
     *  - Adds shopping list to company user blacklist if company user business unit has access to shopping list.
     *  - Returns success if at least one action was executed.
     *  - Updates customer permissions.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListDismissRequestTransfer $shoppingListDismissRequest
     *
     * @return \Generated\Shared\Transfer\ShoppingListShareResponseTransfer
     */
    public function dismissShoppingListSharing(ShoppingListDismissRequestTransfer $shoppingListDismissRequest): ShoppingListShareResponseTransfer;

    /**
     * Specification:
     *  - Gets customer from session.
     *  - Makes Zed request. Gets customer by email.
     *  - Updates customer in session.
     *
     * @api
     *
     * @return void
     */
    public function updateCustomerPermission(): void;

    /**
     * Specification:
     * - Requires ProductViewTransfer::CurrentProductPrice.
     * - Returns calculated subtotal.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\ProductViewTransfer> $shoppingListItemProductViews
     *
     * @return int
     */
    public function calculateShoppingListSubtotal(array $shoppingListItemProductViews): int;

    /**
     * Specification:
     * - Makes Zed request.
     * - Finds shopping list by uuid.
     * - Requires uuid field to be set in ShoppingListTransfer.
     * - Requires idCompanyUser field to be set in ShoppingListTransfer.
     * - Uuid is not a required field and could be missing.
     *
     * @api
     *
     * {@internal will work if uuid field is provided.}
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function findShoppingListByUuid(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer;

    /**
     * Specification:
     * - Makes Zed request.
     * - Requires `ShoppingListItemTransfer.uuid` to be set.
     * - Requires `ShoppingListItemTransfer.fkShoppingList` to be set.
     * - Requires `ShoppingListItemTransfer.quantity` to be set.
     * - Expects `ShoppingListItemTransfer.idCompanyUser` to be provided.
     * - Updates shopping list item by UUID.
     * - Checks shopping list write permissions.
     * - Executes {@link \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ShoppingListItemBulkPostSavePluginInterface} plugin stack.
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
    ): ShoppingListItemResponseTransfer;

    /**
     * Specification:
     * - Makes Zed request.
     * - Requires `ShoppingListItemTransfer.uuid` to be set.
     * - Gets shopping list item collection by UUIDs.
     * - Executes {@link \Spryker\Zed\ShoppingListExtension\Dependency\Plugin\ShoppingListItemCollectionExpanderPluginInterface} plugin stack.
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
    ): ShoppingListItemCollectionTransfer;
}
