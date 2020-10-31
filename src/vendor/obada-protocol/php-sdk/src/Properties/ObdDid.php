<?php

declare(strict_types=1);

namespace Obada\Properties;

class ObdDid extends SimpleProperty {
	/**
	 * @return bool
	 */
	public function isValid(): bool {
		return true;
	}

	/**
	 * @return string
	 */
	public function getValidationMessage(): string {
		return "";
	}
}