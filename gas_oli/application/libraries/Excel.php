<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('PHPExcel.php');

class Excel extends PHPExcel
{

    private $CI;

    private $config = [
        '0' => 'well_id',
        '1' => 'name',
        '2' => 'location',
        '3' => 'status',
        '4' => 'lat',
        '5' => 'lng',
        '6' => 'company_id',
        '7' => 'company_field',
        '8' => 'comment',
        '9' => 'road_status',
        '10' => 'state_id',
    ];

    public function __construct()
    {
        $this->CI = get_instance();
        parent::__construct();

        $this->CI->load->model("Company_model");
        $this->CI->load->model("Well_model");

    }

    public function import_excel($file_url, $col_count = 11)
    {

        if (empty($file_url)) {
            return false;
        }

        $return_data = [];

        $object = PHPExcel_IOFactory::load($file_url);

        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            for ($row = 2; $row <= $highestRow; $row++) {

                $return_data[] = [
                    $this->config[0] => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
                    $this->config[1] => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                    $this->config[2] => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                    $this->config[3] => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                    $this->config[4] => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
                    $this->config[5] => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
                    $this->config[6] => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
                    $this->config[7] => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                    $this->config[8] => $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
                    $this->config[9] => $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
                    $this->config[10] => $worksheet->getCellByColumnAndRow(10, $row)->getValue()
                ];
            }
        }

       return $return_data;
    }

    public function  create_excel($data){

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $rowCount = 1;

        $url = FCPATH.'upload_image/download_excel/down_excel.xlsx';

        if(file_exists($url)){

            unlink($url);
        }


        foreach ($data as $index => $single){

            if($index == 0){

                $objPHPExcel->getActiveSheet()->SetCellValue('A'.intval($index+1), 'Well  Id');
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.intval($index+1), 'Well  Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.intval($index+1), 'Surface  Location');
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.intval($index+1), 'Well  Status');
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.intval($index+1), 'Surface  Latitude');
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.intval($index+1), 'Surface  Longitutde');
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.intval($index+1), 'Company');
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.intval($index+1), 'Company Field');
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.intval($index+1), 'Comment');
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.intval($index+1), 'Road Status');
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.intval($index+1), 'State');

                if(!empty($single['company_id'])){
                    $company = $this->CI->Company_model->get_company_name_by_id($single['company_id']);
                }

                if(!empty($single['state_id'])){
                    $state   = $this->CI->Well_model->get_states_by_id($single['state_id']);
                }

                if(!empty($company)){
                    $single['company_id'] = $company;
                }

                if(!empty($state)){
                    $single['state_id'] = $state['state'];
                }

                $objPHPExcel->getActiveSheet()->SetCellValue('A'.intval($index+2), $single['well_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.intval($index+2), $single['name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.intval($index+2), $single['location']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.intval($index+2), $single['status']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.intval($index+2), $single['lat']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.intval($index+2), $single['lng']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.intval($index+2), $single['company_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.intval($index+2), $single['company_field']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.intval($index+2), $single['comment']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.intval($index+2), $single['road_status']);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.intval($index+2), $single['state_id']);

            }else{

                if(!empty($single['company_id'])){
                    $company = $this->CI->Company_model->get_company_name_by_id($single['company_id']);
                }

                 if(!empty($single['state_id'])){
                     $state   = $this->CI->Well_model->get_states_by_id($single['state_id']);
                 }

                if(!empty($company)){
                    $single['company_id'] = $company;
                }

                if(!empty($state)){
                    $single['state_id'] = $state['state'];
                }

                $objPHPExcel->getActiveSheet()->SetCellValue('A'.intval($index+2), $single['well_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.intval($index+2), $single['name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.intval($index+2), $single['location']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.intval($index+2), $single['status']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.intval($index+2), $single['lat']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.intval($index+2), $single['lng']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.intval($index+2), $single['company_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.intval($index+2), $single['company_field']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.intval($index+2), $single['comment']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.intval($index+2), $single['road_status']);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.intval($index+2), $single['state_id']);
            }
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save($url);
        chmod($url, 0777);
        return $url;
    }
}

?>