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
    /* @var array */
    private static $charsList =
        [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i',
            'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r',
            's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0',
            '1', '2', '3', '4', '5', '6', '7', '8', '9',
        ];

    /**
     * @param string $input
     *
     * @return string
     */
    public function washString(string $input): string
    {
        $output = str_replace('&nbsp;', ' ', $input);
        $output = str_replace('«', '"', $output);
        $output = str_replace('»', '"', $output);
        $output = str_replace('“', '"', $output);
        $output = str_replace('”', '"', $output);
        $output = str_replace('…', '...', $output);
        $output = str_replace('´', "'", $output);
        $output = str_replace('‘', "'", $output);
        $output = str_replace('’', "'", $output);
        $output = str_replace('œ', 'oe', $output);
        $output = str_replace(chr(197).chr(34), 'oe', $output);
        $output = str_replace(chr(226).chr(128).chr(147), '-', $output);
        $output = str_replace('Œ', 'OE', $output);
        $output = str_replace('–', '-', $output);
        $output = str_replace('•', '-', $output);
        $output = str_replace('ň', 'n', $output);
        $output = str_replace('Ÿ', 'Y', $output);
        $output = str_replace('ž', 'z', $output);
        $output = str_replace('ý', 'y', $output);
        $output = str_replace('Ž', 'Z', $output);
        $output = str_replace('Š', 'S', $output);
        $output = str_replace('š', 's', $output);
        $output = str_replace('›', '>', $output);
        $output = str_replace('‹', '<', $output);
        $output = str_replace('€', 'E', $output);
        $output = str_replace(chr(226).chr(130).chr(172), '€', $output);
        $output = str_replace(chr(195).chr(169), 'é', $output);
        $output = str_replace(chr(195).chr(34), 'û', $output);
        $output = str_replace(chr(195).chr(170), 'ê', $output);
        $output = str_replace(chr(195).chr(168), 'è', $output);
        $output = str_replace(chr(195).chr(32), 'à'.chr(32), $output);
        $output = str_replace(chr(195).chr(162), 'â', $output);
        $output = str_replace(chr(195).chr(69), 'à', $output);
        $output = str_replace(chr(194).chr(34), '"', $output);
        $output = str_replace(chr(226).chr(69).chr(153), "'", $output);
        $output = str_replace(chr(226).chr(69).chr(166), '...', $output);
        $output = str_replace(chr(195).chr(167), 'ç', $output);

        $output = trim($output);

        return (string) $output;
    }

    /**
     * @param string $input
     *
     * @return string
     */
    public function removeAccents(string $input): string
    {
        $output = str_replace(
            ['À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'à', 'á', 'â', 'ã', 'ä', 'å', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'È', 'É', 'Ê', 'Ë', 'è', 'é', 'ê', 'ë', 'Ç', 'ç', 'Ì', 'Í', 'Î', 'Ï', 'ì', 'í', 'î', 'ï', 'Ù', 'Ú', 'Û', 'Ü', 'ù', 'ú', 'û', 'ü', 'ÿ', 'Ñ', 'ñ'],
            ['A', 'A', 'A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a', 'a', 'O', 'O', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'o', 'o', 'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e', 'C', 'c', 'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i', 'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u', 'y', 'N', 'n'],
            $input
        );

        return (string) $output;
    }

    /**
     * @param string $input
     *
     * @return string
     */
    public function removeLetters(string $input): string
    {
        $output = self::cleanString($input);
        $output = strtolower($output);
        $output = str_replace(
            [
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
                'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            ],
            '',
            $output
        );

        $output = str_replace(' ', '', $output);

        return (string) $output;
    }

    /**
     * @param string $input
     *
     * @return string
     */
    public function cleanString(string $input): string
    {
        $output = self::washString($input);
        $output = self::removeAccents($output);
        $output = str_replace(
            [
                ',', ';', '.', ':', '°', '-', '_', "'", '"', '&', ' ', '/', '\\', '@', '$', '%', '£', '¤', 'µ', '*', '!',
                '§', 'μ', '(', ')', '{', '}', '[', ']', '^', '¨', '?', '§',
            ],
            '',
            $output
        );
        $output = trim($output);

        return (string) $output;
    }

    /**
     * @param string $input
     * @param array  $wordsList
     *
     * @return string
     */
    public function deleteWordsFromString(string $input, array $wordsList): string
    {
        $output = ' '.$input.' ';
        foreach ($wordsList as $value) {
            $output = preg_replace('/([[:space:][:punct:]]+)'.mb_strtolower($value).'([[:space:][:punct:]]+)/i', '\1\2', $output);
            $output = str_replace('  ', ' ', $output);
        }

        $output = trim($output);

        return (string) $output;
    }

    /**
     * @param string $input
     *
     * @return string
     */
    public function stripLineBreaks(string $input): string
    {
        $output = str_replace("\r", '', $input);
        $output = str_replace("\n", '', $output);
        $output = str_replace("\t", '', $output);

        return (string) $output;
    }

    /**
     * @param string $input
     * @param int    $length
     *
     * @return string
     */
    public function niceSubStr(string $input, int $length = 200): string
    {
        if (strlen($input) > $length) {
            $tmp = mb_substr($input, 0, $length);
            $lastPos = mb_strrpos($tmp, ' ');
            if ($lastPos) {
                $output = mb_substr($input, 0, $lastPos).'...';
            } else {
                $output = $input;
            }

            return trim($output);
        } else {
            return $input;
        }
    }

    /**
     * @param string $input
     *
     * @return string
     */
    public function stringToLabel(string $input): string
    {
        $output = self::washString($input);
        $output = self::removeAccents($output);
        $outputArray = explode(' ', $output);

        foreach ($outputArray as $key => $value) {
            $outputArray[$key] = ucfirst(mb_strtolower($value));
        }

        $output = implode(' ', $outputArray);
        $output = self::cleanString($output);
        $output = str_replace(' ', '', $output);

        return (string) $output;
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

    /**
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public function startsWith(string $haystack, string $needle): bool
    {
        return '' != $needle && 0 === mb_strpos($haystack, $needle);
    }

    /**
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public function endsWith(string $haystack, string $needle): bool
    {
        return $needle === mb_substr($haystack, -strlen($needle));
    }

    /**
     * @param string $input
     *
     * @return string
     */
    public function removeExtraSpaces(string $input): string
    {
        $output = trim($input);

        return (string) preg_replace("/\s+/", ' ', $output);
    }
}
