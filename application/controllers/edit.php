<?php
class Edit extends CI_Controller{
	function __construct(){
		parent::__construct();

		$this->load->helper('url');
		$this->load->model('models');
	}
	
	function index($id){
		//fetch to input box
		$table = 'berita';
		$result = $this->models->select_data($table, $id);

		//to be transferred
		$data = array(
			'id' => $result[0]['id'],
			'judul' => $result[0]['judul'],
			'berita_lengkap' => $result[0]['berita_lengkap'],
			'path_foto' => $result[0]['path_foto'],
		);

		$this->load->view('edit_berita', $data);
	}

	function execute(){
		$table = 'posting';

		//where
		$id = $this->input->post('id');
		$where = array(
			'id' => $id
		);

		//data
		$judul = $this->input->post('judul');
		$berita_lengkap = $this->input->post('berita_lengkap');
		$berita_singkat = substr(
			$berita_lengkap, //substring from here 
			0, //starts from char number ...
			50 //quantity of char taken
		);
		$path_foto = $this->input->post('path_foto');

		$data = array(
			'judul' => $judul,
			'berita_singkat' => $berita_singkat,
			'berita_lengkap' => $berita_lengkap,
			'path_foto' => $path_foto,
		);

		//execute input to database
		$this->models->updateData($where, $data, $table);

		$this->load->view('view_berita/'.$id);
	}

	function delete($id){
		$table = 'posting';

		$this->models->delete_row($table, $id);
		$this->load->view('index_berita');
	}
}
?>