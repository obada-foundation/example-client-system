<?php

declare(strict_types=1);

namespace Obada\Properties;

use Obada\Exceptions\PropertyValidationException;
use Obada\Hash;

abstract class SimpleProperty extends Property {

	/**
	 * @var string
	 */
	protected string $value;

	/**
	 * SimpleProperty constructor.
	 * @param string $value
	 * @throws PropertyValidationException
	 */
	public function __construct(string $value) {
		$this->value = $value;

		if (! $this->isValid()) {
			throw new PropertyValidationException($this);
		}
	}

	/**
	 * @return Hash
	 */
	public function toHash(): Hash {
		return new Hash($this->value);
	}

	/**
	 * @return string
	 */
	public function __toString() :string {
		return $this->value;
	}
}