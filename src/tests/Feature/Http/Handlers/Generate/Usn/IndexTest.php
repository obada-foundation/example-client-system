<?php

namespace Tests\Feature\Http\Handlers\Generate\Usn;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testIndexPage()
    {
        $this->get(route('generate.usn.index'))
            ->assertStatus(200);
    }
}