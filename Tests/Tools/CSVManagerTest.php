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
 * Class CSVManagerTest.
 */
class CSVManagerTest extends WebTestCase
{
    /* @var array */
    private $datas = [
        ['line1val1', 'line1val2', 'line1val3'],
        ['line2val1', 'line2val2', 'line2val3'],
        ['line3val1', 'line3val2', 'line3val3'],
        ['line4val1', 'line4val2', 'line4val3'],
    ];

    /* @var string */
    private $csv = 'line1val1;line1val2;line1val3
line2val1;line2val2;line2val3
line3val1;line3val2;line3val3
line4val1;line4val2;line4val3
';

    /* @var string */
    private $filePath = 'build/csv/';

    /* @var string */
    private $fileName = 'test.csv';

    /**
     * @return KernelInterface
     */
    private function getKernel($options = []): KernelInterface
    {
        return $this->bootKernel($options);
    }

    public function testFullCycle(): void
    {
        $csv = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.csv_manager')->generateCsv($this->datas);

        $this->assertTrue($this->csv === $csv);

        $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.csv_manager')->writeCSV($this->datas, $this->filePath, $this->fileName);

        $this->assertTrue(true === file_exists($this->filePath.$this->fileName));

        $datas = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.csv_manager')->getCSV($this->filePath.$this->fileName);

        $this->assertTrue($datas === $this->datas);
    }
}
