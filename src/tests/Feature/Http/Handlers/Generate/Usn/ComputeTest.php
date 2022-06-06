<?php

namespace Tests\Feature\Http\Handlers\Generate\Usn;

use Tests\TestCase;
use Faker\Factory;

class ComputeTest extends TestCase
{
    public function testUsnCompute()
    {
        $faker = Factory::create();

        $data = [
            'manufacturer'  => $faker->word,
            'part_number'   => $faker->word,
            'serial_number' => $faker->word,
        ];

        $this->postJson(route('generate.usn.compute'), $data)
            ->assertStatus(200);
    }
}