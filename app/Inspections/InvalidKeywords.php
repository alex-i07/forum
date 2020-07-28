<?php

namespace App\Inspections;


class InvalidKeywords
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
     * @throws \Exception
     */
    public function detect(string $body)
    {
        foreach ($this->invalidKeywords as $invalidKeyword) {
            if (stripos($body, $invalidKeyword) !== false ) {
                throw new \Exception('Your reply contains spam!');
            }
        }
    }
}
