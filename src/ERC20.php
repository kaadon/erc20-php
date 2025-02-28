<?php
/*
 * This file is a part of "furqansiddiqui/erc20-php" package.
 * https://github.com/furqansiddiqui/erc20-php
 *
 * Copyright (c) Furqan A. Siddiqui <hello@furqansiddiqui.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or visit following link:
 * https://github.com/furqansiddiqui/erc20-php/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Kaadon\Ethereum\ERC20;

use Kaadon\Ethereum\Buffers\EthereumAddress;
use Kaadon\Ethereum\Contracts\Contract;
use Kaadon\Ethereum\RPC\Abstract_RPC_Client;

/**
 * Class ERC20
 * @package Kaadon\Ethereum\ERC20
 */
class ERC20
{
    /**
     * @param \Kaadon\Ethereum\RPC\Abstract_RPC_Client $rpcClient
     * @param \Kaadon\Ethereum\Contracts\Contract $abi
     */
    public function __construct(
        public readonly Abstract_RPC_Client $rpcClient,
        public readonly Contract            $abi = new BaseERC20Contract(),
    )
    {
    }

    /**
     * @param \Kaadon\Ethereum\Buffers\EthereumAddress $address
     * @return \Kaadon\Ethereum\ERC20\ERC20_Token
     */
    public function deployedAt(EthereumAddress $address): ERC20_Token
    {
        return new ERC20_Token($this->abi, $address, $this->rpcClient);
    }
}
