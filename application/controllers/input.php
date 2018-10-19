<?php
class Input extends CI_Controller{
	function __construct(){
		parent::__construct();

		$this->load->helper('url');
		$this->load->model('models');
	}
	
	function index(){
		$data = array(
			'status' => '' //status input
		);

		$this->load->view('input_berita', $data);
	}

	function execute(){
		$table = 'posting';

		$judul = $this->input->post('judul');

		$berita_lengkap = $this->input->post('berita_lengkap');
		$berita_singkat = substr(
			$berita_lengkap, //substring from here 
			0, //starts from char number ...
			50 //quantity of char taken
		);

		$path_foto = $this->input->post('path_foto');
		$date_created = $this->input->post('date_created');

		$data = array(
			'judul' => $judul,
			'berita_singkat' => $berita_singkat,
			'berita_lengkap' => $berita_lengkap,
			'path_foto' => $path_foto,
			'date_created' => $date_created
		);

		//execute input to database
		$this->models->insert_data($data, $table);

		$status = array(
			'status' => 'Posting berita sukses!'
		);

		$this->load->view('input_berita', $status);
	}
}
?>