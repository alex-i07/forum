<?php

namespace App\Inspections;


class DetectKeyHeldDown
{
    /**
     * @param string $body
     *
     * @throws \Exception
     */
    public function detect(string $body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new \Exception('Your reply contains spam!');
        }
    }
}
