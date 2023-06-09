<?php
/**
 * Created by PhpStorm.
 * User: zkrat
 * Date: 14.02.19
 * Time: 20:58
 */

namespace EmpiricaPlatform\Draw\DrawImage;



use EmpiricaPlatform\Draw\HistoryData\Ohlc;
use Nette\Utils\Image;

class DrawOhlc extends AbstractDrawCanvas {

	/**
	 * @var Ohlc
	 */
	protected $ohlc;

	/**
	 * @var DrawOhlcList
	 */
	protected $drawOhlcList;

	public function __construct(Ohlc $ohlc, DrawOhlcList $drawOhlcList) {
		$this->ohlc = $ohlc;
		$this->drawOhlcList = $drawOhlcList;
		$this->drawOhlcList->addDrawCanvas($this);
		$this->drawOhlcList->addDrawPosition($this);
		$offsetX=$this->offsetX+$this->drawOhlcList->getPostionWidth($this->ohlc->getPosition());
		$this->setOffset($offsetX,$this->offsetY);
	}

	public function isDrawPostion():bool{
		return $this->drawOhlcList->isDrawPosition($this->ohlc->getPosition());
	}


	public static function create(Ohlc $ohlc,DrawOhlcList $drawOhlcList  ) {
		return new static($ohlc,$drawOhlcList);
	}

	public function draw() {


		if ($this->isDrawPostion()){



			$wickX1=$this->getAbsolutOffsetX()+$this->drawOhlcList->getCandelWickWidth()+1;
			$wickX2=$wickX1+$this->drawOhlcList->getCandelWickWidth();
			$wickY1=$this->drawOhlcList->countY($this->ohlc->getHigh());
			$wickY2=$this->drawOhlcList->countY($this->ohlc->getLow());



			$x1=$this->getAbsolutOffsetX();
			$x2=$this->getAbsolutOffsetX()+$this->drawOhlcList->getCandelBodyWidth();
			$y1=$this->drawOhlcList->countY($this->ohlc->getOpen());
			$y2=$this->drawOhlcList->countY($this->ohlc->getClose());


			$black=$this->drawOhlcList->getWickColor();
			$color  = $this->getColorByTrend();
			// candel wick
			$this->getImage()->filledRectangle($wickX1,$wickY1,$wickX2,$wickY2,$black);
			//Candel body
			$this->getImage()->filledRectangle($x1,$y1,$x2,$y2,$color);



		}


		parent::draw();
	}


	public function getColorByTrend():array {
		if($this->ohlc->isBearish())
			return $this->drawOhlcList->getColorBearish();
		else
			return $this->drawOhlcList->getColorBullish();

	}

	/**
	 * @return Ohlc
	 */
	public function getOhlc(): Ohlc {
		return $this->ohlc;
	}

}