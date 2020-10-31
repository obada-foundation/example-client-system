<?php

declare(strict_types=1);

namespace Obada\Properties;

use Obada\Hash;
use Tuupola\Base58;
use Obada\Properties\Manufacturer;
use Obada\Properties\PartNumber;
use Obada\Properties\SerialNumberHash;

class ObitId extends Property {

	protected Manufacturer $manufacturer;

	protected SerialNumberHash $serialNumberHash;

	protected PartNumber $partNumber;

	protected ?Hash $hash = null;

	/**
	 * ObitId constructor.
	 * @param SerialNumberHash $serialNumberHash
	 * @param Manufacturer $manufacturer
	 * @param PartNumber $partNumber
	 */
	public function __construct(SerialNumberHash $serialNumberHash, Manufacturer $manufacturer, PartNumber $partNumber) {
		$this->serialNumberHash = $serialNumberHash;
		$this->manufacturer     = $manufacturer;
		$this->partNumber       = $partNumber;
	}

	/**
	 * @param array $properties
	 * @return ObitId
	 * @throws \Obada\Exceptions\PropertyValidationException
	 */
	public static function make(array $properties) {
		$manufacturer = isset($properties['manufacturer'])
			? new Manufacturer($properties['manufacturer'])
			: new Manufacturer("");

		$serialNumberHash = isset($properties['serial_number_hash'])
			? new SerialNumberHash($properties['serial_number_hash'])
			: new SerialNumberHash("");

		$partNumber = isset($properties['part_number'])
			? new PartNumber($properties['part_number'])
			: new PartNumber("");

		return new self($serialNumberHash, $manufacturer, $partNumber);
	}

	/**
	 * @return Hash
	 */
	public function toHash(): Hash {
		if (! $this->hash || ! ($this->hash instanceof Hash)) {
			$this->hash = new Hash(dechex(
				$this->serialNumberHash->toHash()->toDecimal() +
				$this->manufacturer->toHash()->toDecimal() +
				$this->partNumber->toHash()->toDecimal()
			));
		}

		return $this->hash;
	}

	/**
	 * @return bool
	 */
	public function isValid(): bool {
		return true;
	}

	/**
	 * Converts ObitId to Universal Serial Number
	 *
	 * @return string
	 */
	public function toUsn(): string {
		$encoder = new Base58(["characters" => Base58::BITCOIN]);

		return substr($encoder->encode((string) $this->toHash()), 0, 8);
	}

	/**
	 * @return string
	 */
	public function toDid(): string {
		return sprintf('did:obada:%s', $this->toHash());
	}

	/**
	 * Nothing to validate because we always receive valid input. May change in future.
	 *
	 * @return string
	 */
	public function getValidationMessage(): string {
		return "";
	}
}