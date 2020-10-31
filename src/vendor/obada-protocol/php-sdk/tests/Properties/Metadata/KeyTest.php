<?php

declare(strict_types=1);

namespace Tests\Metadata;

use Obada\Exceptions\PropertyValidationException;
use Obada\Properties\Metadata\Key;
use PHPUnit\Framework\TestCase;
use Throwable;

class KeyTest extends TestCase {

	public function testItCreatesMetadataKeyProperty(): void {
		$this->assertEquals('color', (string) new Key('color'));
	}

	public function testItThrowsValidationExceptionWhenMetadataKeyIsEmpty() {
		try {
			new Key('');

			$this->fail('Passed unavailable status that was accepted.');
		} catch (Throwable $t) {
			$this->assertInstanceOf(PropertyValidationException::class, $t);
			$this->assertEquals('Key must be valid string with length more than 0.', $t->getMessage());
		}
	}

	public function testItGeneratesCorrectHash() {
		$key = new Key('color');

		$this->assertEquals(hash('sha256', 'color'), (string) $key->toHash());
	}
}