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

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class CSVManager.
 */
class CSVManager
{
    /* @var Filesystem */
    private $FileSystem = null;

    /**
     * CSVManager constructor.
     *
     * @param Filesystem $FileSystem
     */
    public function __construct(Filesystem $FileSystem)
    {
        $this->FileSystem = $FileSystem;
    }

    /**
     * @param string $filePath
     * @param string $delim
     *
     * @return array
     */
    public function getCSV(string $filePath, string $delim = ';'): array
    {
        $return = [];

        if (false !== ($fileHandler = fopen($filePath, 'r'))) {
            $i = 0;

            while (false !== ($line = fgetcsv($fileHandler, 4096, $delim))) {
                $count = count($line);
                for ($j = 0; $j < $count; ++$j) {
                    if (!mb_detect_encoding($line[$j], 'UTF-8')) {
                        $line[$j] = utf8_encode($line[$j]);
                    }
                    $return[$i][$j] = $line[$j];
                }
                ++$i;
            }

            fclose($fileHandler);
        }

        return $return;
    }

    /**
     * @param string $fileContent
     * @param string $filePath
     * @param string $fileName
     */
    private function writeFile(string $fileContent, string $filePath = '', string $fileName = ''): void
    {
        if ('UTF-8' != mb_detect_encoding($fileContent)) {
            $fileContent = utf8_encode($fileContent);
        }

        $this->FileSystem->dumpFile($filePath.$fileName, $fileContent);
    }

    /**
     * @param array  $csvDatas
     * @param string $filePath
     * @param string $fileName
     * @param string $delim
     * @param string $enclosure
     */
    public function writeCSV(
        array $csvDatas,
        string $filePath = '',
        string $fileName = '',
        string $delim = ';',
        string $enclosure = '"'): void
    {
        $this->writeFile($this->generateCSV($csvDatas, $delim, $enclosure), $filePath, $fileName);
    }

    /**
     * @param array  $datas
     * @param string $delim
     * @param string $enclosure
     *
     * @return string
     */
    public function generateCSV(array $datas, string $delim = ';', string $enclosure = '"'): string
    {
        if (is_null($enclosure)) {
            $enclosure = chr(0);
        }

        $handle = fopen('php://memory', 'r+');

        foreach ($datas as $data) {
            foreach ($data as $key => $value) {
                if (mb_detect_encoding($value, 'UTF-8')) {
                    $data[$key] = utf8_decode($value);
                }
            }

            fputcsv($handle, $data, $delim, $enclosure);
        }

        rewind($handle);
        $fileContent = stream_get_contents($handle);
        fclose($handle);

        return $fileContent;
    }
}
