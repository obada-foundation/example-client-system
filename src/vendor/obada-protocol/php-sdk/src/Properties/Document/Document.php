<?php

declare(strict_types=1);

namespace Obada\Properties\Document;

use Obada\Hash;
use Obada\Properties\Property;

class Document extends Property {

	protected Name $name;

	protected HashLink $hashLink;

	public function __construct(Name $name, HashLink $hashLink) {
		$this->name     = $name;
		$this->hashLink = $hashLink;
	}

	public function toHash(): Hash {
		return new Hash(dechex(
			$this->name->toHash()->toDecimal() +
			$this->hashLink->toHash()->toDecimal()
		));
	}

	public function getName(): Name {
		return $this->name;
	}

	public function getHashLink(): HashLink {
		return $this->hashLink;
	}

	public function isValid(): bool {
		return true;
	}

	public function getValidationMessage(): string {
		return "";
	}
}