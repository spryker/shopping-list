<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ShoppingListCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Generated\Shared\Transfer\SpyShoppingListEntityTransfer;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingList;
use Propel\Runtime\Collection\Collection;

interface ShoppingListMapperInterface
{
    public function mapShoppingListTransfer(
        SpyShoppingListEntityTransfer $shoppingListEntityTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListTransfer;

    /**
     * @param array<\Generated\Shared\Transfer\SpyShoppingListEntityTransfer> $shoppingListEntityTransferCollection
     *
     * @return \Generated\Shared\Transfer\ShoppingListCollectionTransfer
     */
    public function mapCollectionTransfer(array $shoppingListEntityTransferCollection): ShoppingListCollectionTransfer;

    /**
     * @param \Propel\Runtime\Collection\Collection<\Orm\Zed\ShoppingList\Persistence\SpyShoppingList> $shoppingListEntities
     * @param \Generated\Shared\Transfer\ShoppingListCollectionTransfer $shoppingListCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListCollectionTransfer
     */
    public function mapShoppingListEntitiesToShoppingListCollectionTransfer(
        Collection $shoppingListEntities,
        ShoppingListCollectionTransfer $shoppingListCollectionTransfer
    ): ShoppingListCollectionTransfer;

    public function mapTransferToEntity(
        ShoppingListTransfer $shoppingListTransfer,
        SpyShoppingList $shoppingListEntity
    ): SpyShoppingList;
}
