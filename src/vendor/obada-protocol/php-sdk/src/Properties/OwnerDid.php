<?php

declare(strict_types=1);

namespace Obada\Properties;

class OwnerDid extends SimpleProperty {
	/**
	 * @return bool
	 */
	public function isValid(): bool {
		return strlen($this->value) > 0;
	}

	/**
	 * @return string
	 */
	public function getValidationMessage(): string {
		return "OwnerDid is required and cannot be empty";
	}
}