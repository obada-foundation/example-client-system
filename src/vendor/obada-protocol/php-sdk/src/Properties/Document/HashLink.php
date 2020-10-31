<?php

declare(strict_types=1);

namespace Obada\Properties\Document;

use Obada\Hash;
use Obada\Properties\SimpleProperty;

class HashLink extends SimpleProperty {

	public function isValid(): bool {
		return is_string($this->value) && strlen($this->value) > 0;
	}

	public function getValidationMessage(): string {
		return 'Name must be valid string with length more than 0.';
	}

	public function toHash(): Hash {
		return new Hash('');
	}
}