<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Persistence;

use Generated\Shared\Transfer\PermissionTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyBusinessUnitBlacklistTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyUserTransfer;
use Generated\Shared\Transfer\ShoppingListItemCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Generated\Shared\Transfer\SpyShoppingListPermissionGroupEntityTransfer;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListCompanyBusinessUnit;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListCompanyBusinessUnitBlacklist;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListCompanyUser;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListItem;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Spryker\Zed\ShoppingList\Persistence\ShoppingListPersistenceFactory getFactory()
 */
class ShoppingListEntityManager extends AbstractEntityManager implements ShoppingListEntityManagerInterface
{
    public function saveShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListTransfer
    {
        $shoppingListEntity = $this->getFactory()
            ->createShoppingListQuery()
            ->filterByIdShoppingList($shoppingListTransfer->getIdShoppingList())
            ->findOneOrCreate();
        $shoppingListEntity = $this->getFactory()->createShoppingListMapper()
            ->mapTransferToEntity($shoppingListTransfer, $shoppingListEntity);

        $shoppingListEntity->save();
        $shoppingListTransfer->fromArray($shoppingListEntity->toArray());

        return $shoppingListTransfer;
    }

    public function deleteShoppingListByName(ShoppingListTransfer $shoppingListTransfer): void
    {
        $shoppingListEntity = $this->getFactory()
            ->createShoppingListQuery()
            ->filterByCustomerReference($shoppingListTransfer->getCustomerReference())
            ->filterByName($shoppingListTransfer->getName())
            ->findOne();

        $shoppingListEntity->delete();
    }

    public function deleteShoppingListItems(ShoppingListTransfer $shoppingListTransfer): void
    {
        $shoppingListEntities = $this->getFactory()
            ->createShoppingListItemQuery()
            ->filterByFkShoppingList($shoppingListTransfer->getIdShoppingList())
            ->find();
        foreach ($shoppingListEntities as $shoppingListEntity) {
            $shoppingListEntity->delete();
        }
    }

    public function saveShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer
    {
        $shoppingListItemEntity = $this->getFactory()
            ->createShoppingListItemQuery()
            ->filterByIdShoppingListItem($shoppingListItemTransfer->getIdShoppingListItem())
            ->findOne();

        if ($shoppingListItemEntity !== null) {
            return $this->updateShoppingListItem($shoppingListItemTransfer, $shoppingListItemEntity);
        }

        return $this->createShoppingListItem($shoppingListItemTransfer);
    }

