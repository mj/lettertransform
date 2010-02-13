<?php

class Text_LetterTransform {

    private static $NATO = array(
        "A" => "Alpha",
        "B" => "Bravo",
        "C" => "Charlie",
        "D" => "Delta",
        "E" => "Echo",
        "F" => "Foxtrot",
        "G" => "Golf",
        "H" => "Hotel",
        "I" => "India",
        "J" => "Juliett",
        "K" => "Kilo",
        "L" => "Lima",
        "M" => "Mike",
        "N" => "November",
        "O" => "Oscar",
        "P" => "Papa",
        "Q" => "Quebec",
        "R" => "Romeo",
        "S" => "Sierra",
        "T" => "Tango",
        "U" => "Uniform",
        "V" => "Victor",
        "W" => "Whiskey",
        "X" => "X-ray",
        "Y" => "Yankee",
        "Z" => "Zulu",
        0 => "Zero",
        1 => "One",
        2 => "Two",
        3 => "Three",
        4 => "Four",
        5 => "Five",
        6 => "Six",
        7 => "Seven",
        8 => "Eight",
        9 => "Nine");

    const MORSE_SHORT_GAP = "   ";
    const MORSE_MEDIUM_GAP = " ";

    private static $MORSE = array(
        "A" => ".-",
        "B" => "-...",
        "C" => "-.-.",
        "D" => "-..",
        "E" => ".",
        "F" => "..-.",
        "G" => "--.",
        "H" => "....",
        "I" => "..",
        "J" => ".---",
        "K" => "-.-",
        "L" => ".-..",
        "M" => "--",
        "N" => "-.",
        "O" => "---",
        "P" => ".--.",
        "Q" => "--.-",
        "R" => ".-.",
        "S" => "...",
        "T" => "-",
        "U" => "..-",
        "V" => "...-",
        "W" => ".--",
        "X" => "-..-",
        "Y" => "-.--",
        "Z" => "--..",

        /* Non-english extensions */
        "ä" => ".-.-",
        "æ" => ".-.-",
        "à" => ".--.-",
        "å" => ".--.-",
        "ç" => "-.-..",
        "ĉ" => "-.-..",
        "š" => "----",
        "ð" => "..--.",
        "è" => ".-..-",
        "é" => "..-..",
        "đ" => "..-..",
        "ĝ" => "--.-.",
        "ĥ" => "----",
        "ĵ" => ".---.",
        "ñ" => "--.--",
        "ö" => "---.",
        "ø" => "---.",
        "ŝ" => "...-.",
        "þ" => ".--..",
        "ü" => "..--",
        "ŭ" => "..--",
        
        "?" => "..--..",
        "=" => "-...-",
        "," => "--..--",
        ";" => "-.-.-.",
        "-" => "-....-",
        "'" => ".----.",
        "+" => ".-.-.",
        "/" => "-..-.",
        "_" => "..--.-",
        "!" => "-.-.--",
        "\$" => "...-..-",
        "." => ".-.-.-",
        ":" => "---...",
        "(" => "-.--.",
        ")" => "-.--.-",
        "\"" => ".-..-.",
        
        "0" => "-----",
        "1" => ".----",
        "2" => "..---",
        "3" => "...--",
        "4" => "....-",
        "5" => ".....",
        "6" => "-....",
        "7" => "--...",
        "8" => "---..",
        "9" => "----.",
        "&" => ".-...",
        "@" => ".--.-."
        );

    /**
     * Returns the representation of the letter in the NATO phonetic alphabet
     *
     * If the letter is not supported by the NATO phonetic alphabet, the letter
     * itself is returned.  For convenience it is also possible to pass whole
     * words to this method.  In this case, every single is transformed to its
     * representation in the NATO phonetic alphabet.
     *
     * @param string Letter or whole word/sentence
     * @return string Representation of the letter in the NATO phonetic alphabet
     */
    public static function toNATO($letter) {
        if (strlen($letter) > 1) {
            $string = new StringIterator($letter);

            $result = array();
            foreach ($string as $letter) {
                $result[] = self::toNATO($letter);
            }

            return join(" ", $result);
        }

        $letter = strtoupper($letter);

        if (!isset(self::$NATO[$letter])) {
            return $letter;
        }

        return self::$NATO[$letter];
    }

    /**
     * Returns the representation of the letter in the Morse code alphabet
     *
     * @param string Letter or whole word/sentence
     * @return string Representation of the input in the Morse code alphabet
     */
    public static function toMorse($letter, &$warnings = array()) {
        if (strlen($letter) > 1) {
            $string = $letter;

            $result = array();
            for ($i = 0; $i < strlen($string); $i++) {
                $letter = $string{$i};
                if ($letter == " ") {
                    $result[] = self::MORSE_MEDIUM_GAP;
                } else {
                    $result[] = self::toMorse($letter, $warnings);
                }
            }
            
            return join(self::MORSE_SHORT_GAP, $result);
        }

        if (isset(self::$MORSE[$letter])) {
            return self::$MORSE[$letter];
        }
        
        if (isset(self::$MORSE[strtoupper($letter)])) {
            return self::$MORSE[strtoupper($letter)];
        }
        
        $warnings[] = "No morse representation found for " . $letter;
    }
}
