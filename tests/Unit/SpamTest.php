<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\SpamService;

class SpamTest extends TestCase
{
    /**
     * @test
     */
    public function it_validates_spam()
    {
        $spam = new SpamService();

        $this->assertFalse($spam->detect('Innocent reply here!'));

        $this->expectException(\Exception::class);
        $spam->detect('This is spam!');
    }
}