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
 * Class CSVManager
 * @package ClaviculaNox\ToolboxBundle\Classes\Services\Tools
 */
class CSVManager
{
    private $FileSystem = null;

    /**
     * CSVManager constructor.
     * @param Filesystem $FileSystem
     */
    public function __construct(Filesystem $FileSystem)
    {
        $this->FileSystem = $FileSystem;
    }

    /**
     * @param string $filePath
     * @param string $delim
     * @return array
     */
    public function get2DArrayFromCsv($filePath, $delim = ';')
    {
        $return = array();

        if (($fileHandler = fopen($filePath, "r")) !== false) {
            $i = 0;

            while (($line = fgetcsv($fileHandler, 4096, $delim)) !== false)
            {
                $count = count($line);
                for ($j = 0; $j < $count; $j++)
                {
                    $return[$i][$j] = $line[$j];
                }
                $i++;
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
    public function writeCsv($fileContent, $filePath = '', $fileName = '')
    {
        if (mb_detect_encoding($fileContent) != 'UTF-8') {
            $fileContent = utf8_encode($fileContent);
        }

        $this->FileSystem->dumpFile($filePath . $fileName, $fileContent);
    }

    /**
     * @param array $csvDatas
     * @param string $filePath
     * @param string $fileName
     * @param string $delim
     * @param string $enclosure
     */
    public function generateCsvToFile($csvDatas, $filePath = '', $fileName = '', $delim = ';', $enclosure = '"')
    {
        $this->writeCsv($this->generateCsv($csvDatas, $delim, $enclosure), $filePath, $fileName);
    }

    /**
     * @param array $csvDatas
     * @param string $delim
     * @param string $enclosure
     * @return string
     */
    public function generateCsv($csvDatas, $delim = ';', $enclosure = '"')
    {
        if (is_null($enclosure))
            $enclosure = chr(0);

        $handle = fopen('php://memory', 'r+');

        foreach ($csvDatas as $data)
        {
            foreach ($data as $key => $value)
            {
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
