<?php

namespace App\Http\Traits;

use Web3\Web3;
use Web3\Contract;
use Illuminate\Support\Facades\Log;

trait Web3Trait
{
    public function callContract($contractAddress, $functionName, $params)
    {
        $abi = file_get_contents("../resources/js/Contracts/wNat.json");
        $abi = json_decode($abi);
        // $web3 = new Web3();

        $contract = new Contract(env('HTTP_RPC_URL'), $abi);
        $contract->at($contractAddress)->call($functionName, $params, function ($err, $data) {
            Log::debug($data[0]->toString());
            Log::debug($data[0]->toString() / (10 ** 18));
            return $data[0]->toString() / (10 ** 18);
        });


        // return $abi;
    }
    public function getVotingPowerBatch($addresses)
    {
        $abi = file_get_contents("../resources/js/Contracts/wNat.json");
        $abi = json_decode($abi);
        $web3 = new Web3('http://localhost:8545');
        $eth = $web3->eth;

        $blocknumber = 0;
        $eth->blockNumber(fn ($data) => $blocknumber = $data);

        Log::debug('BLOCK NUMBER:' . $blocknumber);

        $contract = new Contract(env('HTTP_RPC_URL'), $abi);
        $contract->at('0x02f0826ef6aD107Cfc861152B32B52fD11BaB9ED')->call('batchVotePowerOfAt', $addresses, 28705, function ($err, $data) {
            Log::debug($data);
            return $data;
        });


        // return $abi;
    }
    public function getVotingPower($address)
    {
        $contractAddress = "0x02f0826ef6aD107Cfc861152B32B52fD11BaB9ED"; //Songbird
        $abi = file_get_contents("../resources/js/Contracts/wNat.json");
        $abi = json_decode($abi);
        // $web3 = new Web3();

        $result = $this->callContract($contractAddress, 'votePowerOf', $address);
        return $result;
    }
}