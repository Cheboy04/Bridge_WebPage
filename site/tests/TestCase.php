<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // CI builds after testing (CLAUDE.md §7.2), so the suite can't depend on public/build.
        $this->withoutVite();
    }
}
