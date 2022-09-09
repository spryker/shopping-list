<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ShoppingListItemCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\SpyShoppingListItemEntityTransfer;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListItem;
use Propel\Runtime\Collection\ObjectCollection;

class ShoppingListItemMapper implements ShoppingListItemMapperInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\SpyShoppingListItemEntityTransfer> $itemEntityTransferCollection
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function mapItemCollectionTransfer(array $itemEntityTransferCollection): ShoppingListItemCollectionTransfer
    {
        $shoppingListItemCollectionTransfer = new ShoppingListItemCollectionTransfer();
        foreach ($itemEntityTransferCollection as $itemEntityTransfer) {
            $shoppingListItemTransfer = $this->mapItemTransfer($itemEntityTransfer, new ShoppingListItemTransfer());
            $shoppingListItemCollectionTransfer->addItem($shoppingListItemTransfer);
        }

        return $shoppingListItemCollectionTransfer;
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ShoppingList\Persistence\SpyShoppingListItem> $shoppingListItemEntities
     * @param \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer
     */
    public function mapShoppingListItemEntitiesToShoppingListItemCollectionTransfer(
        ObjectCollection $shoppingListItemEntities,
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
    ): ShoppingListItemCollectionTransfer {
        foreach ($shoppingListItemEntities as $shoppingListItemEntity) {
            $shoppingListItemTransfer = (new ShoppingListItemTransfer())
                ->fromArray($shoppingListItemEntity->toArray(), true);

            $shoppingListItemCollectionTransfer->addItem($shoppingListItemTransfer);
        }

        return $shoppingListItemCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SpyShoppingListItemEntityTransfer $itemEntityTransfer
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function mapItemTransfer(
        SpyShoppingListItemEntityTransfer $itemEntityTransfer,
        ShoppingListItemTransfer $shoppingListItemTransfer
    ): ShoppingListItemTransfer {
        return $shoppingListItemTransfer->fromArray($itemEntityTransfer->modifiedToArray(), true);
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     * @param \Orm\Zed\ShoppingList\Persistence\SpyShoppingListItem $shoppingListItemEntity
     *
     * @return \Orm\Zed\ShoppingList\Persistence\SpyShoppingListItem
     */
    public function mapTransferToEntity(
        ShoppingListItemTransfer $shoppingListItemTransfer,
        SpyShoppingListItem $shoppingListItemEntity
    ): SpyShoppingListItem {
        $shoppingListItemEntity->fromArray($shoppingListItemTransfer->modifiedToArray());

        return $shoppingListItemEntity;
    }

    /**
     * @param \Orm\Zed\ShoppingList\Persistence\SpyShoppingListItem $shoppingListItemEntity
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function mapSpyShoppingListItemEntityToShoppingListItemTransfer(
        SpyShoppingListItem $shoppingListItemEntity,
        ShoppingListItemTransfer $shoppingListItemTransfer
    ): ShoppingListItemTransfer {
        $shoppingListItemTransfer->fromArray($shoppingListItemEntity->toArray(), true);

        return $shoppingListItemTransfer;
    }
}
