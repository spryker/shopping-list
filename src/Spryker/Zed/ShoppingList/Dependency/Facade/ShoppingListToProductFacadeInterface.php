<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Dependency\Facade;

interface ShoppingListToProductFacadeInterface
{
    /**
     * @param string $sku
     *
     * @return bool
     */
    public function hasProductConcrete($sku): bool;

    /**
     * @param string $sku
     *
     * @return int|null
     */
    public function findProductConcreteIdBySku($sku): ?int;

    /**
     * @param string $concreteSku
     *
     * @throws \Spryker\Zed\Product\Business\Exception\MissingProductException
     *
     * @return int
     */
    public function getProductAbstractIdByConcreteSku($concreteSku);
}
