<?php

declare(strict_types=1);

namespace Obada\Properties\StructuredData;

use Obada\Hash;
use Obada\Properties\Property;

class Record extends Property {

	protected Key $key;

	protected Value $value;

	public function __construct(Key $key, Value $value) {
		$this->key   = $key;
		$this->value = $value;
	}

	public function toHash(): Hash {
		return new Hash(dechex(
			$this->key->toHash()->toDecimal() +
			$this->value->toHash()->toDecimal()
		));
	}

	public function getKey(): Key {
		return $this->key;
	}

	public function getValue(): Value {
		return $this->value;
	}

	public function isValid(): bool {
		return true;
	}

	public function getValidationMessage(): string {
		return "";
	}
}