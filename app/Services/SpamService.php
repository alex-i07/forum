<?php

namespace App\Services;

class SpamService
{
    /**
     * @var array
     */
    protected $invalidKeywords = [
        'This is spam!'
    ];

    /**
     * @param string $body
     *
     * @return bool
     */
    public function detect(string $body): bool
    {
        return $this->detectInvalidKeyWords($body);
    }

    /**
     * @param string $body
     * @return bool
     *
     * @throws \Exception
     */
    protected function detectInvalidKeyWords(string $body): bool
    {
        foreach ($this->invalidKeywords as $invalidKeyword) {
            if (stripos($body, $invalidKeyword) !== false ) {
                throw new \Exception('Your reply contains spam!');
            }
        }

        return false;
    }
}
