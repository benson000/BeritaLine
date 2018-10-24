<?php 
class Models extends CI_Model{
	//CREATE
	function insert_data($data, $table){
		$this->db->insert($table, $data);
	}

	//READ
	function show_data($table){
		return $this->db->get($table);
	}
	function select_data($table, $id){
		$this->db->select('*');            
        $query = $this->db->get_where(
        	$table, 
        	array(
        		'id' => $id
        	)
        );
        $result = $query->result();

        return $result;
	}

	//UPDATE
	function updateData($where, $data, $table){
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	//DELETE
	public function delete_row($table, $id) {
	    $this->db->delete(
	    	$table, 
	    	array(
	    		'id' => $id
	    	)
	    );
    }
}
?>