    public function saveShoppingListItemByUuid(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer
    {
        $shoppingListItemEntity = $this->getFactory()
            ->createShoppingListItemQuery()
            ->filterByUuid($shoppingListItemTransfer->getUuidOrFail())
            ->findOne();

        if ($shoppingListItemEntity !== null) {
            return $this->updateShoppingListItem($shoppingListItemTransfer, $shoppingListItemEntity);
        }

        return $this->createShoppingListItem($shoppingListItemTransfer);
    }

    protected function createShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer
    {
        $shoppingListItemEntity = $this->getFactory()
            ->createShoppingListItemMapper()
            ->mapTransferToEntity($shoppingListItemTransfer, new SpyShoppingListItem());

        $shoppingListItemEntity->save();
        $shoppingListItemTransfer->fromArray($shoppingListItemEntity->toArray(), true);

        return $shoppingListItemTransfer;
    }

    protected function updateShoppingListItem(
        ShoppingListItemTransfer $shoppingListItemTransfer,
        SpyShoppingListItem $shoppingListItemEntity
    ): ShoppingListItemTransfer {
        $shoppingListItemEntity = $this->getFactory()
            ->createShoppingListItemMapper()
            ->mapTransferToEntity($shoppingListItemTransfer, $shoppingListItemEntity);

        $shoppingListItemEntity->save();

        $shoppingListItemTransfer->fromArray($shoppingListItemEntity->toArray(), true);

        return $shoppingListItemTransfer;
    }

    public function deleteShoppingListItem(int $idShoppingListItem): void
    {
        $this->getFactory()
            ->createShoppingListItemQuery()
            ->filterByIdShoppingListItem($idShoppingListItem)
            ->findOne()
            ->delete();
    }

    public function saveShoppingListPermissionGroup(
        SpyShoppingListPermissionGroupEntityTransfer $shoppingListPermissionGroupEntityTransfer
    ): SpyShoppingListPermissionGroupEntityTransfer {
        $shoppingListPermissionGroupEntity = $this->getFactory()
            ->createShoppingListPermissionGroupQuery()
            ->filterByName($shoppingListPermissionGroupEntityTransfer->getName())
            ->findOneOrCreate();

        $shoppingListPermissionGroupEntity->fromArray($shoppingListPermissionGroupEntityTransfer->modifiedToArray());
        $shoppingListPermissionGroupEntity->save();

        $shoppingListPermissionGroupEntityTransfer->fromArray($shoppingListPermissionGroupEntity->toArray(), true);

        return $shoppingListPermissionGroupEntityTransfer;
    }

    public function saveShoppingListPermissionGroupToPermission(
        SpyShoppingListPermissionGroupEntityTransfer $shoppingListPermissionGroupEntityTransfer,
        PermissionTransfer $permissionTransfer
    ): void {
        $this->getFactory()
            ->createShoppingListPermissionGroupToPermissionQuery()
            ->filterByFkPermission($permissionTransfer->getIdPermission())
            ->filterByFkShoppingListPermissionGroup($shoppingListPermissionGroupEntityTransfer->getIdShoppingListPermissionGroup())
            ->findOneOrCreate()
            ->save();
    }

    public function saveShoppingListCompanyBusinessUnit(
        ShoppingListCompanyBusinessUnitTransfer $shoppingListCompanyBusinessUnitTransfer
    ): void {
        $shoppingListCompanyBusinessUnitEntity = $this->getFactory()
            ->createShoppingListCompanyBusinessUnitQuery()
            ->filterByIdShoppingListCompanyBusinessUnit($shoppingListCompanyBusinessUnitTransfer->getIdShoppingListCompanyBusinessUnit())
            ->findOne();

        if ($shoppingListCompanyBusinessUnitEntity !== null) {
            $this->updateShoppingListCompanyBusinessUnit($shoppingListCompanyBusinessUnitTransfer, $shoppingListCompanyBusinessUnitEntity);

            return;
        }

        $this->createShoppingListCompanyBusinessUnit($shoppingListCompanyBusinessUnitTransfer);
    }

    public function saveShoppingListCompanyUser(
        ShoppingListCompanyUserTransfer $shoppingListCompanyUserTransfer
    ): void {
        $shoppingListCompanyUserEntity = $this->getFactory()
            ->createShoppingListCompanyUserQuery()
            ->filterByIdShoppingListCompanyUser($shoppingListCompanyUserTransfer->getIdShoppingListCompanyUser())
            ->findOne();

        if ($shoppingListCompanyUserEntity !== null) {
            $this->updateShoppingListCompanyUser($shoppingListCompanyUserTransfer, $shoppingListCompanyUserEntity);

            return;
        }

        $this->createShoppingListCompanyUser($shoppingListCompanyUserTransfer);
    }

    public function deleteShoppingListCompanyUser(ShoppingListCompanyUserTransfer $shoppingListCompanyUserTransfer): void
    {
        $this->getFactory()
            ->createShoppingListCompanyUserQuery()
            ->findOneByIdShoppingListCompanyUser($shoppingListCompanyUserTransfer->getIdShoppingListCompanyUser())
            ->delete();
    }

    public function deleteShoppingListCompanyUsers(ShoppingListTransfer $shoppingListTransfer): void
    {
        $shoppingListCompanyUserEntities = $this->getFactory()
            ->createShoppingListCompanyUserQuery()
            ->filterByFkShoppingList($shoppingListTransfer->getIdShoppingList())
            ->find();

        foreach ($shoppingListCompanyUserEntities as $shoppingListCompanyUserEntity) {
            $shoppingListCompanyUserEntity->delete();
        }
    }

    public function deleteShoppingListCompanyBusinessUnits(ShoppingListTransfer $shoppingListTransfer): void
    {
        $shoppingListCompanyBusinessUnitEntities = $this->getFactory()
            ->createShoppingListCompanyBusinessUnitQuery()
            ->filterByFkShoppingList($shoppingListTransfer->getIdShoppingList())
            ->find();

        foreach ($shoppingListCompanyBusinessUnitEntities as $shoppingListCompanyBusinessUnitEntity) {
            $shoppingListCompanyBusinessUnitEntity->delete();
        }
    }

    public function deleteShoppingListCompanyBusinessUnitsByCompanyBusinessUnitId(int $idCompanyBusinessUnit): void
    {
        $this->getFactory()
            ->createShoppingListCompanyBusinessUnitQuery()
            ->filterByFkCompanyBusinessUnit($idCompanyBusinessUnit)
            ->delete();
    }

    public function deleteShoppingListsCompanyUserByCompanyUserId(int $idCompanyUser): void
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $shoppingListCompanyUserCollection */
        $shoppingListCompanyUserCollection = $this->getFactory()
            ->createShoppingListCompanyUserQuery()
            ->filterByFkCompanyUser($idCompanyUser)
            ->find();

        $shoppingListCompanyUserCollection->delete();
    }

