<?php

declare(strict_types=1);

namespace Obada\Exceptions;

use Exception;
use Obada\Properties\Property;

class PropertyValidationException extends Exception {
	public function __construct(Property $property) {
		parent::__construct($property->getValidationMessage(), 0, null);
	}
}