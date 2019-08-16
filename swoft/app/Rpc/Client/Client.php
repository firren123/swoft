<?php
/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/8/13
 * Time: 下午5:02
 */

namespace App\Rpc\Client;

use Swoft\Rpc\Client\Contract\ProviderInterface;

class Client extends \Swoft\Rpc\Client\Client
{
    /**
     * @return ProviderInterface
     */
    public function getProvider(): ?ProviderInterface
    {
        return $this->provider = new Provider();
    }
}