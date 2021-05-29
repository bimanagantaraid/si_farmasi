<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class ObatKeluar extends CI_Controller{
        function getObatKeluar(){
            $list = $this->model_obatkeluargudang->get_datatables();
            $data = array();
            $no = @$_POST['start'];
            foreach ($list as $item) {
                $no++;
                $row = array();
                $row[] = $no.".";
                $row[] = $item->NamaObat;
                $row[] = $item->NamaSatelit;
                $row[] = $item->JumlahObatKeluar;
                $data[] = $row;
            }
            $output = array(
                "draw" => @$_POST['draw'],
                "recordsTotal" => $this->model_obatkeluargudang->count_all(),
                "recordsFiltered" => $this->model_obatkeluargudang->count_filtered(),
                "data" => $data,
            );
            echo json_encode($output);
        }
    }

?>