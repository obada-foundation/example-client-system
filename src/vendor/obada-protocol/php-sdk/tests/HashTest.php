<?php

declare(strict_types=1);

namespace Tests;

use Obada\Hash;
use PHPUnit\Framework\TestCase;

class HashTest extends TestCase {
	public function testItGeneratesHash(): void {
		$this->assertEquals(hash('sha256', '123'), new Hash('123'));
	}

	public function testItConvertsHashToDecimal(): void {
		$this->assertEquals(
			hexdec(substr(hash('sha256', '123'), 0, 8)),
			(new Hash('123'))->toDecimal()
		);
	}
}