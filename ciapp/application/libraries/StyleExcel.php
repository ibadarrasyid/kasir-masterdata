<?php

class StyleExcel {

    protected $CI;
    var $titleStyle, $headerStyle, $bodyStyle, $centerStyle, $rightStyle;

    public function __construct() {
        // Assign the CodeIgniter super-object
        $this->CI = & get_instance();
        $this->CI->load->library('PHPExcel');
        $this->titleStyle = new PHPExcel_Style();
        $this->headerStyle = new PHPExcel_Style();
        $this->bodyStyle = new PHPExcel_Style();
        $this->centerStyle = new PHPExcel_Style();
        $this->rightStyle = new PHPExcel_Style();
    }

    public function getTitleStyle($newValue = array()) {
        $arr = array_merge(array(
            'font' => array(
                'bold' => true,
                'size' => 11,
                'name' => 'Arial'),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0)
                ), $newValue);

        $this->titleStyle->applyFromArray($arr);
        return $this->titleStyle;
    }

    public function getHeaderStyle($newValue = array()) {
        $arr = array_merge(array(
            'font' => array(
                'bold' => true,
                'size' => 9,
                'name' => 'Arial'),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => true),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => 'FFEEEEEE')),
            'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )), $newValue);
        $this->headerStyle->applyFromArray($arr);
        return $this->headerStyle;
    }

    function getBodyStyle($newValue = array()) {
        $arr = array_merge(array('font' => array(
                'size' => 9,
                'name' => 'Arial'),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                'wrap' => true),
            'borders' => array(
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
                ), $newValue);
        $this->bodyStyle->applyFromArray($arr);
        return $this->bodyStyle;
    }

    function getCenterStyle($newValue = array()) {
        $app = array_merge(array('font' => array(
                'size' => 9,
                'name' => 'Arial'),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
            'borders' => array(
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
                ), $newValue);
        $this->centerStyle->applyFromArray($app);
        return $this->centerStyle;
    }

    function getRightStyle($newValue = array()) {
        $app = array_merge(array('font' => array(
                'size' => 9,
                'name' => 'Arial'),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
            'borders' => array(
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
                ), $newValue);
        $this->rightStyle->applyFromArray($app);
        return $this->rightStyle;
    }

    function getLeftStyle($newValue = array()) {
        $app = array_merge(array('font' => array(
                'size' => 9,
                'name' => 'Arial'),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
                ), $newValue);
        $this->rightStyle->applyFromArray($app);
        return $this->rightStyle;
    }

}
