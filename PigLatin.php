<?php

namespace p2;

class PigLatin {

    private $text;
    private $suffix;
    private $shortWordsUntouched;
    private $vowels = 'aeiou';
    private $nonAlphanumericRegex = '/\.|\?|\!|\,|\;$/';

    public function __construct($text, $suffix = 'ay', $shortWordsUntouched = false) {
        $this->text = $text;
        $this->suffix = $suffix;
        $this->shortWordsUntouched = $shortWordsUntouched;
    }
    // words that begin with a single consonant shift the first letter to 
    // the end and append suffix (e.g., hello => ellohay)

    // words that begin with two consecutive consonants shift the cluster
    // to the end and append suffix (e.g., cheers => errschay)

    // words that begin with a vowel add way to then end 
    // e.g., eat => eatway

    // OPTIONAL: words that are shorter than 3 characters are left as is
    // e.g., an => an
    
    public function translate() {
        $words = explode(' ', $this->text);
        
        $translated = array_map(function($word) {
            if ($this->shortWordsUntouched && strlen($word) < 3) {
                return $word;
            }
            else if ($this->startsWithTwoConsonants($word)) {
                return $this->format($word, 2, false);
            }
            else if ($this->startsWithOneConsonant($word)) {
                return $this->format($word, 1, false);
            }
            else if ($this->startsWithVowel($word)) {
                return $this->format($word, strlen($word), true);
            }
            return $word;
        }, $words);
        
        $translatedText = join(' ', $translated);
        // return $translatedText;
        return $this->postFormat($translatedText);
    }

    private function format($word, $chunkLength, $startsWithVowel) {
        preg_match($this->nonAlphanumericRegex, $word, $match);
        $wordWithoutPunctuation = 
            $match 
                ? preg_replace($this->nonAlphanumericRegex, '', $word) 
                : $word;
        
        return substr($wordWithoutPunctuation, $chunkLength) 
            . substr($wordWithoutPunctuation, 0, $chunkLength) 
            . ($startsWithVowel ? 'way' : $this->suffix)
            . ($match[0] ?? '');
    }

    private function isVowel($letter) {
        return strpos($this->vowels, $letter) !== false;
    }

    private function postFormat($text) {
        $sentences = preg_split($this->nonAlphanumericRegex, $text, -1, PREG_SPLIT_OFFSET_CAPTURE);
        $formattedSentences = array_map(function($sentence) use ($text) {
            // dump($sentence);
            // $trimmedSentence = trim($sentence[0]);
            $words = explode(' ', $sentence[0]);
            // dump($words);
            $formattedWords = array_map(function($word) use ($words) {
                // dump($words);
                // $trimmedWord = trim($word);
                // dump(isset($word[0]));
                if (isset($word[0]) && ($words[0] == $word)) {
                    dump($word);
                    return strtoupper($word[0]) . strtolower(substr($word, 1));
                }
                return $word;
            }, $words);
            // dump($formattedWords);
            // dump($sentence[1]);
            if ($sentence[1] != 0) {
                return $text[$sentence[1]-1] . ' ' . join(' ', $formattedWords);
            } else {
                return join(' ', $formattedWords);
            }
            // return $sentence;
        }, $sentences);
        // dump($formattedSentences);
        return join('', $formattedSentences);
    }
    // private function postFormat($text) {
    //     $sentences = explode('.', $text);
    //     $pg = preg_split($this->nonAlphanumericRegex, $text, -1, PREG_SPLIT_OFFSET_CAPTURE);
    //     dump($pg);
    //     dump($text[118]);
    //     dump($text[167]);
    //     $formattedSentences = array_map(function($sentence) {
    //         $trimmedSentence = trim($sentence);
    //         $words = explode(' ', $trimmedSentence);
    //         $formattedWords = array_map(function($word) use ($words) {
    //             return ($words[0] && $word == $words[0])
    //                 ? strtoupper($word[0]) . strtolower(substr($word, 1))
    //                 : strtolower($word);
    //         }, $words);
    //         return join(' ', $formattedWords);
    //     }, $sentences);
    //     return join('. ', $formattedSentences);
    // }

    private function startsWithOneConsonant($word) {
        if (strlen($word) < 1) return false;
        return !$this->isVowel($word[0]); 
    }

    private function startsWithTwoConsonants($word) {
        if (strlen($word) < 2) return false;
       return !$this->isVowel($word[0]) && !$this->isVowel($word[1]);
    }

    private function startsWithVowel($word) {
        if (strlen($word) < 1) return false;
        return $this->isVowel($word[0]);
    }
}
