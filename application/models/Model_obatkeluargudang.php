<?php

    class model_obatkeluargudang extends CI_Model{
        var $column_order = array(null, 'obat.NamaObat', 'obatkeluargudang.JumlahObatKeluar', 'satelit.NamaSatelit'); 
        var $column_search = array('obat.NamaObat', 'satelit.NamaSatelit'); 
        var $order = array('obatkeluargudang.IdObatKeluar' => 'asc'); 
    
        private function _get_datatables_query() {
            $this->db->select('obat.NamaObat, satelit.NamaSatelit, obatkeluargudang.*');
            $this->db->from('obatkeluargudang');
            $this->db->join('satelit', 'satelit.IdSatelit=obatkeluargudang.IdSatelit');
            $this->db->join('obat', 'obat.IdObat=obatkeluargudang.IdObat');
            $this->db->where('obatkeluargudang.BulanObatKeluar', 'Januari');
            $this->db->where('obatkeluargudang.TahunObatKeluar', 2021);
            $this->db->where('satelit.IdSatelit', 'SatA');
            $i = 0;
            foreach ($this->column_search as $item) {
                if(@$_POST['search']['value']) { 
                    if($i===0) {
                        $this->db->group_start();
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                    if(count($this->column_search) - 1 == $i) 
                        $this->db->group_end();
                }
                $i++;
            }
            
            if(isset($_POST['order'])) { 
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }  else if(isset($this->order)) {
                $order = $this->order;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
        function get_datatables() {
            $this->_get_datatables_query();
            if(@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
        function count_filtered() {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
        function count_all() {
            $this->db->from('obatkeluargudang');
            return $this->db->count_all_results();
        }
    }

    function generateObatKeluarGudang(){
        $generateOKG = $this->model_obatkeluargudang->generateOKG();
    }

?>