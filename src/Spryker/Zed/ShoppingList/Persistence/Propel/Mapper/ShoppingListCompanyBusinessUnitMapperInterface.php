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

interface ShoppingListCompanyBusinessUnitMapperInterface
{
    public function mapCompanyBusinessUnitEntitiesToShoppingListCompanyBusinessUnitCollection(
        Collection $companyBusinessUnitEntityCollection,
        ShoppingListCompanyBusinessUnitCollectionTransfer $shoppingListCompanyBusinessUnitCollection
    ): ShoppingListCompanyBusinessUnitCollectionTransfer;

    public function mapCompanyBusinessUnitEntityToCompanyBusinessUnitTransfer(
        SpyShoppingListCompanyBusinessUnit $shoppingListCompanyBusinessUnit,
        ShoppingListCompanyBusinessUnitTransfer $shoppingListCompanyBusinessUnitTransfer
    ): ShoppingListCompanyBusinessUnitTransfer;

    public function mapCompanyBusinessUnitTransferToCompanyBusinessUnitEntity(
        ShoppingListCompanyBusinessUnitTransfer $shoppingListCompanyBusinessUnitTransfer,
        SpyShoppingListCompanyBusinessUnit $shoppingListCompanyBusinessUnitEntity
    ): SpyShoppingListCompanyBusinessUnit;
}