    public function deleteShoppingListCompanyBusinessUnit(ShoppingListCompanyBusinessUnitTransfer $shoppingListCompanyBusinessUnitTransfer): void
    {
        $this->getFactory()
            ->createShoppingListCompanyBusinessUnitQuery()
            ->findOneByIdShoppingListCompanyBusinessUnit($shoppingListCompanyBusinessUnitTransfer->getIdShoppingListCompanyBusinessUnit())
            ->delete();
    }

    protected function createShoppingListCompanyBusinessUnit(
        ShoppingListCompanyBusinessUnitTransfer $shoppingListCompanyBusinessUnitTransfer
    ): void {
        $shoppingListCompanyBusinessUnitEntity = $this->getFactory()
            ->createShoppingListCompanyBusinessUnitMapper()
            ->mapCompanyBusinessUnitTransferToCompanyBusinessUnitEntity(
                $shoppingListCompanyBusinessUnitTransfer,
                new SpyShoppingListCompanyBusinessUnit(),
            );

        $shoppingListCompanyBusinessUnitEntity->save();
    }

    protected function updateShoppingListCompanyBusinessUnit(
        ShoppingListCompanyBusinessUnitTransfer $shoppingListCompanyBusinessUnitTransfer,
        SpyShoppingListCompanyBusinessUnit $shoppingListCompanyBusinessUnitEntity
    ): void {
        $shoppingListCompanyBusinessUnitEntity = $this->getFactory()
            ->createShoppingListCompanyBusinessUnitMapper()
            ->mapCompanyBusinessUnitTransferToCompanyBusinessUnitEntity(
                $shoppingListCompanyBusinessUnitTransfer,
                $shoppingListCompanyBusinessUnitEntity,
            );

        $shoppingListCompanyBusinessUnitEntity->save();
    }

    protected function createShoppingListCompanyUser(
        ShoppingListCompanyUserTransfer $shoppingListCompanyUserTransfer
    ): void {
        $shoppingListCompanyUserEntity = $this->getFactory()
            ->createShoppingListCompanyUserMapper()
            ->mapCompanyUserTransferToCompanyUserEntity(
                $shoppingListCompanyUserTransfer,
                new SpyShoppingListCompanyUser(),
            );

        $shoppingListCompanyUserEntity->save();
    }

    protected function updateShoppingListCompanyUser(
        ShoppingListCompanyUserTransfer $shoppingListCompanyUserTransfer,
        SpyShoppingListCompanyUser $shoppingListCompanyUserEntity
    ): void {
        $shoppingListCompanyUserEntity = $this->getFactory()
            ->createShoppingListCompanyUserMapper()
            ->mapCompanyUserTransferToCompanyUserEntity(
                $shoppingListCompanyUserTransfer,
                $shoppingListCompanyUserEntity,
            );

        $shoppingListCompanyUserEntity->save();
    }

