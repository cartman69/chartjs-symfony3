<?php

namespace AppBundle\Service\ChartJs;

/**
 * Description of HorizontalLine
 *
 * @author JTRICARD
 */
class Line {
    
    protected $coordinate;
    
    protected $style;
    
    protected $text;
    
    function getCoordinate() {
        return $this->coordinate;
    }

    function getStyle() {
        return $this->style;
    }

    function getText() {
        return $this->text;
    }

    function setCoordinate($coordinate) {
        $this->coordinate = $coordinate;
    }

    function setStyle($style) {
        $this->style = $style;
    }

    function setText($text) {
        $this->text = $text;
    }


}
