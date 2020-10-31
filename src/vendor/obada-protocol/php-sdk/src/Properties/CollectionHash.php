<?php

declare(strict_types=1);

namespace Obada\Properties;

use Obada\Hash;

trait CollectionHash {
	public function toHash() {
		return new Hash(
			dechex(
				array_sum(
					array_map(
						fn (Property $property) => $property->toHash()->toDecimal(),
						$this->items
					)
				)
			)
		);
	}
}