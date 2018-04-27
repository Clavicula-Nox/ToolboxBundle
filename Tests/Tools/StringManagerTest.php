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
 * Class StringManagerTest.
 */
class StringManagerTest extends WebTestCase
{
    /**
     * @return KernelInterface
     */
    private function getKernel($options = []): KernelInterface
    {
        return $this->bootKernel($options);
    }

    public function testWashString(): void
    {
        $input = ' &nbsp;«»“”…´‘’œ'.
            chr(197).chr(34).
            chr(226).chr(128).chr(147).
            'Œ—•ňŸžýŽŠš›‹€'.
            chr(226).chr(130).chr(172).
            chr(195).chr(169).
            chr(195).chr(34).
            chr(195).chr(170).
            chr(195).chr(168).
            chr(195).chr(32).
            chr(195).chr(162).
            chr(195).chr(69).
            chr(194).chr(34).
            chr(226).chr(69).chr(153).
            chr(226).chr(69).chr(166).
            chr(195).chr(167).' ';

        $output = "\"\"\"\"...'''oeoe-OE—-nYzyZSs><EEéûêèà âà\"'...ç";

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->washString($input);

        $this->assertTrue($output === $test);
    }

    public function testRemoveAccents(): void
    {
        $input = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ';
        $output = 'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn';

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->removeAccents($input);

        $this->assertTrue($output === $test);
    }

    public function testRemoveCharsKeepInts(): void
    {
        $input = '1 : I have 31 apples and the 1st is the best one, but the 9th is good also.';
        $output = '13119';

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->removeCharsKeepInts($input);

        $this->assertTrue($output === $test);
    }

    public function testCleanString(): void
    {
        $input = 'Hello°?,.;/:§!&@%μ';
        $output = 'Hello';

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->cleanString($input);

        $this->assertTrue($output === $test);
    }

    public function testDeleteWordsFromString(): void
    {
        $input = 'Those are my words man';
        $output = 'Those are words';

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->deleteWordsFromString($input, ['my', 'man']);

        $this->assertTrue($output === $test);
    }

    public function testStripLineBreaks(): void
    {
        $input = 'Those are my words man'."\n".'. Simple.';
        $output = 'Those are my words man. Simple.';

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->stripLineBreaks($input);

        $this->assertTrue($output === $test);
    }

    public function testNiceSubStr(): void
    {
        $input = 'Those are my words man. Simple.';
        $output = 'Those are my words...';

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->niceSubStr($input, 20);

        $this->assertTrue($output === $test);
    }

    public function testStringToLabel(): void
    {
        $input = 'Those are my words man. Simple.';
        $output = 'ThoseAreMyWordsManSimple';

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->stringToLabel($input, 20);

        $this->assertTrue($output === $test);
    }

    public function testGenerateRandomString(): void
    {
        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->generateRandomString(200);

        $this->assertTrue(is_string($test));
        $this->assertTrue(200 === strlen($test));
    }

    public function testStartsWith(): void
    {
        $input = 'Those are my words man. Simple.';

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->startsWith($input, 'Those');

        $this->assertTrue($test);

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->startsWith($input, 'are');

        $this->assertFalse($test);
    }

    public function testEndsWith(): void
    {
        $input = 'Those are my words man. Simple.';

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->endsWith($input, 'Simple.');

        $this->assertTrue($test);

        $test = $this
            ->getKernel()
            ->getContainer()
            ->get('cn_toolbox.tools.string_manager')->startsWith($input, 'man.');

        $this->assertFalse($test);
    }
}
