<?php

declare(strict_types=1);

namespace Obada\Properties;

use Obada\Hash;

abstract class Property {
	/**
	 * @return Hash
	 */
	abstract public function toHash(): Hash;

	/**
	 * @return bool
	 */
	abstract public function isValid(): bool;

	/**
	 * @return string
	 */
	abstract public function getValidationMessage(): string;
}