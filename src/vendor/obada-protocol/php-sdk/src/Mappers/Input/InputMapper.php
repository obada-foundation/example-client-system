<?php

declare(strict_types=1);

namespace Obada\Mappers\Input;

use Obada\Obit;

interface InputMapper {
	/**
	 * @param $input
	 * @return mixed
	 */
	public function map($input): Obit;
}