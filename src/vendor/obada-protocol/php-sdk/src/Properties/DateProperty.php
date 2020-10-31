<?php

declare(strict_types=1);

namespace Obada\Properties;

use Obada\Exceptions\PropertyValidationException;
use Obada\Hash;
use DateTime;

abstract class DateProperty extends Property {

	/**
	 * @var DateTime
	 */
	protected DateTime $date;

	/**
	 * DateProperty constructor.
	 * @param DateTime $date
	 * @throws PropertyValidationException
	 */
	public function __construct(DateTime $date) {
		$this->date = $date;

		if (! $this->isValid()) {
			throw new PropertyValidationException($this);
		}
	}

	public function __toString(): string {
		return $this->date->format('Y-m-d H:i:s');
	}

	/**
	 * @return Hash
	 */
	public function toHash(): Hash {
		return new Hash((string) $this->date->getTimestamp());
	}
}