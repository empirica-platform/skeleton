<?php
/**
 * Created by PhpStorm.
 * User: zkrat
 * Date: 21.10.18
 * Time: 18:48
 */

namespace EmpiricaPlatform\Draw\MovingAverage;




class Ema extends AbstractSingleValue {

	const FUNCTION_NAME='trader_ema';
	const SUB_CLASS_NAME='EmpiricaPlatform\Draw\MovingAverage\EmaOhlc';


	public function getLabel() {
		return 'EMA'.$this->length;
	}
}