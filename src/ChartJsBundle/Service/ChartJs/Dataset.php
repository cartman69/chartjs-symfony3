<?php
namespace AppBundle\Service\ChartJs;

/**
 * Description of Dataset
 *
 * @author JTRICARD
 */
class Dataset {
    protected $name;
    
    protected $label;
    
    protected $data;

    protected $backgroundColors;
    
    protected $borderColors;
    
    protected $borderWidth = 1;
    
    protected $options;

    public function __construct($name = '')
    {
        $this->setName($name);
    }
    
    public function setName($name = '')
    {
        if(empty($name))
        {
            $name = count($this->datasets);
        }
        $this->name = $name;
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }
    
    function getLabel() {
        return $this->label;
    }

    function getData() {
        return $this->data;
    }

    function getBackgroundColors() {
        return $this->backgroundColors;
    }

    function getBorderColors() {
        return $this->borderColors;
    }

    function getBorderWidth() {
        return $this->borderWidth;
    }

    function getOptions() {
        return $this->options;
    }

    function setLabel($label) {
        $this->label = $label;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setBackgroundColors($backgroundColors) {
        $this->backgroundColors = $backgroundColors;
    }

    function addBackgroundColor($backgroundColor) {
        $this->backgroundColors[] = $backgroundColor;
    }

    function setBorderColors($borderColors) {
        $this->borderColors = $borderColors;
    }

    function addBorderColor($borderColor) {
        $this->borderColors[] = $borderColor;
    }

    function setBorderWidth($borderWidth) {
        $this->borderWidth = $borderWidth;
    }

    function setOptions($options) {
        $this->options = $options;
    }

    public function addOption($option)
    {
        $this->options = array_merge_recursive($this->options, $option);
    }
    
    public function generateOptions()
    {
        if(!empty($this->options))
        {
            return substr(json_encode($this->options), 1, -1);
        }
        else
        {
            return '';
        }
    }
    

    public function getBackgroundColorsArray()
    {
        if(is_array($this->backgroundColors))
        {
            return $this->backgroundColors;
        }
        else
        {
            $toExplode = str_replace(['[',']', ' '], '', $this->backgroundColors);
            return explode(',', $toExplode);
        }
    }

    public function generateData()
    {
        return implode(', ', $this->data);
    }

    public function generateBackgroundColors()
    {
        if(is_array($this->backgroundColors))
        {
            $data = "'".implode("', '", $this->backgroundColors) . "'";
            if(count($this->backgroundColors) >1)
            {
                $data = "[{$data}]";
            }
        }
        else
        {
            $data = $this->backgroundColors;
        }
        return $data;
    }
    
    public function generateBorderColors()
    {
        return "['".implode("', '", $this->borderColors) . "']";
    }
    
    public function generateLabels()
    {
        return '"'.implode('", "', $this->labels) . '"';
    }

}
