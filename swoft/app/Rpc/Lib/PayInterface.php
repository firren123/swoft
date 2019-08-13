<?php declare(strict_types=1);


namespace App\Rpc\Lib;

/**
 * Class UserInterface
 *
 * @since 2.0
 */
interface PayInterface
{
    /**
     * @param int   $id
     * @param mixed $type
     * @param int   $count
     *
     * @return array
     */
    public function pay(): array;

}