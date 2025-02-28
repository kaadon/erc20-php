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
use Kaadon\Ethereum\Contracts\DeployedContract;
use Kaadon\Ethereum\ERC20\Exception\ERC20TokenException;

/**
 * Class ERC20_Token
 * @package ERC20
 */
class ERC20_Token extends DeployedContract
{
    /** @var string|null */
    private ?string $_name = null;
    /** @var string|null */
    private ?string $_symbol = null;
    /** @var int|null */
    private ?int $_decimals = null;
    /** @var string|null */
    private ?string $_totalSupply = null;

    /**
     * @return string
     * @throws \Kaadon\Ethereum\ERC20\Exception\ERC20TokenException
     * @throws \Kaadon\Ethereum\Exception\EthereumException
     */
    public function name(): string
    {
        if ($this->_name) return $this->_name;
        return $this->constantCall("name", "_name", fn(string $name): string => $this->cleanOutputASCII($name));
    }

    /**
     * @return string
     * @throws \Kaadon\Ethereum\ERC20\Exception\ERC20TokenException
     * @throws \Kaadon\Ethereum\Exception\EthereumException
     */
    public function symbol(): string
    {
        if ($this->_symbol) return $this->_symbol;
        return $this->constantCall("symbol", "_symbol", fn(string $symbol): string => $this->cleanOutputASCII($symbol));
    }

    /**
     * @return int
     * @throws \Kaadon\Ethereum\ERC20\Exception\ERC20TokenException
     * @throws \Kaadon\Ethereum\Exception\EthereumException
     */
    public function decimals(): int
    {
        if ($this->_decimals) return $this->_decimals;
        return $this->constantCall("decimals", "_decimals", fn(string $dec): int => intval($dec));
    }

    /**
     * @return string
     * @throws \Kaadon\Ethereum\ERC20\Exception\ERC20TokenException
     * @throws \Kaadon\Ethereum\Exception\EthereumException
     */
    public function totalSupply(): string
    {
        if ($this->_totalSupply) return $this->_totalSupply;
        return $this->constantCall("totalSupply", "_totalSupply", null);
    }

    /**
     * @param \Kaadon\Ethereum\Buffers\EthereumAddress $address
     * @return string
     * @throws \Kaadon\Ethereum\ERC20\Exception\ERC20TokenException
     * @throws \Kaadon\Ethereum\Exception\EthereumException
     */
    public function balanceOf(EthereumAddress $address): string
    {
        return $this->getScaledValue($this->call("balanceOf", [strval($address)])[0] ?? 0);
    }

    /**
     * @param \Kaadon\Ethereum\Buffers\EthereumAddress $dest
     * @param int|string $amount
     * @return string
     * @throws \Kaadon\Ethereum\Exception\Contract_ABIException
     */
    public function encodeTransferData(EthereumAddress $dest, int|string $amount): string
    {
        return $this->encodeCall("transfer", [strval($dest), strval($amount)]);
    }

    /**
     * @param string $value
     * @return string
     * @throws \Kaadon\Ethereum\ERC20\Exception\ERC20TokenException
     * @throws \Kaadon\Ethereum\Exception\EthereumException
     */
    public function fromScaledValue(string $value): string
    {
        return bcmul($value, bcpow("10", strval($this->decimals()), 0), 0);
    }

    /**
     * @param int|string $value
     * @return string
     * @throws \Kaadon\Ethereum\ERC20\Exception\ERC20TokenException
     * @throws \Kaadon\Ethereum\Exception\EthereumException
     */
    public function getScaledValue(int|string $value): string
    {
        return bcdiv(strval($value), bcpow("10", strval($this->decimals()), 0), $this->decimals());
    }

    /**
     * @param string $func
     * @param string $prop
     * @param callable|null $manipulator
     * @return mixed
     * @throws \Kaadon\Ethereum\ERC20\Exception\ERC20TokenException
     * @throws \Kaadon\Ethereum\Exception\EthereumException
     */
    private function constantCall(string $func, string $prop, ?callable $manipulator): mixed
    {
        if (isset($this->$prop)) {
            return $this->$prop;
        }

        $constant = $this->call($func);
        if (!array_key_exists(0, $constant)) {
            throw new ERC20TokenException('Failed to retrieve ERC20 token ' . $prop);
        }

        $constant = $constant[0];
        if ($manipulator) {
            $constant = $manipulator($constant);
        }

        $this->$prop = $constant;
        return $this->$prop;
    }

    /**
     * @return array
     * @throws \Kaadon\Ethereum\ERC20\Exception\ERC20TokenException
     * @throws \Kaadon\Ethereum\Exception\EthereumException
     */
    public function __debugInfo(): array
    {
        return $this->toArray();
    }

    /**
     * @return void
     */
    public function purgeCached(): void
    {
        $this->_name = null;
        $this->_symbol = null;
        $this->_decimals = null;
        $this->_totalSupply = null;
    }

    /**
     * @return array
     * @throws \Kaadon\Ethereum\ERC20\Exception\ERC20TokenException
     * @throws \Kaadon\Ethereum\Exception\EthereumException
     */
    public function toArray(): array
    {
        return [
            "deployedAt" => $this->deployedAt->toString(true),
            "name" => $this->name(),
            "symbol" => $this->symbol(),
            "decimals" => $this->decimals(),
            "totalSupply" => $this->totalSupply()
        ];
    }
}
