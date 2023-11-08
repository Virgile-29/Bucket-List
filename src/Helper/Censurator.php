<?php

namespace App\Helper;

class Censurator {
    private array $badwords;
    private const PUNTCTUATION = [',', '!', '?', ':', '.'];
    private const PUNTCTUATION_STR = "'!,?:.";
    public function __construct() {
        $badwordList = file_get_contents('../data/badwords.txt');
        $this->badwords = explode( ',', $badwordList,);
    }

    /** Be like Georges
     * @param string $string
     * @return string
     */
    public function _1984(string $string) {
        $splitWords = explode(' ', $string);
        $purifyString = '';

        foreach($splitWords as $word) {
            $purifyWord = $this->deus_vult($word);
            $purifyString .= $purifyWord.' ';
        }
        return $purifyString;
    }

    /** DEUS VUULT
     * @param string $suspectString
     * @return string
     */
    private function deus_vult(string $suspectString): string {
        $suspectStringWithoutExtraChar = trim(strtolower($suspectString), self::PUNTCTUATION_STR);

        if(str_contains($suspectStringWithoutExtraChar, '\'')) {
            $suspectStringWithoutExtraChar = explode("'", $suspectString);
            $suspectStringWithoutExtraChar = $suspectStringWithoutExtraChar[1];
        }

        $censor = in_array($suspectStringWithoutExtraChar, $this->badwords);
        $censoredString = $suspectString;

        if($censor) {
            $censoredString = str_repeat('*', strlen($suspectString));
            $punctuation = $this->getPunctuation($suspectString);
            if(!empty($punctuation)) {
                $censoredString = substr_replace($censoredString, $punctuation["char"], $punctuation["pos"]);

            }
        }
        return $censoredString;
    }

    /**
     * @param string $str
     * @return array
     */
    private function getPunctuation(string $str): array {
        foreach(self::PUNTCTUATION as $specialChar) {
            if(str_contains($str, $specialChar)) {
                return ["char" => $specialChar,"pos" => stripos($str, $specialChar)];
            }
        }
        return [];
    }
}