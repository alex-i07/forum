<?php

namespace App\Inspections;

class SpamService
{
    /**
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class,
        DetectKeyHeldDown::class
    ];
    /**
     * @param string $body
     *
     * @return bool
     */
    public function detect(string $body): bool
    {
        foreach ($this->inspections as $inspection)
        {
            app($inspection)->detect($body);
        }

        return false;
    }
}
