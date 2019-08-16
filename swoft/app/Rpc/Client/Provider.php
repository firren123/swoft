<?php
/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/8/13
 * Time: 下午5:03
 */

namespace App\Rpc\Client;


use Swoft\Rpc\Client\Client;
use Swoft\Rpc\Client\Contract\ProviderInterface;

class Provider implements  ProviderInterface
{
    public function getList(Client $client):array
    {
        //
        return [
            '127.0.0.1:9508',
            '127.0.0.1:9505'
        ];
    }


}