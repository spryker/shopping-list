<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ShoppingListCompanyBusinessUnitCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListCompanyBusinessUnitTransfer;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListCompanyBusinessUnit;
use Propel\Runtime\Collection\Collection;

class ShoppingListCompanyBusinessUnitMapper implements ShoppingListCompanyBusinessUnitMapperInterface
{
    public function mapCompanyBusinessUnitEntitiesToShoppingListCompanyBusinessUnitCollection(
        Collection $companyBusinessUnitEntityCollection,
        ShoppingListCompanyBusinessUnitCollectionTransfer $shoppingListCompanyBusinessUnitCollection
    ): ShoppingListCompanyBusinessUnitCollectionTransfer {
        foreach ($companyBusinessUnitEntityCollection as $companyBusinessUnitEntity) {
            $shoppingListCompanyBusinessUnitCollection->addShoppingListCompanyBusinessUnit(
                $this->mapCompanyBusinessUnitEntityToCompanyBusinessUnitTransfer($companyBusinessUnitEntity, new ShoppingListCompanyBusinessUnitTransfer()),
            );
        }

        return $shoppingListCompanyBusinessUnitCollection;
    }

    public function mapCompanyBusinessUnitEntityToCompanyBusinessUnitTransfer(
        SpyShoppingListCompanyBusinessUnit $shoppingListCompanyBusinessUnit,
        ShoppingListCompanyBusinessUnitTransfer $shoppingListCompanyBusinessUnitTransfer
    ): ShoppingListCompanyBusinessUnitTransfer {
        return $shoppingListCompanyBusinessUnitTransfer
            ->setIdShoppingListCompanyBusinessUnit($shoppingListCompanyBusinessUnit->getIdShoppingListCompanyBusinessUnit())
            ->setIdShoppingList($shoppingListCompanyBusinessUnit->getFkShoppingList())
            ->setIdCompanyBusinessUnit($shoppingListCompanyBusinessUnit->getFkCompanyBusinessUnit())
            ->setIdShoppingListPermissionGroup($shoppingListCompanyBusinessUnit->getFkShoppingListPermissionGroup());
    }

    public function mapCompanyBusinessUnitTransferToCompanyBusinessUnitEntity(
        ShoppingListCompanyBusinessUnitTransfer $shoppingListCompanyBusinessUnitTransfer,
        SpyShoppingListCompanyBusinessUnit $shoppingListCompanyBusinessUnitEntity
    ): SpyShoppingListCompanyBusinessUnit {
        $shoppingListCompanyBusinessUnitEntity->fromArray($shoppingListCompanyBusinessUnitTransfer->modifiedToArray());

        $shoppingListCompanyBusinessUnitEntity
            ->setFkCompanyBusinessUnit($shoppingListCompanyBusinessUnitTransfer->getIdCompanyBusinessUnit())
            ->setFkShoppingList($shoppingListCompanyBusinessUnitTransfer->getIdShoppingList())
            ->setFkShoppingListPermissionGroup($shoppingListCompanyBusinessUnitTransfer->getIdShoppingListPermissionGroup());

        return $shoppingListCompanyBusinessUnitEntity;
    }
}
