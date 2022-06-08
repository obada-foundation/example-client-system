<?php

namespace Tests\Feature\Http\Handlers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class DevicesTest extends TestCase {
    use RefreshDatabase;

    public function testUserCanCreateDocument() {
        $user = User::factory()->create();

        $requestData = [
            'file' => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $response = $this->actingAs($user)->post(route('devices.documents.store'), $requestData);

        $response->assertSuccessful();
    }

    public function testUserCanCreateDevice() {
        $user = User::factory()->create();

        $requestData = [
            'serial_number' => 'SN123456',
            'manufacturer'  => 'SONY',
            'part_number'   => 'PN123456',
            'documents'     => [
                [
                    'doc_name' => 'test',
                    'doc_path' => 'https://google.com'
                ]
            ]
        ];

        $response = $this->actingAs($user)->post(route('devices.save'), $requestData);

        $response->assertSuccessful();
    }


}