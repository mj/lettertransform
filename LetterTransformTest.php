<?php
require_once "PHPUnit/Framework.php";
require "LetterTransform.php";

class LetterTransformTest extends PHPUnit_Framework_TestCase {

    public function testMorse() {
        $result = Text_LetterTransform::toMorse("MORSE CODE");
        self::assertEquals("--   ---   .-.   ...   .       -.-.   ---   -..   .", $result);

        $result = Text_LetterTransform::toMorse("MORSE CODE MORSE CODE");
        self::assertEquals("--   ---   .-.   ...   .       -.-.   ---   -..   .       --   ---   .-.   ...   .       -.-.   ---   -..   .", $result);
    }
}
