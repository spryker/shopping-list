<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator;

use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;

class ShoppingListItemUpdateOperationValidator implements ShoppingListItemUpdateOperationValidatorInterface
{
    /**
     * @var \Spryker\Zed\ShoppingList\Business\ShoppingListItem\Validator\ShoppingListItemValidatorInterface
     */
    protected $shoppingListItemValidator;

    public function __construct(ShoppingListItemValidatorInterface $shoppingListItemValidator)
    {
        $this->shoppingListItemValidator = $shoppingListItemValidator;
    }

    public function validateRequest(
        ShoppingListItemTransfer $shoppingListItemTransfer,
        ShoppingListItemResponseTransfer $shoppingListItemResponseTransfer
    ): ShoppingListItemResponseTransfer {
        $shoppingListItemResponseTransferWithValidatedQuantity = $this->shoppingListItemValidator
            ->validateShoppingListItemQuantity($shoppingListItemTransfer, $shoppingListItemResponseTransfer);
        if (!$shoppingListItemResponseTransferWithValidatedQuantity->getIsSuccess()) {
            return $shoppingListItemResponseTransferWithValidatedQuantity;
        }

        $shoppingListItemResponseTransferWithValidatedParent = $this->shoppingListItemValidator
            ->checkShoppingListItemParent($shoppingListItemTransfer, $shoppingListItemResponseTransfer);
        if (!$shoppingListItemResponseTransferWithValidatedParent->getIsSuccess()) {
            return $shoppingListItemResponseTransferWithValidatedParent;
        }

        return $shoppingListItemResponseTransfer->setIsSuccess(true);
    }
}
