<?php

declare(strict_types=1);

namespace Obada\Properties;

class SerialNumberHash extends SimpleProperty {

	/**
	 * @return bool
	 */
	public function isValid(): bool {
		return strlen($this->value) > 0 && preg_match('/^([a-f0-9]{64})$/', $this->value);
	}

	/**
	 * @return string
	 */
	public function getValidationMessage(): string {
		return 'Serial number hash must be a valid SHA256 hash';
	}
}