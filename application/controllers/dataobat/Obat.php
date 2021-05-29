<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Obat extends CI_Controller{
    function getObat(){
        $list = $this->model_obat->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no.".";
            $row[] = $item->NamaObat;
            $row[] = $item->SatuanObat;
            $row[] = $item->HargaSatuanObat;
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->model_obat->count_all(),
            "recordsFiltered" => $this->model_obat->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function insertDataObat(){
        $dataObat = [
            'IdObat'            => '',
            'NamaObat'          => $_POST['NamaObat'],
            'SatuanObat'        => $_POST['SatuanObat'],
            'HargaSatuanObat'   => $_POST['HargaSatuanObat']
        ];
        
        $ResultInsert = $this->model_obat->insertObat($dataObat);
        echo ($ResultInsert == 1) ? 'success':'fail';
    }

    function updateDataObat(){
        $IdObat = $_POST['IdObat'];
        $dataObat = [
            'NamaObat'          => $_POST['NamaObat'],
            'SatuanObat'        => $_POST['SatuanObat'],
            'HargaSatuanObat'   => $_POST['HargaSatuanObat']
        ];
        $resultUpdate = $this->model_obat->updateObat($dataObat, $IdObat);
        echo ($resultUpdate == 1) ? 'success':'fail';
    }

    function deleteDataObat(){
        $IdObat = $_POST['IdObat'];
        $resultDelete = $this->model_obat->deleteObat($IdObat);
        echo ($resultDelete == 1) ? 'success':'fail';
    }

    function upload(){
        $this->load->view('upload');
    }

    public function import_excel(){
		$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 
        if(isset($_FILES['fileExcel']['name']) && in_array($_FILES['fileExcel']['type'], $file_mimes)) {
        
            $arr_file = explode('.', $_FILES['fileExcel']['name']);
            $extension = end($arr_file);
        
            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
        
            $spreadsheet = $reader->load($_FILES['fileExcel']['tmp_name']);
            
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            // echo json_encode($sheetData);
            // echo $sheetData[0]['1'];
            for($i = 0;$i<count($sheetData) ;$i++)
            {
                $dataObat = [
                    'IdObat'            => '',
                    'NamaObat'          => $sheetData[$i]['0'],
                    'SatuanObat'        => $sheetData[$i]['1'],
                    'HargaSatuanObat'   => null
                ];
                $insert = $this->model_obat->insertObat($dataObat);
                echo $insert;
            }
        }
	}
}

?>