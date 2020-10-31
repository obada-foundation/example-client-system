<?php

declare(strict_types=1);

namespace Tests;

use Obada\Exceptions\PropertyValidationException;
use Obada\Properties\Status;
use PHPUnit\Framework\TestCase;
use Throwable;

class StatusTest extends TestCase {

	public function testItCreatesPartNumberProperty(): void {
		foreach (Status::STATUSES as $status) {
			$this->assertEquals($status, new Status($status));
		}
	}

	public function testItNotThrowsWhenStatusIsEmpty() {
			new Status('');

			$this->assertEquals('', (string) new Status(''));
	}

	public function testItThrowsValidationExceptionWhenPartNumberIsEmpty() {
		try {
			new Status('fake status');

			$this->fail('Passed unavailable status that was accepted.');
		} catch (Throwable $t) {
			$this->assertInstanceOf(PropertyValidationException::class, $t);
			$this->assertEquals(
				"Obit status is not supported. Supported statuses: " . implode(', ', Status::STATUSES),
				$t->getMessage()
			);
		}
	}
}