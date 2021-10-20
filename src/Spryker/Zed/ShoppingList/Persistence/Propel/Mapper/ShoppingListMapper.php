<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ShoppingListCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Generated\Shared\Transfer\SpyShoppingListEntityTransfer;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingList;

class ShoppingListMapper implements ShoppingListMapperInterface
{
    /**
     * @var string
     */
    public const FIELD_NUMBER_OF_ITEMS = 'number_of_items';

    /**
     * @var string
     */
    public const FIELD_FIRST_NAME = 'first_name';

    /**
     * @var string
     */
    public const FIELD_LAST_NAME = 'last_name';

    /**
     * @var string
     */
    public const FIELD_CREATED_AT = 'created_at';

    /**
     * @var string
     */
    public const FIELD_UPDATED_AT = 'updated_at';

    /**
     * @var \Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListItemMapperInterface
     */
    protected $shoppingListItemMapper;

    /**
     * @param \Spryker\Zed\ShoppingList\Persistence\Propel\Mapper\ShoppingListItemMapperInterface $shoppingListItemMapper
     */
    public function __construct(ShoppingListItemMapperInterface $shoppingListItemMapper)
    {
        $this->shoppingListItemMapper = $shoppingListItemMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\SpyShoppingListEntityTransfer $shoppingListEntityTransfer
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    public function mapShoppingListTransfer(
        SpyShoppingListEntityTransfer $shoppingListEntityTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListTransfer {
        $shoppingListTransfer = $this->mapShoppingListTransferBaseFields($shoppingListTransfer, $shoppingListEntityTransfer);

        $this->addItemsCount($shoppingListEntityTransfer, $shoppingListTransfer);

        return $this->mapShoppingListItemCollectionTransferToShoppingListTransfer(
            $this->shoppingListItemMapper->mapItemCollectionTransfer($shoppingListEntityTransfer->getSpyShoppingListItems()->getArrayCopy()),
            $shoppingListTransfer,
        );
    }

    /**
     * @param array<\Generated\Shared\Transfer\SpyShoppingListEntityTransfer> $shoppingListEntityTransferCollection
     *
     * @return \Generated\Shared\Transfer\ShoppingListCollectionTransfer
     */
    public function mapCollectionTransfer(array $shoppingListEntityTransferCollection): ShoppingListCollectionTransfer
    {
        $shoppingListItemCollectionTransfer = new ShoppingListCollectionTransfer();
        foreach ($shoppingListEntityTransferCollection as $itemEntityTransfer) {
            $shoppingListItemTransfer = $this->mapShoppingListTransferWithoutItems($itemEntityTransfer, new ShoppingListTransfer());
            $shoppingListItemCollectionTransfer->addShoppingList($shoppingListItemTransfer);
        }

        return $shoppingListItemCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     * @param \Orm\Zed\ShoppingList\Persistence\SpyShoppingList $shoppingListEntity
     *
     * @return \Orm\Zed\ShoppingList\Persistence\SpyShoppingList
     */
    public function mapTransferToEntity(ShoppingListTransfer $shoppingListTransfer, SpyShoppingList $shoppingListEntity): SpyShoppingList
    {
        $shoppingListEntity->fromArray($shoppingListTransfer->modifiedToArray());

        return $shoppingListEntity;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    protected function mapShoppingListItemCollectionTransferToShoppingListTransfer(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListTransfer {
        foreach ($shoppingListItemCollectionTransfer->getItems() as $shoppingListItemTransfer) {
            $shoppingListTransfer->addItem($shoppingListItemTransfer);
        }

        return $shoppingListTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SpyShoppingListEntityTransfer $shoppingListEntityTransfer
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return void
     */
    protected function addItemsCount(
        SpyShoppingListEntityTransfer $shoppingListEntityTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): void {
        $numberOfItems = [];
        foreach ($shoppingListEntityTransfer->getSpyShoppingListItems() as $shoppingListItem) {
            if (!isset($numberOfItems[$shoppingListItem->getSku()])) {
                $numberOfItems[$shoppingListItem->getSku()] = 0;
            }

            $numberOfItems[$shoppingListItem->getSku()] += (int)$shoppingListItem->getQuantity();
        }

        $shoppingListTransfer->setNumberOfItems(array_sum($numberOfItems));
    }

    /**
     * @param \Generated\Shared\Transfer\SpyShoppingListEntityTransfer $shoppingListEntityTransfer
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    public function mapShoppingListTransferWithoutItems(
        SpyShoppingListEntityTransfer $shoppingListEntityTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListTransfer {
        $shoppingListTransfer = $this->mapShoppingListTransferBaseFields($shoppingListTransfer, $shoppingListEntityTransfer);

        $virtualPropertiesCollection = $shoppingListEntityTransfer->virtualProperties();

        if (isset($virtualPropertiesCollection[static::FIELD_NUMBER_OF_ITEMS])) {
            $shoppingListTransfer->setNumberOfItems((int)$virtualPropertiesCollection[static::FIELD_NUMBER_OF_ITEMS]);
        }

        return $shoppingListTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     * @param \Generated\Shared\Transfer\SpyShoppingListEntityTransfer $shoppingListEntityTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListTransfer
     */
    protected function mapShoppingListTransferBaseFields(
        ShoppingListTransfer $shoppingListTransfer,
        SpyShoppingListEntityTransfer $shoppingListEntityTransfer
    ): ShoppingListTransfer {
        $shoppingListTransfer = $shoppingListTransfer->fromArray($shoppingListEntityTransfer->modifiedToArray(), true);

        $virtualPropertiesCollection = $shoppingListEntityTransfer->virtualProperties();

        $ownerTitle = $this->extractOwnerTitle($shoppingListEntityTransfer);
        if ($ownerTitle !== null) {
            $shoppingListTransfer->setOwner($ownerTitle);
        }
        if (isset($virtualPropertiesCollection[static::FIELD_CREATED_AT])) {
            $shoppingListTransfer->setCreatedAt($virtualPropertiesCollection[static::FIELD_CREATED_AT]);
        }
        if (isset($virtualPropertiesCollection[static::FIELD_UPDATED_AT])) {
            $shoppingListTransfer->setUpdatedAt($virtualPropertiesCollection[static::FIELD_UPDATED_AT]);
        }

        return $shoppingListTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SpyShoppingListEntityTransfer $shoppingListEntityTransfer
     *
     * @return string|null
     */
    protected function extractOwnerTitle(SpyShoppingListEntityTransfer $shoppingListEntityTransfer): ?string
    {
        $virtualPropertiesCollection = $shoppingListEntityTransfer->virtualProperties();

        if (isset($virtualPropertiesCollection[static::FIELD_FIRST_NAME]) || isset($virtualPropertiesCollection[static::FIELD_LAST_NAME])) {
            return trim(sprintf(
                '%s %s',
                $virtualPropertiesCollection[static::FIELD_FIRST_NAME] ?? '',
                $virtualPropertiesCollection[static::FIELD_LAST_NAME] ?? '',
            ));
        }

        return null;
    }
}
