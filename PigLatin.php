<?php

namespace p2;

class PigLatin
{

    private $text;
    private $suffix;
    private $shortWordsUntouched;
    private $vowels = 'aeiou';
    private $punctuationRegex = '/\.|\?|\!|\,|\;$/';

    public function __construct($text, $suffix = 'ay', $shortWordsUntouched = false)
    {
        $this->text = $text;
        $this->suffix = $suffix;
        $this->shortWordsUntouched = $shortWordsUntouched;
    }

    public function translate()
    {
        $words = explode(' ', $this->text);

        $translated = array_map(function ($word) {
            if ($this->shortWordsUntouched && strlen($word) < 3) {
                return $word;
            } else if ($this->startsWithTwoConsonants($word)) {
                return $this->format($word, 2, false);
            } else if ($this->startsWithOneConsonant($word)) {
                return $this->format($word, 1, false);
            } else if ($this->startsWithVowel($word)) {
                return $this->format($word, strlen($word), true);
            }
            return $word;
        }, $words);

        $translatedText = join(' ', $translated);
        return $this->postFormat($translatedText);
    }

    private function format($word, $chunkLength, $startsWithVowel)
    {
        preg_match($this->punctuationRegex, $word, $match);
        $wordWithoutPunctuation =
            $match
                ? preg_replace($this->punctuationRegex, '', $word)
                : $word;

        return substr($wordWithoutPunctuation, $chunkLength)
            . substr($wordWithoutPunctuation, 0, $chunkLength)
            . ($startsWithVowel ? 'way' : $this->suffix)
            . ($match[0] ?? '');
    }

    private function isVowel($letter)
    {
        return strpos($this->vowels, $letter) !== false;
    }

    private function postFormat($text)
    {
        $sentences = preg_split($this->punctuationRegex, $text, -1, PREG_SPLIT_OFFSET_CAPTURE);
        $formattedSentences = array_map(function ($sentence) use ($text) {
            $trimmedSentence = trim($sentence[0]);
            $words = explode(' ', $trimmedSentence);
            $formattedWords = array_map(function ($word) use ($words) {
                if (isset($word[0]) && ($words[0] == $word)) {
                    return strtoupper($word[0]) . strtolower(substr($word, 1));
                }
                return $word;
            }, $words);
            if ($sentence[1] != 0) {
                return $text[$sentence[1] - 1] . ' ' . join(' ', $formattedWords);
            } else {
                return join(' ', $formattedWords);
            }
        }, $sentences);
        return join('', $formattedSentences);
    }

    private function startsWithOneConsonant($word)
    {
        if (strlen($word) < 1) {
            return false;
        }
        return !$this->isVowel($word[0]);
    }

    private function startsWithTwoConsonants($word)
    {
        if (strlen($word) < 2) {
            return false;
        }
        return !$this->isVowel($word[0]) && !$this->isVowel($word[1]);
    }

    private function startsWithVowel($word)
    {
        if (strlen($word) < 1) {
            return false;
        }
        return $this->isVowel($word[0]);
    }
}
