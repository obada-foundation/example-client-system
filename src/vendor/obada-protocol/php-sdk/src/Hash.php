<?php

declare(strict_types=1);

namespace Obada;

class Hash {

	/**
	 * @var string
	 */
	protected string $hash;

	/**
	 * Hash constructor.
	 * @param $value
	 */
	public function __construct($value) {
		$this->hash = hash('sha256', $value);
	}

	/**
	 * @return float|int
	 */
	public function toDecimal() {
		return hexdec(substr($this->hash, 0, 8));
	}

	/**
	 * @return string
	 */
	public function __toString(): string {
		return $this->hash;
	}
}