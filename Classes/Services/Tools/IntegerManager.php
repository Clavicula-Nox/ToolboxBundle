<?php

/*
 * This file is part of the ToolboxBundle.
 *
 * (c) Adrien Lochon <adrien@claviculanox.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClaviculaNox\ToolboxBundle\Classes\Services\Tools;

/**
 * Class IntegerManager
 * @package ClaviculaNox\ToolboxBundle\Classes\Services\Tools
 */
class IntegerManager
{
    /**
     * IntegerManager constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param integer $num
     * @return bool
     */
    public function isPrime($num)
    {
        if ($num == 1) {
            return false;
        }

        if ($num == 2) {
            return true;
        }

        if ($num % 2 == 0) {
            return false;
        }

        $max = ceil(sqrt($num));

        for ($i = 3; $i <= $max; $i = $i + 2)
        {
            if ($num % $i == 0) {
                return false;
            }
        }

        return true;
    }
}
