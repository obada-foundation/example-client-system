<?php

declare(strict_types=1);

namespace Obada\Properties\Metadata;

use Obada\Properties\SimpleProperty;

class Value extends SimpleProperty {

	public function isValid(): bool {
		return is_string($this->value) && strlen($this->value) > 0;
	}

	public function getValidationMessage(): string {
		return 'Value must be valid string with length more than 0.';
	}
}