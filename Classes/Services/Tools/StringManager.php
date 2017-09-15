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
 * Class StringManager
 * @package ClaviculaNox\ToolboxBundle\Classes\Services\Tools
 */
class StringManager
{
    private static $charsList =
        [
            'a','b','c','d','e','f','g','h','i',
            'j','k','l','m','n','o','p','q','r',
            's','t','u','v','w','x','y','z','0',
            '1','2','3','4','5','6','7','8','9'
        ];

    /**
     * @param string $string
     * @return string
     */
    public function washString($string)
    {
        $string = str_replace("&nbsp;", " ", $string);
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        $string = trim($string);
        $string = str_replace("«", "\"", $string);
        $string = str_replace("»", '"', $string);
        $string = str_replace("“", "\"", $string);
        $string = str_replace("”", "\"", $string);
        $string = str_replace("…", "...", $string);
        $string = str_replace("´", "'", $string);
        $string = str_replace("‘", "'", $string);
        $string = str_replace("’", "'", $string);
        $string = str_replace("œ", "oe", $string);
        $string = str_replace(chr(197) . chr(34), "oe", $string);
        $string = str_replace(chr(226) . chr(128) . chr(147), "-", $string);
        $string = str_replace("Œ", "OE", $string);
        $string = str_replace("—", "-", $string);
        $string = str_replace("–", "-", $string);
        $string = str_replace("–", "-", $string);
        $string = str_replace("•", "-", $string);
        $string = str_replace("ň", "n", $string);
        $string = str_replace("Ÿ", "Y", $string);
        $string = str_replace("ž", "z", $string);
        $string = str_replace("ý", "y", $string);
        $string = str_replace("Ž", "Z", $string);
        $string = str_replace("Š", "S", $string);
        $string = str_replace("š", "s", $string);
        $string = str_replace("›", ">", $string);
        $string = str_replace("‹", "<", $string);
        $string = str_replace("€", "E", $string);
        $string = str_replace(chr(226) . chr(130) . chr(172), '€', $string); //just in case the € is with a bad encoding
        $string = str_replace(chr(195) . chr(169), "é", $string);
        $string = str_replace(chr(195) . chr(34), "û", $string);
        $string = str_replace(chr(195) . chr(170), "ê", $string);
        $string = str_replace(chr(195) . chr(168), "è", $string);
        $string = str_replace(chr(195) . chr(32), "à" . chr(32), $string);
        $string = str_replace(chr(195) . chr(162), "â", $string);
        $string = str_replace(chr(195) . chr(69), "à", $string);
        $string = str_replace(chr(194) . chr(34), '"', $string);
        $string = str_replace(chr(226) . chr(69) . chr(153), "'", $string);
        $string = str_replace(chr(226) . chr(69) . chr(166), "...", $string);
        $string = str_replace(chr(195) . chr(167), "ç", $string);

        $string = trim($string);

        return (string) $string;
    }

    /**
     * @param string $string
     * @param string $allowedTags
     * @param string $allowedAttributes
     * @return string
     */
    public function stripTagsAttributes($string, $allowedTags = "", $allowedAttributes = "") {
        $string = strip_tags($string, $allowedTags);
        if (!is_null($allowedAttributes)) {
            if (!is_array($allowedAttributes)) {
                $allowedAttributes = explode(",", $allowedAttributes);
            }
            if (is_array($allowedAttributes)) {
                $allowedAttributes = implode(")(?<!", $allowedAttributes);
            }
            if (strlen($allowedAttributes) > 0) {
                $allowedAttributes = "(?<!" . $allowedAttributes . ")";
            }

            $string = preg_replace_callback("/<[^>]*>/i", create_function('$matches', 'return preg_replace("/ [^ =]*' . $allowedAttributes . '=(\"[^\"]*\"|\'[^\']*\')/i", "", $matches[0]);'), $string);
        }

        return (string) $string;
    }

    /**
     * @param string $string
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
     * @return string
     */
    public function stripStringKeepInts($string)
    {
        $string = self::cleanString($string);
        $string = str_replace(
            array(
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'
            ),
            '',
            $string
        );
        $string = trim($string);

        return (string) $string;
    }

    /**
     * @param string $string
     * @param bool $keepTags
     * @param array $allowedTags
     * @return string
     */
    public function cleanString($string, $keepTags = true, $allowedTags = array())
    {
        $string = stringManager::washString($string);
        $string = strtoupper($string);
        $toReplace = array(",", ";", ".", ":", "°", "-", "_", "'", '"', "&", " ", "/", "\\", "@", "$", "%", "£", "¤", "µ", "*", "!", "§");
        $string = str_replace($toReplace, " ", $string);

        $string = stringManager::removeAccents($string);
        $string = strtolower($string);
        if (!$keepTags && is_array($allowedTags)) {
            $string = strip_tags($string, $allowedTags);
            $string = trim($string);
        }

        return (string) $string;
    }

    /**
     * @param string $string
     * @param array $wordsList
     * @return string
     */
    public function deleteWordsFromString($string, $wordsList)
    {
        $string = ' ' . $string . ' ';
        foreach ($wordsList as $value)
        {
            $string = preg_replace("/([[:space:][:punct:]]+)" . mb_strtolower($value) . "([[:space:][:punct:]]+)/i", '\1\2', $string);
        }

        $string = trim($string);

        return (string) $string;
    }

    /**
     * @param string $string
     * @return string
     */
    public function stripLineBreaks($string)
    {
        $string = str_replace("\r", '', $string);
        $string = str_replace("\n", '', $string);
        $string = str_replace("\t", '', $string);

        return (string) $string;
    }

    /**
     * Does not return a string
     * @param string $string
     */
    public function getBinaryFromString($string)
    {
        $length = strlen($string);
        $return = '';

        for ($i = 0; $i < $length; $i++) {
            $return .= str_pad(decbin(ord($string[$i])), 8, '0', STR_PAD_LEFT);
        }

        echo $return;
    }

    /**
     * @param string $string
     * @param integer $length
     * @return string
     */
    public function cleanSubStr($string, $length = 200)
    {
        if (strlen($string) > $length) {
            $tmp = substr($string, 0, $length);
            $lastPos = strrpos($tmp, ' ');
            if ($lastPos) {
                $return = substr($string, 0, $lastPos) . "...";
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
     * @return string
     */
    public function stringToLabel($string)
    {
        $string = stringManager::washString($string);
        $toReplace = array(",", ";", ".", ":", "°", "-", "_", "'", '"', "&", " ", "/", "\\", "@", "$", "%", "£", "¤", "µ", "*", "!", "§");
        $string = str_replace($toReplace, " ", $string);
        $string = stringManager::removeAccents($string);
        $stringArray = explode(' ', $string);
        foreach ($stringArray as $key => $value)
        {
            $stringArray[$key] = ucfirst(strtolower($value));
        }

        $string = implode(' ', $stringArray);
        $string = str_replace(" ", "", $string);

        return (string) $string;
    }

    /**
     * @param integer $length
     * @return string
     */
    public function generateRandomString($length)
    {
        $return = "";
        $charsListLength = count(self::$charsList) - 1;

        for ($i = 0; $i < $length; $i++) {
            $return .= self::$charsList[mt_rand(0, $charsListLength)];
        }

        return $return;

    }
}
