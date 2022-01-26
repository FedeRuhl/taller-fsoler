<?php

namespace Tests;

use Tests\TestCase;

class TestCaseWithSeed extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }
}
