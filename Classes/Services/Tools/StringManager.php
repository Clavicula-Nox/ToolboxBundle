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
 * Class StringManager.
 */
class StringManager
{
    private static $charsList =
        [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i',
            'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r',
            's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0',
            '1', '2', '3', '4', '5', '6', '7', '8', '9',
        ];

    /**
     * @param string $string
     *
     * @return string
     */
    public function washString(string $string): string
    {
        $string = str_replace('&nbsp;', ' ', $string);
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        $string = trim($string);
        $string = str_replace('«', '"', $string);
        $string = str_replace('»', '"', $string);
        $string = str_replace('“', '"', $string);
        $string = str_replace('”', '"', $string);
        $string = str_replace('…', '...', $string);
        $string = str_replace('´', "'", $string);
        $string = str_replace('‘', "'", $string);
        $string = str_replace('’', "'", $string);
        $string = str_replace('œ', 'oe', $string);
        $string = str_replace(chr(197).chr(34), 'oe', $string);
        $string = str_replace(chr(226).chr(128).chr(147), '-', $string);
        $string = str_replace('Œ', 'OE', $string);
        $string = str_replace('–', '-', $string);
        $string = str_replace('•', '-', $string);
        $string = str_replace('ň', 'n', $string);
        $string = str_replace('Ÿ', 'Y', $string);
        $string = str_replace('ž', 'z', $string);
        $string = str_replace('ý', 'y', $string);
        $string = str_replace('Ž', 'Z', $string);
        $string = str_replace('Š', 'S', $string);
        $string = str_replace('š', 's', $string);
        $string = str_replace('›', '>', $string);
        $string = str_replace('‹', '<', $string);
        $string = str_replace('€', 'E', $string);
        $string = str_replace(chr(226).chr(130).chr(172), '€', $string);
        $string = str_replace(chr(195).chr(169), 'é', $string);
        $string = str_replace(chr(195).chr(34), 'û', $string);
        $string = str_replace(chr(195).chr(170), 'ê', $string);
        $string = str_replace(chr(195).chr(168), 'è', $string);
        $string = str_replace(chr(195).chr(32), 'à'.chr(32), $string);
        $string = str_replace(chr(195).chr(162), 'â', $string);
        $string = str_replace(chr(195).chr(69), 'à', $string);
        $string = str_replace(chr(194).chr(34), '"', $string);
        $string = str_replace(chr(226).chr(69).chr(153), "'", $string);
        $string = str_replace(chr(226).chr(69).chr(166), '...', $string);
        $string = str_replace(chr(195).chr(167), 'ç', $string);

        $string = trim($string);

        return (string) $string;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function removeAccents($string)
    {
        $string = str_replace(
            array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'à', 'á', 'â', 'ã', 'ä', 'å', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'È', 'É', 'Ê', 'Ë', 'è', 'é', 'ê', 'ë', 'Ç', 'ç', 'Ì', 'Í', 'Î', 'Ï', 'ì', 'í', 'î', 'ï', 'Ù', 'Ú', 'Û', 'Ü', 'ù', 'ú', 'û', 'ü', 'ÿ', 'Ñ', 'ñ'),
            array('A', 'A', 'A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a', 'a', 'O', 'O', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'o', 'o', 'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e', 'C', 'c', 'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i', 'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u', 'y', 'N', 'n'),
            $string
        );

        return (string) $string;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function removeCharsKeepInts($string)
    {
        $string = self::cleanString($string);
        $string = strtolower($string);
        $string = str_replace(
            [
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
                'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            ],
            '',
            $string
        );

        $string = str_replace(' ', '', $string);

        return (string) $string;
    }

    /**
     * @param string $string
     * @param bool   $keepTags
     * @param array  $allowedTags
     *
     * @return string
     */
    public function cleanString($string)
    {
        $string = self::washString($string);
        $string = self::removeAccents($string);
        $string = str_replace(
            [
                ',', ';', '.', ':', '°', '-', '_', "'", '"', '&', ' ', '/', '\\', '@', '$', '%', '£', '¤', 'µ', '*', '!',
                '§', 'μ', '(', ')', '{', '}', '[', ']', '^', '¨', '?', '§',
            ],
            '',
            $string
        );
        $string = trim($string);

        return (string) $string;
    }

    /**
     * @param string $string
     * @param array  $wordsList
     *
     * @return string
     */
    public function deleteWordsFromString(string $string, array $wordsList): string
    {
        $string = ' '.$string.' ';
        foreach ($wordsList as $value) {
            $string = preg_replace('/([[:space:][:punct:]]+)'.mb_strtolower($value).'([[:space:][:punct:]]+)/i', '\1\2', $string);
            $string = str_replace('  ', ' ', $string);
        }

        $string = trim($string);

        return (string) $string;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function stripLineBreaks(string $string): string
    {
        $string = str_replace("\r", '', $string);
        $string = str_replace("\n", '', $string);
        $string = str_replace("\t", '', $string);

        return (string) $string;
    }

    /**
     * @param string $string
     * @param int    $length
     *
     * @return string
     */
    public function niceSubStr(string $string, int $length = 200): string
    {
        if (strlen($string) > $length) {
            $tmp = substr($string, 0, $length);
            $lastPos = strrpos($tmp, ' ');
            if ($lastPos) {
                $return = substr($string, 0, $lastPos).'...';
            } else {
                $return = $string;
            }

            return trim($return);
        } else {
            return $string;
        }
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function stringToLabel(string $string): string
    {
        $string = self::washString($string);
        $toReplace = [',', ';', '.', ':', '°', '-', '_', "'", '"', '&', ' ', '/', '\\', '@', '$', '%', '£', '¤', 'µ', '*', '!', '§'];
        $string = str_replace($toReplace, ' ', $string);
        $string = self::removeAccents($string);
        $stringArray = explode(' ', $string);
        foreach ($stringArray as $key => $value) {
            $stringArray[$key] = ucfirst(strtolower($value));
        }

        $string = implode(' ', $stringArray);
        $string = str_replace(' ', '', $string);

        return (string) $string;
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public function generateRandomString(int $length): string
    {
        $return = '';
        $charsListLength = count(self::$charsList) - 1;

        for ($i = 0; $i < $length; ++$i) {
            $return .= self::$charsList[mt_rand(0, $charsListLength)];
        }

        return $return;
    }
}
