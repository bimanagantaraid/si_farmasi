<?php
    class Model_Obat extends CI_Model{

        var $column_order = array(null, 'NamaObat', 'SatuanObat', 'HargaSatuanObat'); //set column field database for datatable orderable
        var $column_search = array('NamaObat', 'SatuanObat'); //set column field database for datatable searchable
        var $order = array('IdObat' => 'asc'); // default order 
    
        private function _get_datatables_query() {
            $this->db->from('obat');
            $i = 0;
            foreach ($this->column_search as $item) { // loop column 
                if(@$_POST['search']['value']) { // if datatable send POST for search
                    if($i===0) { // first loop
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                    if(count($this->column_search) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }
            
            if(isset($_POST['order'])) { // here order processing
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
            $this->db->from('obat');
            return $this->db->count_all_results();
        }

        function insertObat($DataObat){
            $this->db->insert('obat', $DataObat);
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        function updateObat($DataObat, $IdObat){
            $this->db->where('IdObat', $IdObat);
            $this->db->update('obat', $DataObat);
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        function deleteObat($IdObat){
            $this->db->where('IdObat', $IdObat);
            $this->db->delete('obat');
            return ($this->db->affected_rows() > 0 ) ? true:false;
        }
    }
    
?>