    public function createShoppingListCompanyBusinessUnitBlacklist(
        ShoppingListCompanyBusinessUnitBlacklistTransfer $shoppingListCompanyBusinessUnitBlacklistTransfer
    ): void {
        $shoppingListCompanyBusinessUnitBlacklistEntity = new SpyShoppingListCompanyBusinessUnitBlacklist();
        $shoppingListCompanyBusinessUnitBlacklistEntity->fromArray($shoppingListCompanyBusinessUnitBlacklistTransfer->modifiedToArray());
        $shoppingListCompanyBusinessUnitBlacklistEntity->save();
    }

    public function deleteCompanyBusinessUnitBlacklistByShoppingListId(int $idShoppingList): void
    {
        $shoppingListCompanyBusinessUnitBlacklistEntities = $this->getFactory()
            ->createShoppingListCompanyBusinessUnitBlacklistPropelQuery()
            ->useSpyShoppingListCompanyBusinessUnitQuery(null, Criteria::LEFT_JOIN)
            ->filterByFkShoppingList($idShoppingList)
            ->endUse()
            ->find();
        foreach ($shoppingListCompanyBusinessUnitBlacklistEntities as $shoppingListCompanyBusinessUnitBlacklistEntity) {
            $shoppingListCompanyBusinessUnitBlacklistEntity->delete();
        }
    }

    public function deleteCompanyBusinessUnitBlacklistByBusinessUnitId(int $idCompanyBusinessUnit): void
    {
        $shoppingListCompanyBusinessUnitBlacklistEntities = $this->getFactory()
            ->createShoppingListCompanyBusinessUnitBlacklistPropelQuery()
            ->useSpyShoppingListCompanyBusinessUnitQuery(null, Criteria::LEFT_JOIN)
            ->filterByFkCompanyBusinessUnit($idCompanyBusinessUnit)
            ->endUse()
            ->find();
        foreach ($shoppingListCompanyBusinessUnitBlacklistEntities as $shoppingListCompanyBusinessUnitBlacklistEntity) {
            $shoppingListCompanyBusinessUnitBlacklistEntity->delete();
        }
    }

    public function deleteShoppingListCompanyBusinessUnitBlacklistsByIdCompanyUser(int $idCompanyUser): void
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $shoppingListCompanyBusinessUnitBlacklistCollection */
        $shoppingListCompanyBusinessUnitBlacklistCollection = $this->getFactory()
            ->createShoppingListCompanyBusinessUnitBlacklistPropelQuery()
                ->filterByFkCompanyUser($idCompanyUser)
            ->find();

        $shoppingListCompanyBusinessUnitBlacklistCollection->delete();
    }

    public function saveShoppingListItems(
        ShoppingListItemCollectionTransfer $shoppingListItemCollectionTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListItemCollectionTransfer {
        if (count($shoppingListItemCollectionTransfer->getItems()) == 0) {
            return $shoppingListItemCollectionTransfer;
        }

        $shoppingListItemMapper = $this->getFactory()->createShoppingListItemMapper();
        $persistedShoppingListItemCollectionTransfer = new ShoppingListItemCollectionTransfer();

        foreach ($shoppingListItemCollectionTransfer->getItems() as $shoppingListItemTransfer) {
            $shoppingListItemEntity = $shoppingListItemMapper->mapTransferToEntity($shoppingListItemTransfer, new SpyShoppingListItem());
            $shoppingListItemEntity->save();

            $shoppingListItemTransfer = $shoppingListItemMapper->mapSpyShoppingListItemEntityToShoppingListItemTransfer(
                $shoppingListItemEntity,
                $shoppingListItemTransfer,
            );

            $persistedShoppingListItemCollectionTransfer->addItem($shoppingListItemTransfer);
        }

        return $persistedShoppingListItemCollectionTransfer;
    }
}
