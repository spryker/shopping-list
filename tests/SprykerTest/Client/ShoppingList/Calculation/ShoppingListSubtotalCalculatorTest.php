<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Client\ShoppingList\Calculation;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Client\ShoppingList\Calculation\ShoppingListSubtotalCalculator;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Client
 * @group ShoppingList
 * @group Calculation
 * @group ShoppingListSubtotalCalculatorTest
 * Add your own group annotations below this line
 */
class ShoppingListSubtotalCalculatorTest extends Unit
{
    /**
     * @var \SprykerTest\Client\ShoppingList\ShoppingListClientTester
     */
    protected $tester;

    /**
     * @var \Spryker\Client\ShoppingList\Calculation\ShoppingListSubtotalCalculatorInterface
     */
    protected $shoppingListSubtotalCalculator;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->shoppingListSubtotalCalculator = new ShoppingListSubtotalCalculator();
    }

    /**
     * @return void
     */
    public function testCalculateShoppingListSubtotalShouldCalculatePricesCorrectly(): void
    {
        $shoppingListItems = [
            (new ProductViewTransfer())->setPrice(1)->setQuantity(1),
            (new ProductViewTransfer())->setPrice(2)->setQuantity(2),
            (new ProductViewTransfer())->setPrice(3)->setQuantity(3),
            (new ProductViewTransfer())->setPrice(4)->setQuantity(4),
            (new ProductViewTransfer())->setPrice(5)->setQuantity(5),
        ];

        $expectedShoppingListSubtotal = 55;

        $this->assertSame(
            $this->shoppingListSubtotalCalculator->calculateShoppingListSubtotal($shoppingListItems),
            $expectedShoppingListSubtotal
        );
    }

    /**
     * @return void
     */
    public function testCalculateShoppingListSubtotalShouldSkipItemsWithoutPriceOrQuantityDuringSubtotalCalculation(): void
    {
        $shoppingListItems = [
            (new ProductViewTransfer())->setPrice(null)->setQuantity(1),
            (new ProductViewTransfer())->setPrice(2)->setQuantity(2),
            (new ProductViewTransfer())->setPrice(3)->setQuantity(null),
            (new ProductViewTransfer())->setPrice(4)->setQuantity(4),
            (new ProductViewTransfer())->setPrice(null)->setQuantity(null),
        ];

        $expectedShoppingListSubtotal = 20;

        $this->assertSame(
            $this->shoppingListSubtotalCalculator->calculateShoppingListSubtotal($shoppingListItems),
            $expectedShoppingListSubtotal
        );
    }
}
