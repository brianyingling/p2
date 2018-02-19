<?php

namespace p2;

class PigLatin {

    private $text;
    private $suffix;
    private $shortWordsUntouched;
    private $vowels = 'aeiou';
    private $nonAlphanumericRegex = '/\.|\?|\!|\,$/';

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
        $sentences = explode('.', $text);
        $formattedSentences = array_map(function($sentence) {
            $trimmedSentence =trim($sentence);
            $words = explode(' ', $trimmedSentence);
            $formattedWords = array_map(function($word) use ($words) {
                // dump($word);
                // dump($words);
                // dump($word == $words[0]);
                if ($word == $words[0]) {
                    return strtoupper($word[0]) . strtolower(substr($word, 1));
                } else {
                    return strtolower($word);
                }
            }, $words);
            return join(' ', $formattedWords);
            // dump($trimmedSentence);
            // return $trimmedSentence;
        }, $sentences);
        dump($formattedSentences);
        return join('. ', $formattedSentences);
        // return $text;
        // $formattedSentences = array_map(function($sentence) {
        //     $trimmedSentence = trim($sentence);
        //     $words = explode(' ', $trimmedSentence);
        //     $formattedWords = array_map(function($word) use ($words) {
        //         dump($words[0]);
        //         // dump($words);
        //         return ($word == $words[0]) ? $word[0] : strtolower($word);
        //     }, $words);
        //     return join(' ', $formattedWords);
        // }, $sentences);
        // return join('.', $formattedSentences);
    }

    // private function postFormat($text) {
    //     $sentences = explode('.', $text);
    //     $formattedSentences = array_map(function($sentence) use ($sentences) {
    //         $words = explode(' ', $sentence);
    //         $formattedWords = array_map(function($word) use ($words) {
    //             $formattedWord = strtolower($word);
    //             dump('formatted: ' . $formattedWord);
    //             dump('first: ' . $words[0]);
    //             dump($formattedWord == $words[0]);
    //             return (strtolower($formattedWord) == strtolower($words[0]))
    //                 ? strtoupper($formattedWord[0]) . substr($formattedWord, strlen($formattedWord)-1)
    //                 : $formattedWord;
    //         }, $words);
    //         return join(' ', $formattedWords);
    //     }, $sentences);
    //     return join('.', $formattedSentences);
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
