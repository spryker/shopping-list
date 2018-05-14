<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingList\Dependency\Client;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

class ShoppingListToZedRequestClientBridge implements ShoppingListToZedRequestClientInterface
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct($zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer[]
     */
    public function getLastResponseErrorMessages()
    {
        return $this->zedRequestClient->getLastResponseErrorMessages();
    }

    /**
     * @param string $url
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $object
     * @param array|int|null $requestOptions
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function call($url, TransferInterface $object, $requestOptions = null): TransferInterface
    {
        return $this->zedRequestClient->call($url, $object, $requestOptions);
    }

    /**
     * @return void
     */
    public function addFlashMessagesFromLastZedRequest()
    {
        $this->zedRequestClient->addFlashMessagesFromLastZedRequest();
    }
}
