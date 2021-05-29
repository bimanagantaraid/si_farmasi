<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class ObatMasuk extends CI_Controller{
        //homepage obat masuk gudang
        function index(){
            $this->load->view('/obatmasukgudang/index');
        }

        //get data obat masuk to json and datatable
        function getObatMasukGudang(){
            $list = $this->model_obatmasukgudang->get_datatables();
            $data = array();
            $no = @$_POST['start'];
            foreach ($list as $item) {
                $no++;
                $row = array();
                $row[] = $no.".";
                $row[] = $item->NamaObat;
                $row[] = $item->Dinkes;
                $row[] = $item->Blud;
                $row[] = $item->BulanMasuk;
                $row[] = $item->TahunMasuk;
                $data[] = $row;
            }
            $output = array(
                "draw" => @$_POST['draw'],
                "recordsTotal" => $this->model_obatmasukgudang->count_all(),
                "recordsFiltered" => $this->model_obatmasukgudang->count_filtered(),
                "data" => $data,
            );
            echo json_encode($output);
        }

        // generate data obat masuk gudang perbulan selama 1 tahun
        function generateObatMasukGudang(){
            $dataGenerate = [
                'Dinkes'    => $_POST['Dinkes'],
                'Blud'      => $_POST['Blud'],
                'BulanMasuk'=> $_POST['BulanMasuk'],
                'TahunMasuk'=> $_POST['TahunMasuk']
            ];
            $resultGenerate = $this->model_obatmasukgudang->generateOMG($dataGenerate);
            echo ($resultGenerate === true) ? 'success':'fail';
        }

        //tambah data obat masuk gudang
        function insertOMG(){
            $data = [
                'IdObatMasuk'           => '',
                'Dinkes'                => $_POST['Dinkes'],
                'Blud'                  => $_POST['Blud'],
                'BulanMasuk'            => $_POST['BulanMasuk'],
                'TahunMasuk'            => $_POST['TahunMasuk'],
                'IdObat'                => $_POST['IdObat']
            ];
            $resultInsert = $this->model_obatmasukgudang->insertOMG($data);
            if($resultInsert === 'duplicated'){
                echo 'data sudah tersedia, silahkan edit saja';
            }else if($resultInsert === true){
                echo 'success';
            }else{
                echo 'fail';
            }
        }

        //update data obat masuk gudang
        function updateOMG(){
            $whereData = [
                'IdObatMasuk'           => $_POST['IdObatMasuk'],
                'IdObat'                => $_POST['IdObat']
            ];

            $valueData = [
                'Dinkes'                => $_POST['Dinkes'],
                'Blud'                  => $_POST['Blud'],
                'BulanMasuk'            => $_POST['BulanMasuk'],
                'TahunMasuk'            => $_POST['TahunMasuk'],
            ];
            
            $resultUpdate = $this->model_obatmasukgudang->updateOMG($whereData, $valueData);
            if($resultUpdate === true){
                echo 'success';
            }else{
                echo 'fail';
            }
        }

        //delete data obat masuk gudang
        function deleteOMG(){
            $whereData = [
                'IdObatMasuk'           => $_POST['IdObatMasuk']
            ];

            $resultDelete = $this->model_obatmasukgudang->deleteOMG($whereData);
            if($resultDelete === true){
                echo 'success';
            }else{
                echo 'fail';
            }
        }
        
    }


?>