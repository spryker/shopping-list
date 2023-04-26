<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ShoppingList\Business\ShoppingListFacade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ShoppingListShareRequestTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use SprykerTest\Zed\ShoppingList\ShoppingListBusinessTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ShoppingList
 * @group Business
 * @group ShoppingListFacade
 * @group UnShareCompanyUserShoppingListsTest
 * Add your own group annotations below this line
 */
class UnShareCompanyUserShoppingListsTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\ShoppingList\ShoppingListBusinessTester
     */
    protected ShoppingListBusinessTester $tester;

    /**
     * @return void
     */
    public function testUnShareCompanyUserShoppingListDeletesAllCompanyBusinessUnitBlacklistsAndSharedShoppingLists()
    {
        // Arrange
        $companyUserTransfer1 = $this->tester->createCompanyUserForBusinessUnit();
        $companyUserTransfer2 = $this->tester->createCompanyUserForBusinessUnit();
        $companyUserTransfer3 = $this->tester->createCompanyUserForBusinessUnit();

        $shoppingListTransfer1 = $this->tester->haveShoppingList([
            ShoppingListTransfer::CUSTOMER_REFERENCE => $companyUserTransfer1->getCustomerOrFail()->getCustomerReference(),
            ShoppingListTransfer::ID_COMPANY_USER => $companyUserTransfer1->getIdCompanyUser(),
        ]);
        $shoppingListTransfer2 = $this->tester->haveShoppingList([
            ShoppingListTransfer::CUSTOMER_REFERENCE => $companyUserTransfer2->getCustomerOrFail()->getCustomerReference(),
            ShoppingListTransfer::ID_COMPANY_USER => $companyUserTransfer2->getIdCompanyUser(),
        ]);

        $this->tester->shareShopppingListWithCompanyUser($shoppingListTransfer1, $companyUserTransfer3);
        $this->tester->shareShopppingListWithCompanyUser($shoppingListTransfer2, $companyUserTransfer3);

        $shoppingListCompanyBusinessUnitBlacklistTransfer1 = $this->tester
            ->createShoppingListCompanyBusinessUnitBlacklist(
                $companyUserTransfer3,
                $shoppingListTransfer1,
            );
        $shoppingListCompanyBusinessUnitBlacklistTransfer2 = $this->tester
            ->createShoppingListCompanyBusinessUnitBlacklist(
                $companyUserTransfer3,
                $shoppingListTransfer2,
            );

        $shoppingListShareRequestTransfer = (new ShoppingListShareRequestTransfer())
            ->setIdCompanyUser($companyUserTransfer3->getIdCompanyUser())
            ->setWithCompanyBusinessUnitBlacklists(true);

        // Act
        $this->tester->getFacade()->unShareCompanyUserShoppingLists($shoppingListShareRequestTransfer);

        $shoppingListCompanyBusinessUnitBlacklistTransfers = $this->tester->findShoppingListCompanyBusinessUnitBlacklists(
            [
                $shoppingListCompanyBusinessUnitBlacklistTransfer1->getIdShoppingListCompanyBusinessUnitBlacklistOrFail(),
                $shoppingListCompanyBusinessUnitBlacklistTransfer2->getIdShoppingListCompanyBusinessUnitBlacklistOrFail(),
            ],
        );
        $shopppingListCompanyUserCollectionTransfer = $this->tester->findShoppingListCompanyUsers(
            $companyUserTransfer3->getIdCompanyUserOrFail(),
        );
        $persistedShoppingListTransfer1 = $this->tester->findShoppingList($shoppingListTransfer1);
        $persistedShoppingListTransfer2 = $this->tester->findShoppingList($shoppingListTransfer2);

        // Accert
        $this->assertEmpty($shoppingListCompanyBusinessUnitBlacklistTransfers);
        $this->assertEmpty($shopppingListCompanyUserCollectionTransfer->getShoppingListCompanyUsers());
        $this->assertNotNull($persistedShoppingListTransfer1);
        $this->assertNotNull($persistedShoppingListTransfer1);
    }

    /**
     * @return void
     */
    public function testUnShareCompanyUserShoppingListDeletesSharedShoppingListsButNotCompanyBusinessUnitBlacklists()
    {
        // Arrange
        $companyUserTransfer1 = $this->tester->createCompanyUserForBusinessUnit();
        $companyUserTransfer2 = $this->tester->createCompanyUserForBusinessUnit();
        $companyUserTransfer3 = $this->tester->createCompanyUserForBusinessUnit();

        $shoppingListTransfer1 = $this->tester->haveShoppingList([
            ShoppingListTransfer::CUSTOMER_REFERENCE => $companyUserTransfer1->getCustomerOrFail()->getCustomerReference(),
            ShoppingListTransfer::ID_COMPANY_USER => $companyUserTransfer1->getIdCompanyUser(),
        ]);
        $shoppingListTransfer2 = $this->tester->haveShoppingList([
            ShoppingListTransfer::CUSTOMER_REFERENCE => $companyUserTransfer2->getCustomerOrFail()->getCustomerReference(),
            ShoppingListTransfer::ID_COMPANY_USER => $companyUserTransfer2->getIdCompanyUser(),
        ]);

        $this->tester->shareShopppingListWithCompanyUser($shoppingListTransfer1, $companyUserTransfer3);
        $this->tester->shareShopppingListWithCompanyUser($shoppingListTransfer2, $companyUserTransfer3);

        $shoppingListCompanyBusinessUnitBlacklistTransfer1 = $this->tester
            ->createShoppingListCompanyBusinessUnitBlacklist(
                $companyUserTransfer3,
                $shoppingListTransfer1,
            );
        $shoppingListCompanyBusinessUnitBlacklistTransfer2 = $this->tester
            ->createShoppingListCompanyBusinessUnitBlacklist(
                $companyUserTransfer3,
                $shoppingListTransfer2,
            );

        $shoppingListShareRequestTransfer = (new ShoppingListShareRequestTransfer())
            ->setIdCompanyUser($companyUserTransfer3->getIdCompanyUser());

        // Act
        $this->tester->getFacade()->unShareCompanyUserShoppingLists($shoppingListShareRequestTransfer);

        $shoppingListCompanyBusinessUnitBlacklistTransfers = $this->tester->findShoppingListCompanyBusinessUnitBlacklists(
            [
                $shoppingListCompanyBusinessUnitBlacklistTransfer1->getIdShoppingListCompanyBusinessUnitBlacklistOrFail(),
                $shoppingListCompanyBusinessUnitBlacklistTransfer2->getIdShoppingListCompanyBusinessUnitBlacklistOrFail(),
            ],
        );
        $shopppingListCompanyUserCollectionTransfer = $this->tester->findShoppingListCompanyUsers(
            $companyUserTransfer3->getIdCompanyUserOrFail(),
        );
        $persistedShoppingListTransfer1 = $this->tester->findShoppingList($shoppingListTransfer1);
        $persistedShoppingListTransfer2 = $this->tester->findShoppingList($shoppingListTransfer2);

        // Accert
        $this->assertEquals(
            [$shoppingListCompanyBusinessUnitBlacklistTransfer1, $shoppingListCompanyBusinessUnitBlacklistTransfer2],
            $shoppingListCompanyBusinessUnitBlacklistTransfers,
        );
        $this->assertEmpty($shopppingListCompanyUserCollectionTransfer->getShoppingListCompanyUsers());
        $this->assertNotNull($persistedShoppingListTransfer1);
        $this->assertNotNull($persistedShoppingListTransfer1);
    }
}
