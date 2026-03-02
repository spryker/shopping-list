<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ShoppingListCompanyUserCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyUserTransfer;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListCompanyUser;
use Propel\Runtime\Collection\Collection;

class ShoppingListCompanyUserMapper implements ShoppingListCompanyUserMapperInterface
{
    public function mapCompanyUserEntitiesToShoppingListCompanyUserCollection(
        Collection $companyUserEntityCollection,
        ShoppingListCompanyUserCollectionTransfer $shoppingListCompanyUserCollection
    ): ShoppingListCompanyUserCollectionTransfer {
        foreach ($companyUserEntityCollection as $companyUserEntityTransfer) {
            $shoppingListCompanyUserCollection->addShoppingListCompanyUser(
                $this->mapCompanyUserEntityToCompanyUserTransfer($companyUserEntityTransfer, new ShoppingListCompanyUserTransfer()),
            );
        }

        return $shoppingListCompanyUserCollection;
    }

    public function mapCompanyUserEntityToCompanyUserTransfer(
        SpyShoppingListCompanyUser $shoppingListCompanyUser,
        ShoppingListCompanyUserTransfer $shoppingListCompanyUserTransfer
    ): ShoppingListCompanyUserTransfer {
        return $shoppingListCompanyUserTransfer
            ->setIdShoppingListCompanyUser($shoppingListCompanyUser->getIdShoppingListCompanyUser())
            ->setIdShoppingList($shoppingListCompanyUser->getFkShoppingList())
            ->setIdCompanyUser($shoppingListCompanyUser->getFkCompanyUser())
            ->setIdShoppingListPermissionGroup($shoppingListCompanyUser->getFkShoppingListPermissionGroup());
    }

    public function mapCompanyUserTransferToCompanyUserEntity(
        ShoppingListCompanyUserTransfer $shoppingListCompanyUserTransfer,
        SpyShoppingListCompanyUser $shoppingListCompanyUserEntity
    ): SpyShoppingListCompanyUser {
        $shoppingListCompanyUserEntity->fromArray($shoppingListCompanyUserTransfer->modifiedToArray());

        $shoppingListCompanyUserEntity
            ->setFkCompanyUser($shoppingListCompanyUserTransfer->getIdCompanyUser())
            ->setFkShoppingList($shoppingListCompanyUserTransfer->getIdShoppingList())
            ->setFkShoppingListPermissionGroup($shoppingListCompanyUserTransfer->getIdShoppingListPermissionGroup());

        return $shoppingListCompanyUserEntity;
    }
}
