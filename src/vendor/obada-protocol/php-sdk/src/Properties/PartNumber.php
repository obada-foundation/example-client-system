<?php

declare(strict_types=1);

namespace Obada\Properties;

class PartNumber extends SimpleProperty {
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
		return "PartNumber is required and cannot be empty";
	}
}