<?php

namespace App\Rules;

use App\Inspections\SpamService;
use Illuminate\Contracts\Validation\Rule;

class SpamFree implements Rule
{
    public $spamService;

    /**
     * SpamFree constructor.
     * @param SpamService $spamService
     */
    public function __construct(SpamService $spamService)
    {
        $this->spamService = $spamService;

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        try {
            return ! $this->spamService->detect($value);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.spamfree');
    }
}
