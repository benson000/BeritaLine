<?php
class View extends CI_Controller{
	function __construct(){
		parent::__construct();

		$this->load->helper('url');
		$this->load->model('models');
	}
	
	function index(){
		$table = 'posting';

		//akan ditampilkan dalam menu berita
		$result = $this->models->show_data($table);
		$data = array(
			'data' => $result
		);

		$this->load->view('index_berita', $data); //dashboard pilih berita
	}

	function view_berita($id){
		$table = 'posting';

		$result = $this->models->select_data($table, $id);
		$data = array(
			'data' => $result
		);

		$this->load->view('view_berita', $data);
	}
}
?>