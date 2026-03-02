<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business\ShoppingListItem;

use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListPreAddItemCheckResponseTransfer;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToProductFacadeInterface;
use Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToStoreFacadeInterface;

class ShoppingListItemChecker implements ShoppingListItemCheckerInterface
{
    /**
     * @var string
     */
    protected const GLOSSARY_KEY_PRODUCT_STORE_INVALID = 'shopping_list.pre.check.product.store_invalid';

    /**
     * @var \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToStoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @var \Spryker\Zed\ShoppingList\Dependency\Facade\ShoppingListToProductFacadeInterface
     */
    protected $productFacade;

    public function __construct(
        ShoppingListToStoreFacadeInterface $storeFacade,
        ShoppingListToProductFacadeInterface $productFacade
    ) {
        $this->storeFacade = $storeFacade;
        $this->productFacade = $productFacade;
    }

    public function checkShoppingListItemProductHasValidStore(
        ShoppingListItemTransfer $shoppingListItemTransfer
    ): ShoppingListPreAddItemCheckResponseTransfer {
        $shoppingListPreAddItemCheckResponseTransfer = new ShoppingListPreAddItemCheckResponseTransfer();
        $shoppingListPreAddItemCheckResponseTransfer->setIsSuccess(true);

        $concreteSku = $shoppingListItemTransfer->getSku();
        if (!$concreteSku) {
            return $shoppingListPreAddItemCheckResponseTransfer;
        }

        $productAbstractTransfer = $this->findProductAbstractTransferByConcreteSku($concreteSku);

        if (!$productAbstractTransfer) {
            return $shoppingListPreAddItemCheckResponseTransfer;
        }

        if ($this->isProductAbstractStoreValid($productAbstractTransfer)) {
            return $shoppingListPreAddItemCheckResponseTransfer->setIsSuccess(true);
        }

        return $shoppingListPreAddItemCheckResponseTransfer
            ->setIsSuccess(false)
            ->addMessage((new MessageTransfer())->setValue(static::GLOSSARY_KEY_PRODUCT_STORE_INVALID));
    }

    protected function findProductAbstractTransferByConcreteSku(string $concreteSku): ?ProductAbstractTransfer
    {
        $productConcreteTransfer = $this->productFacade->getProductConcrete($concreteSku);
        $idProductAbstract = $productConcreteTransfer->getFkProductAbstract();

        return $this->productFacade->findProductAbstractById($idProductAbstract);
    }

    protected function isProductAbstractStoreValid(ProductAbstractTransfer $productAbstractTransfer): bool
    {
        $storeTransfers = $productAbstractTransfer->getStoreRelation()->getStores();
        $currentStoreName = $this->storeFacade->getCurrentStore()->getName();

        foreach ($storeTransfers as $storeTransfer) {
            if ($storeTransfer->getName() === $currentStoreName) {
                return true;
            }
        }

        return false;
    }
}
