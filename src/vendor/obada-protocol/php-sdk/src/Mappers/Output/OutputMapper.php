<?php

declare(strict_types=1);

namespace Obada\Mappers\Output;

use Obada\Obit;

interface OutputMapper {
	/**
	 * @param Obit $obit
	 * @return mixed
	 */
	public function map(Obit $obit);
}