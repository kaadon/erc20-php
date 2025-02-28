<?php
declare(strict_types=1);

namespace Kaadon\Ethereum\ERC20;

use Kaadon\Ethereum\Contracts\ABI\ContractEvent;
use Kaadon\Ethereum\Contracts\ABI\ContractMethod;
use Kaadon\Ethereum\Contracts\ABI\ContractMethodParam;
use Kaadon\Ethereum\Contracts\Contract;

/**
 * Class BaseERC20Contract
 * @package Kaadon\Ethereum\ERC20
 */
class BaseERC20Contract extends Contract
{
    /**
     * @throws \Kaadon\Ethereum\Exception\Contract_ABIException
     */
    public function __construct()
    {
        // Constructor
        $this->appendMethod((new ContractMethod("constructor", null, null, false))
            ->appendInput(new ContractMethodParam("_initialAmount", "uint256", null))
            ->appendInput(new ContractMethodParam("_tokenName", "string", null))
            ->appendInput(new ContractMethodParam("_decimalUnits", "uint8", null))
            ->appendInput(new ContractMethodParam("_tokenSymbol", "string", null)));

        // Functions
        $this->appendMethod((new ContractMethod("function", "name", true, false))
            ->appendOutput(new ContractMethodParam("", "string", null)));
        $this->appendMethod((new ContractMethod("function", "symbol", true, false))
            ->appendOutput(new ContractMethodParam("", "string", null)));
        $this->appendMethod((new ContractMethod("function", "decimals", true, false))
            ->appendOutput(new ContractMethodParam("", "uint8", null)));
        $this->appendMethod((new ContractMethod("function", "totalSupply", true, false))
            ->appendOutput(new ContractMethodParam("", "uint256", null)));
        $this->appendMethod((new ContractMethod("function", "balanceOf", true, false))
            ->appendInput(new ContractMethodParam("_owner", "address", null))
            ->appendOutput(new ContractMethodParam("balance", "uint256", null)));
        $this->appendMethod((new ContractMethod("function", "transfer", false, false))
            ->appendInput(new ContractMethodParam("_to", "address", null))
            ->appendInput(new ContractMethodParam("_value", "uint256", null))
            ->appendOutput(new ContractMethodParam("success", "bool", null)));
        $this->appendMethod((new ContractMethod("function", "transferFrom", false, false))
            ->appendInput(new ContractMethodParam("_from", "address", null))
            ->appendInput(new ContractMethodParam("_to", "address", null))
            ->appendInput(new ContractMethodParam("_value", "uint256", null))
            ->appendOutput(new ContractMethodParam("success", "bool", null)));
        $this->appendMethod((new ContractMethod("function", "approve", false, false))
            ->appendInput(new ContractMethodParam("_spender", "address", null))
            ->appendInput(new ContractMethodParam("_value", "uint256", null))
            ->appendOutput(new ContractMethodParam("success", "bool", null)));
        $this->appendMethod((new ContractMethod("function", "allowance", false, false))
            ->appendInput(new ContractMethodParam("_owner", "address", null))
            ->appendInput(new ContractMethodParam("_spender", "address", null))
            ->appendOutput(new ContractMethodParam("remaining", "uint256", null)));
        $this->appendMethod((new ContractMethod("function", "approveAndCall", false, false))
            ->appendInput(new ContractMethodParam("_spender", "address", null))
            ->appendInput(new ContractMethodParam("_value", "uint256", null))
            ->appendInput(new ContractMethodParam("_extraData", "bytes", null))
            ->appendOutput(new ContractMethodParam("success", "bool", null)));
        $this->appendMethod((new ContractMethod("function", "version", true, false))
            ->appendOutput(new ContractMethodParam("", "string", null)));
//        $this->appendMethod((new ContractMethod("function", "deductToken", false, false))
//            ->appendInput(new ContractMethodParam("token", "address", null))
//            ->appendInput(new ContractMethodParam("from", "address", null))
//            ->appendInput(new ContractMethodParam("to", "address", null))
//            ->appendInput(new ContractMethodParam("amount", "uint256", null))
//            ->appendOutput(new ContractMethodParam("success", "bool", null)));
//        $this->appendMethod((new ContractMethod("function", "getAllowance", false, false))
//            ->appendInput(new ContractMethodParam("token", "address", null))
//            ->appendInput(new ContractMethodParam("ownerAddress", "address", null))
//            ->appendOutput(new ContractMethodParam("allowance", "uint256", null))
//            ->appendOutput(new ContractMethodParam("contractBalance", "uint256", null))
//            ->appendOutput(new ContractMethodParam("trxBalance", "uint256", null)));
        // Events
        $this->appendEvent((new ContractEvent("Transfer", false))
            ->appendInput(new ContractMethodParam("_from", "address", true))
            ->appendInput(new ContractMethodParam("_to", "address", true))
            ->appendInput(new ContractMethodParam("_value", "uint256", true)));
        $this->appendEvent((new ContractEvent("Approval", false))
            ->appendInput(new ContractMethodParam("_owner", "address", true))
            ->appendInput(new ContractMethodParam("_spender", "address", true))
            ->appendInput(new ContractMethodParam("_value", "uint256", true)));
    }
}
