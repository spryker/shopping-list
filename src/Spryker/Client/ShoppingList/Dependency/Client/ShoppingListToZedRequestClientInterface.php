<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList\Dependency\Client;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface ShoppingListToZedRequestClientInterface
{
    /**
     * @return \Generated\Shared\Transfer\MessageTransfer[]
     */
    public function getLastResponseErrorMessages();

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer[]
     */
    public function getAllResponsesErrorMessages(): array;

    /**
     * @param string $url
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $object
     * @param array|int|null $requestOptions
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function call($url, TransferInterface $object, $requestOptions = null): TransferInterface;

    /**
     * @deprecated Use ShoppingListToZedRequestClientInterface::addFlashMessagesFromZedRequestHistory() instead
     *
     * @return void
     */
    public function addFlashMessagesFromLastZedRequest();

    /**
     * @return void
     */
    public function addAllResponseMessagesToMessenger();
}
