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
			'judul' => $result['judul'],
			'berita_singkat' => $result['berita_singkat'],
			'path_foto' => $result['path_foto']
		);

		$this->load->view('index_berita', $data); //dashboard pilih berita
	}

	function view_berita($id){
		$table = 'posting';

		$result = $this->model->select_data($table, $id);
		$data = array(
			'judul' => $result[0]['judul'],
			'path_foto' => $result[0]['path_foto'],
			'berita_lengkap' => $result[0]['berita_lengkap'],
			'date_created' => $result[0]['date_created'],
			'last_edited' => $result[0]['last_edited'],
		);

		$this->load->view('view_berita', $data);
	}
}
?>