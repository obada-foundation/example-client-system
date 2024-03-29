<?php

use Illuminate\Database\Seeder;

class SchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schema')->insert([
            'name' => 'Condition',
            'description' => 'The condition of the part.',
            'category' => 'device'
        ]);
        DB::table('schema')->insert([
            'name' => 'Price',
            'description' => 'The price of the part.',
            'data_type' => 'float',
            'category' => 'device'
        ]);
        DB::table('schema')->insert([
            'name' => 'Description',
            'description' => 'The description of the part.',
            'data_type' => 'text',
            'category' => 'device'
        ]);
        DB::table('schema')->insert([
            'name' => 'Certificate of Data Santiziation',
            'description' => 'The certificate generated when data is wiped from devices.',
            'data_type' => 'text',
            'category' => 'events'
        ]);
        DB::table('schema')->insert([
            'name' => 'Image',
            'description' => 'Image of the device.',
            'data_type' => 'text',
            'category' => 'device'
        ]);
        DB::table('schema')->insert([
            'name' => 'Comment',
            'description' => 'General comments and notes about the device',
            'data_type' => 'text',
            'category' => 'device'
        ]);
        DB::table('schema')->insert([
            'name' => 'Other',
            'description' => 'Any other information related to the device',
            'data_type' => 'text',
            'category' => 'other'
        ]);
    }
}
