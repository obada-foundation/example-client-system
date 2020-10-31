<?php

declare(strict_types=1);

namespace Tests;

use Obada\Exceptions\PropertyValidationException;
use Obada\Properties\PartNumber;
use PHPUnit\Framework\TestCase;
use Throwable;

class PartNumberTest extends TestCase {

	public function testItCreatesPartNumberProperty(): void {
		$this->assertEquals("part number", new PartNumber('part number'));
	}

	public function testItThrowsValidationExceptionWhenPartNumberIsEmpty() {
		try {
			new PartNumber('');

			$this->assertTrue(false);
		} catch (Throwable $t) {
			$this->assertInstanceOf(PropertyValidationException::class, $t);
			$this->assertEquals('PartNumber is required and cannot be empty', $t->getMessage());
		}
	}
}