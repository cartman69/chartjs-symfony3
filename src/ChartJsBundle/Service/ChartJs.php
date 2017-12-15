<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Service;

use AppBundle\Service\ChartJs\Dataset;
use AppBundle\Service\ChartJs\Line;

/**
 * Description of ChartJs
 *
 * @author JTRICARD
 */
class ChartJs {
    
    const RED_BORDER_COLOR = 'rgba(255, 51, 0, 1)';
    const RED_BACKGROUND_COLOR = 'rgba(255, 51, 0, 0.7)';
    
    const BLUE_BORDER_COLOR = 'rgba(20, 77, 244, 1)';
    const BLUE_BACKGROUND_COLOR = 'rgba(20, 77, 244, 0.5)';
    
    const ORANGE_BORDER_COLOR = 'rgba(244, 146, 0, 1)';
    const ORANGE_BACKGROUND_COLOR = 'rgba(244, 146, 0, 0.5)';
    
    const RED_LIMIT = 'rgba(255, 0, 0, 0.6)';
    const ORANGE_LIMIT = 'rgba(255, 140, 0, 0.6)';
    const GREEN_LIMIT = 'rgba(0, 255, 0, 0.6)';
    
    const PIE_COLOR_1 = 'rgb(255, 99, 132)';
    const PIE_COLOR_2 = 'rgb(255, 159, 64)';
    const PIE_COLOR_3 = 'rgb(255, 205, 86)';
    const PIE_COLOR_4 = 'rgb(75, 192, 192)';
    const PIE_COLOR_5 = 'rgb(54, 162, 235)';
    const PIE_COLOR_6 = 'rgb(153, 102, 255)';
    const PIE_COLOR_7 = 'rgb(201, 203, 207)';
    const PIE_COLOR_8 = 'rgb(44, 169, 44)';
    const PIE_COLOR_9 = 'rgb(187, 169, 44)';
    const PIE_COLOR_10 = 'rgb(187, 52, 201)';

    /**
     *
     * @var type 
     */
    protected $data;
    
    protected $labels;
    
    protected $title;
    
    protected $type;
    
    protected $canvasId;
    
    protected $canvasWidth;
    
    protected $canvasHeight;
    
    protected $codeJs;
    
    protected $templating;
    
    protected $borderColors;
    
    protected $backgroundColors;
    
    protected $responsive = true;
    
    protected $htmlLabels = false;
    
    protected $horizontalLines = null;

    protected $verticalLines = null;
    
    protected $options = [];
    
    /**
     *
     * @var bool
     */
    protected $displayLegend = true;

    /**
     *
     * @var bool
     */
    protected $insertJsBalises = false;

    /**
     * 
     * @var bool $insertCanvas
     */
    protected $insertCanvas;
    
    /**
     *
     * @var AppBundle\Service\ChartJs\Dataset[]
     */
    protected $dataSets;

    public function __construct($templating)
    { 
        $this->templating = $templating;
    }
    
    function getLabels() {
        return $this->labels;
    }

    function getTitle() {
        return $this->title;
    }

    function getType() {
        return $this->type;
    }

    function getCanvasId() {
        return $this->canvasId;
    }

