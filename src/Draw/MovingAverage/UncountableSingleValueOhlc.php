<?php
/**
 * Created by PhpStorm.
 * User: zkrat
 * Date: 22.10.18
 * Time: 13:28
 */

namespace EmpiricaPlatform\Draw\MovingAverage;


use EmpiricaPlatform\Draw\HistoryData\Ohlc;

class UncountableSingleValueOhlc extends AbstractSingleValueOhlc {


	public static function createUncountable(Ohlc $ohlc,AbstractSingleValue $singleValue){
		return new static(AbstractSingleValueOhlc::UNCOUNTABLE,$ohlc,$singleValue);
	}

}