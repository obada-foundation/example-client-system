<?php

namespace Tests\Feature\Http\Requests;

use Tests\TestCase;
use Faker\Factory;

class ComputeUsnRequestTest extends TestCase
{
    public function provideValidationTestCases()
    {
        $faker = Factory::create();

        return [
            [
                'given'    => [],
                'expected' => [
                    'statusCode' => 422,
                    'data'       => [
                        'message' => 'The manufacturer field is required. (and 2 more errors)',
                        'errors'  => [
                            'manufacturer'  => ['The manufacturer field is required.'],
                            'part_number'   => ['The part number field is required.'],
                            'serial_number' => ['The serial number field is required.']
                        ]
                    ]
                ]
            ],

            [
                'given' => [
                    'manufacturer'  => $faker->randomDigit,
                    'part_number'   => $faker->randomDigit,
                    'serial_number' => $faker->randomDigit,
                ],
                'expected' => [
                    'statusCode' => 422,
                    'data'       => [
                        'message' => 'The manufacturer must be a string. (and 2 more errors)',
                        'errors'  => [
                            'manufacturer'  => ['The manufacturer must be a string.'],
                            'part_number'   => ['The part number must be a string.'],
                            'serial_number' => ['The serial number must be a string.']
                        ]
                    ]
                ]
            ],

            [
                'given' => [
                    'manufacturer'  => str_repeat($faker->word, 256),
                    'part_number'   => str_repeat($faker->word, 256),
                    'serial_number' => str_repeat($faker->word, 256),
                ],
                'expected' => [
                    'statusCode' => 422,
                    'data'       => [
                        'message' => 'The manufacturer may not be greater than 255 characters. (and 2 more errors)',
                        'errors'  => [
                            'manufacturer'  => ['The manufacturer may not be greater than 255 characters.'],
                            'part_number'   => ['The part number may not be greater than 255 characters.'],
                            'serial_number' => ['The serial number may not be greater than 255 characters.']
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider provideValidationTestCases
     */
    public function testRequestValidation($given, $expected)
    {
        $this->postJson(route('generate.usn.compute'), $given)
            ->assertStatus($expected['statusCode'])
            ->assertExactJson($expected['data']);
    }
}