    function setLabels($labels) {
        $this->labels = $labels;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setCanvasId($canvasId) {
        $this->canvasId = $canvasId;
    }
    
    function getCanvasWidth() {
        return $this->canvasWidth;
    }

    function setCanvasWidth($canvasWidth) {
        $this->canvasWidth = $canvasWidth;
    }
    
    function getCanvasHeight() {
        return $this->canvasHeight;
    }

    function setCanvasHeight($canvasHeight) {
        $this->canvasHeight = $canvasHeight;
    }

        
    function getInsertCanvas() {
        return $this->insertCanvas;
    }

    function setInsertCanvas($insertCanvas) {
        $this->insertCanvas = $insertCanvas;
    }
    
    function getInsertJsBalises() {
        return $this->insertJsBalises;
    }

    function setInsertJsBalises($insertJsBalises) {
        $this->insertJsBalises = $insertJsBalises;
    }
    
    function getDataSets() {
        return $this->dataSets;
    }

    function getBorderColors() {
        return $this->borderColors;
    }

    function getBackgroundColors() {
        return $this->backgroundColors;
    }

    function setBorderColors($borderColors) {
        if(!is_array($borderColors))
        {
            $borderColors = [$borderColors];
        }
        $this->borderColors = $borderColors;
    }

    function setBackgroundColors($backgroundColors) {
        if(!is_array($backgroundColors))
        {
            $backgroundColors = [$backgroundColors];
        }
        $this->backgroundColors = $backgroundColors;
    }

        
    public function addData($data)
    {
        $this->data[] = $data;
    }
    
    public function addHorizontalLine(Line $line)
    {
        $this->horizontalLines[] = $line;
    }
    
    public function addVerticalLine(Line $line)
    {
        $this->VerticalLines[] = $line;
    }
    
    public function addOption($option)
    {
        $this->options = array_merge_recursive($this->options, $option);
    }
    
    public function generateOptions()
    {
        $this->options['legend']['display'] = $this->displayLegend;
        
        if(!empty($this->options))
        {
            return substr(json_encode($this->options), 1, -1);
        }
        else
        {
            return '';
        }
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
        $data = "'".implode("', '", $this->borderColors) . "'";
        if(count($this->borderColors) >1)
        {
            $data = "[{$data}]";
        }
        return $data;
    }
    
    public function generateLabels()
    {
        if(!is_array($this->labels))
        {
            foreach ($this->dataSets as $dataset)
            {
                $this->labels[] = $dataset->getLabel();
            }
            
        }
        return '"'.implode('", "', $this->labels) . '"';
    }
    
    public function generateJs()
    {
        $this->codeJs =  $this->templating->render('AppBundle::chartJs\chart.html.twig',
            [
                'id' => $this->canvasId,
                'type' => $this->type,
                'labels' => $this->generateLabels(),
/*                'data' => $this->generateData(),
                'backgroundColors' => $this->generateBackgroundColors(),
                'borderColors' => $this->generateBorderColors(),*/
                'insertCanvas' => $this->insertCanvas,
                'insertJsBalises' => $this->insertJsBalises,
                'title' => $this->title,
                'htmlLabels' => $this->htmlLabels,
                'datasets' => $this->dataSets,
                'horizontalLines' => $this->horizontalLines,
                'verticalLines' => $this->verticalLines,
                'options' => $this->generateOptions(),
            ]);
    }
    
    public function generateHtmlLabels()
    {
        return  $this->templating->render('AppBundle::chartJs\htmlLabels.html.twig',
            [
                'id' => $this->canvasId,
                'type' => $this->type,
                'labels' => $this->generateLabels(),
/*                'data' => $this->generateData(),
                'backgroundColors' => $this->generateBackgroundColors(),
                'borderColors' => $this->generateBorderColors(),*/
                'insertCanvas' => $this->insertCanvas,
                'insertJsBalises' => $this->insertJsBalises,
                'title' => $this->title,
                'htmlLabels' => $this->htmlLabels,
                'datasets' => $this->dataSets,
                ]);
    }
    
    public function generateHtmlLabelsPieChart()
    {
        $dataset = reset($this->dataSets);
        $bgColors = $dataset->getBackgroundColorsArray();
        $labels = [];
        for($i = 0; $i<count($this->labels);$i++)
        {
            $labels[$i]['color'] = $bgColors[$i];
            $labels[$i]['label'] = $this->labels[$i];
        }

        return  $this->templating->render('AppBundle::chartJs\htmlLabelsPieChart.html.twig',
            [
                'labels' => $labels,
                ]);
    }
    
    public function insertLinePlugin()
    {
        return  $this->templating->render('AppBundle::chartJs\linePluginCode.html.twig');
    }
    
    function getData(): type {
        return $this->data;
    }

    function getCodeJs() {
        if(null == $this->codeJs)
        {
            $this->generateJs();
        }
        return $this->codeJs;
    }

    public function insertCanvas()
    {
        return "<canvas id=\"{$this->canvasId}\" width=\"{$this->canvasWidth}\" height=\"{$this->canvasHeight}\"></canvas>";
    }

    public function addDataset($name, $dataset = null)
    {
        if(null == $dataset)
        {
            $dataset = new Dataset($name);
        }
        $this->dataSets[$dataset->getName()] = $dataset;
    }
    function getResponsive() {
        return $this->responsive;
    }

    function getHtmlLabels() {
        return $this->htmlLabels;
    }

    function setResponsive($responsive) {
        $this->responsive = $responsive;
    }

    function setHtmlLabels($htmlLabels) {
        $this->htmlLabels = $htmlLabels;
    }

    function getDisplayLegend() {
        return $this->displayLegend;
    }

    function setDisplayLegend($displayLegend) {
        $this->displayLegend = $displayLegend;
    }


    
    
}
