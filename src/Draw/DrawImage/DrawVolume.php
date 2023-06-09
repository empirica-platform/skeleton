<?php
/**
 * Created by PhpStorm.
 * User: zkrat
 * Date: 22.02.19
 * Time: 10:27
 */

namespace EmpiricaPlatform\Draw\DrawImage;


use Nette\Utils\Image;

class DrawVolume extends AbstractDrawIndicator
{


    protected function loadIndicator()
    {

    }

    public static function create(int $height = 30, DrawOhlcList $drawOhlcList)
    {
        $class = new static($height, $drawOhlcList, null);
        $class->setColor(Image::rgb(0, 0, 0));
        return $class;
    }

    private $pxRatio;

    public function getPxRatio(): float
    {
        if (is_null($this->pxRatio)) {
            $maxVolume = $this->drawOhlcList->getMaxVolume();
            $pxHeight = $this->getY2() - $this->getY1();
            $this->pxRatio = $pxHeight / $maxVolume;
        }

        return $this->pxRatio;
    }

    public function getYPxByVolume($volume): int
    {
        return (int)($this->getY2() - $this->getPxRatio() * $volume);
    }


    public function draw()
    {
        $position = $this->drawOhlcList->getFirstDrawPosition();
        foreach ($this->getDrawOhlcList() as $drawOhlc) {
            /** @var DrawOhlc $drawOhlc */
            if ($drawOhlc instanceof DrawOhlc && $position <= $drawOhlc->getOhlc()->getPosition() && $drawOhlc->isDrawPostion()) {
                $x1 = $drawOhlc->getAbsolutOffsetX();
                $x2 = $drawOhlc->getAbsolutOffsetX() + $this->drawOhlcList->getCandelBodyWidth();
                $pxY1 = $this->getYPxByVolume($drawOhlc->getOhlc()->getVolume());
                $y2 = $this->getY2();
                $color = $drawOhlc->getColorByTrend();
                $this->getImage()->filledRectangle($x1, $pxY1, $x2, $y2, $color);
                $size = 8;
                if ($this->drawOhlcList->getMaxVolume() === $drawOhlc->getOhlc()->getVolume()) {
                    $volume = $drawOhlc->getOhlc()->getVolume();
                }
            }
        }
        $x = $this->getX1();
        $y = $this->getY1() + $size + 2;
        $black = Image::rgb(0, 0, 0);
        $this->getImage()->ttfText($size, 0, $x, $y, $black, $this->fontPath, 'Max. volume: ' . $volume);
        parent::draw();
        $this->getImage()->line($this->getX1(), $this->getY2(), $this->getX2(), $this->getY2(), $this->color);
    }

    public function getDrawOhlcList(): DrawOhlcList
    {
        if ($this->drawOhlcList instanceof DrawBgOhlcList) {
            return $this->drawOhlcList->getDrawOhlcList();
        }

        return $this->drawOhlcList;
    }
}
