<?php
/**
 * Created by PhpStorm.
 * User: zkrat
 * Date: 11.02.19
 * Time: 22:38
 */
namespace EmpiricaPlatform\Draw\Indicators\RSI;

use EmpiricaPlatform\Draw\MovingAverage\AbstractSingleValue;


class RSI extends AbstractSingleValue {


	const FUNCTION_NAME='LupeCode\phpTraderNative\Trader::rsi';

	const SUB_CLASS_NAME='EmpiricaPlatform\Draw\Indicators\RSI\RSIOhlc';


	public function getLabel() {
		return 'RSI'.$this->length;
	}
}