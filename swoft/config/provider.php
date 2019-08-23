<?php

/*
 * This file is part of Swoft.
 * (c) Swoft <group@swoft.org>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'consul' => [
        'address' => '39.96.196.246',
        'port'    => 8500,
        'register' => [
            'ID'                =>'pay',
            'Name'              =>'pay-php',
            'Tags'              =>['primary'],
            'Address'           =>'39.96.196.246',
            'Port'              =>9503,
            'Check'             => [
                'tcp'      => '39.96.196.246:9503',
                'interval' => '5s',
                'timeout'  => '2s',
            ]
        ],
        'discovery' => [
            'name' => 'user',
            'dc' => 'dc',
            'passing' => true
        ]
    ],
];