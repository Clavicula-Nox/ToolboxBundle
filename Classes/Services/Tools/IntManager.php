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
 * Class IntManager
 */
class IntManager
{
    /**
     * @param int $num
     * @return bool
     */
    public function isPrime(int $num): bool
    {
        if ($num == 2) {
            return true;
        }

        if ($num == 1 || $num % 2 == 0) {
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
