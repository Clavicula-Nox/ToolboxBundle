<?php

/*
* This file is part of the ToolboxBundle.
*
* (c) Adrien Lochon <adrien@claviculanox.io>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ClaviculaNox\ToolboxBundle\Tests\Tools;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class IntManagerTest.
 */
class IntManagerTest extends WebTestCase
{
    /* @var array */
    public $primes = [2, 3, 5, 7, 11, 13, 17, 19];

    /* @var array */
    public $notPrimes = [4, 6, 8, 10, 12, 14, 16, 18, 20];

    /**
     * @return KernelInterface
     */
    private function getKernel($options = []): KernelInterface
    {
        return $this->bootKernel($options);
    }

    public function testIsPrime(): void
    {
        foreach ($this->primes as $prime) {
            $isPrime = $csv = $this
                ->getKernel()
                ->getContainer()
                ->get('cn_toolbox.tools.int_manager')->isPrime($prime);

            $this->assertTrue(true === $isPrime);
        }

        foreach ($this->notPrimes as $notPrime) {
            $isPrime = $csv = $this
                ->getKernel()
                ->getContainer()
                ->get('cn_toolbox.tools.int_manager')->isPrime($notPrime);

            $this->assertTrue(false === $isPrime);
        }
    }
}
