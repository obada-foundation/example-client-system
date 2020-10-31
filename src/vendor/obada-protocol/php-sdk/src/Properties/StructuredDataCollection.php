<?php

declare(strict_types=1);

namespace Obada\Properties;

use IteratorAggregate;
use ArrayIterator;
use Obada\Properties\StructuredData\Record;

class StructuredDataCollection implements IteratorAggregate {

	use CollectionHash;

	protected array $items = [];

	public function __construct(Record ...$items) {
		$this->items = $items;
	}

	public function toArray() {
		return array_map(
			fn ($record) => ['key' => (string) $record->getKey(), 'value' => (string) $record->getValue()],
			$this->items
		);
	}

	/**
	 * @param Record $metadataRecord
	 * @return $this
	 */
	public function add(Record $metadataRecord) {
		$this->items[] = $metadataRecord;

		return $this;
	}

	public function getIterator() {
		return new ArrayIterator($this->items);
	}
}