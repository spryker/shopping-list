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

interface ShoppingListCompanyUserMapperInterface
{
    public function mapCompanyUserEntitiesToShoppingListCompanyUserCollection(
        Collection $companyUserEntityCollection,
        ShoppingListCompanyUserCollectionTransfer $shoppingListCompanyUserCollection
    ): ShoppingListCompanyUserCollectionTransfer;

    public function mapCompanyUserEntityToCompanyUserTransfer(
        SpyShoppingListCompanyUser $shoppingListCompanyUser,
        ShoppingListCompanyUserTransfer $shoppingListCompanyUserTransfer
    ): ShoppingListCompanyUserTransfer;

    public function mapCompanyUserTransferToCompanyUserEntity(
        ShoppingListCompanyUserTransfer $shoppingListCompanyUserTransfer,
        SpyShoppingListCompanyUser $shoppingListCompanyUserEntity
    ): SpyShoppingListCompanyUser;
}
