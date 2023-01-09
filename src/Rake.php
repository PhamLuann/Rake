<?php

namespace PhamLuann\Rake;

class Rake
{
    private $stopWords = [];
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
        $this->stopWords("stopword.json");
    }

    /**
     * Lay danh sach cac stopword tu file
     * @param file name $stopWords
     */
    public function stopWords($stopWords)
    {
        if (!file_exists(__DIR__ . "/stopword/{$stopWords}")) {
            throw new \ErrorException(__DIR__ . "/stopword/{$stopWords}" . " Not found");
        }
        $this->stopWords = json_decode(file_get_contents(__DIR__ . "/stopword/{$stopWords}"));
        return $this->stopWords;
    }

    /**
     * Tach van ban thanh cac cau
     * @param String $content
     */
    public function splitContent($content)
    {
        return preg_split('/[.?!,;\-"\'()\n\r\t]+/u', $content);
    }

    /**
     * Lay ra cac ung vien (cum tu)
     * @param array $content
     */
    public function getWords($contents)
    {
        $words = [];
        $regex = '/\b' . implode('\b|\b', $this->stopWords) . '\b/iu';
        foreach ($contents as $content) {
            $content = trim(mb_strtolower($content));
            $wordItems = preg_replace($regex, "|", $content);    //thay the cac stopWords bang dau |
            $wordItems = explode("|", $wordItems);
            foreach ($wordItems as $wordItem) {
                $words[] = trim($wordItem);
            }
        }
        return $words;
    }

    /**
     * Tinh diem cho cac cum tu ung vien
     */
    public function getScore(array $list)
    {
        $frequencies = []; // word frequencies
        $degree = []; // degree of word
        $scores = []; // degree score

        //tinh freq
        foreach ($list as $item) {
            $words = explode(' ', $item);                              //lay ra tung tu trong cum tu

            foreach ($words as $word) {
                if (isset($frequencies[$word])) {
                    $frequencies[$word] = $frequencies[$word] + 1;      //so lan xuat hien cua moi tu
                } else {
                    $frequencies[$word] = 1;
                }

                if (isset($degree[$word])) {                              //so lan xuat hien trong tu ghep
                    $degree[$word] += count($words) - 1;
                } else {
                    $degree[$word] = count($words) - 1;
                }
            }
        }

        //tinh deg
        foreach ($frequencies as $key => $value) {
            $degree[$key] += $value;
        }

        // tinh score = degree of word / word frequencies
        foreach ($frequencies as $key => $value) {
            $scores[$key] = round($degree[$key] / $value, 3);
        }

        return $scores;
    }

    /**
     * @return array
     */
    public function getKeyword()
    {
        $contents = $this->splitContent($this->content); // tra ve 1 mang cac cau don
        $candidateKeyPhrases = $this->getWords($contents); // tra ve mang cac cum tu
        $scores = $this->getScore($candidateKeyPhrases); // tra ve diem cua tung tu don le
        $cumulativeScore = [];

        foreach ($candidateKeyPhrases as $keyPhrase) {
            $words = explode(' ', $keyPhrase);
            $score = 0;
            foreach ($words as $word) {
                $score += ($scores[$word] ?? 0);        //cong diem cho cum tu
            }
            $cumulativeScore[$keyPhrase] = $score;
        }
        arsort($cumulativeScore);
        return $cumulativeScore;
    }
}
