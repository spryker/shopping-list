<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;

interface ShoppingListToProductFacadeInterface
{
    /**
     * @param string $sku
     *
     * @return bool
     */
    public function hasProductConcrete($sku): bool;

    /**
     * @param array<string> $skus
     *
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    public function findProductConcretesBySkus(array $skus): array;

    public function isProductConcreteActive(ProductConcreteTransfer $productConcreteTransfer): bool;

    public function getProductConcrete(string $concreteSku): ProductConcreteTransfer;

    public function findProductAbstractById(int $idProductAbstract): ?ProductAbstractTransfer;
}
