<?php
class Input extends CI_Controller{
	public $channelAccessToken = '6ES9a2Db5ADmE63Eu5ntGsfse8naMUR67MSJMM95kUHMpQw7PITgJo5IzayEQaw38HfybQn6txyfTIH9Ax3U/2TzdFk8X7q/lxAO8fBSNBJW4D3Hm+3KztROvFWGXYoe44HJXI422T2ucBdgxGcCrAdB04t89/1O/w1cDnyilFU=';

	public function __construct(){
		parent::__construct();

		$this->load->helper(array('form', 'url'));

		$this->load->model('models');
	}
	
	public function index(){
		$data = array(
			'status' => '' //status input
		);

		$this->load->view('input_berita', $data);
	}

	public function bot($berita){
		$dbFilePath = 'line-db.json'; // user info database file path

		if (!file_exists($dbFilePath)) {
		   file_put_contents($dbFilePath, json_encode(['user' => []]));
		}
		$db = json_decode(file_get_contents($dbFilePath), true);

		$bodyMsg = file_get_contents('php://input');

		file_put_contents('log.txt', date('Y-m-d H:i:s') . 'Recive: ' . $bodyMsg);

		$obj = json_decode($bodyMsg, true);

		file_put_contents('log.txt', print_r($db, true));

		foreach ($obj['events'] as &$event) {

		   $userId = $event['source']['userId'];

		   if (!isset($db['user'][$userId])) {
		           $db['user'][$userId] = [
		               'userId' => $userId,
		               'timestamp' => $event['timestamp']
		           ];
		           file_put_contents($dbFilePath, json_encode($db));
		           $message = $berita;
		   }

		   // Make payload
		   $payload = [
		       'replyToken' => $event['replyToken'],
		       'messages' => [
		           [
		               'type' => 'text',
		               'text' => $message
		           ]
		       ]
		   ];

		   // Send reply API
		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/message/reply');
		   curl_setopt($ch, CURLOPT_POST, true);
		   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		   curl_setopt($ch, CURLOPT_HTTPHEADER, [
		       'Content-Type: application/json',
		       'Authorization: Bearer ' . $this->channelAccessToken
		   ]);
		   $result = curl_exec($ch);
		   curl_close($ch);
		}
	}

	public function push($berita){
		$userIds = []; 
		 
		$url = null; 
		$invalidurl = false; 
		if(@simplexml_load_file($url)){ 
		    $feeds = null; 
		}else{ 
		    $invalidurl = true; 
		    $balas = "Invalid RSS feed URL"; 
		} 
		 
		$i = 0; 
		if(!empty($feeds)){ 
		    $site = $feeds->channel->title; 
		    $sitelink = $feeds->channel->link; 
		 
		    $balas = $berita; 
		    foreach ($feeds->channel->item as $item) { 
		        $title = $item->title; 
		        $link = $item->link; 
		        $description = $item->description; 
		        $postDate = $item->pubDate; 
		        $pubDate = date('D, d M Y',strtotime($postDate)); 
		 
		        if($i>=5) break; 
		                 
		            $balas .= "<a href='$link'>$title</a></h2>"; 
		            $balas .= "<span>$pubDate</span>"; 
		            $balas .= "<div>"; 
		            $balas .= implode(' ', array_slice(explode(' ', $description), 0, 20)) . "...";  
		            $balas .= "<a href='$link'>Read more</a>"; 
		            $balas .= "</div>"; 
		            $i++; 
		    } 
		         
		}else{ 
		    $balas = "<b>Berita baru sayangku :* </b> kamu harus cobain nih, artikel yang gak berguna shitpost yang cuman bikin kamu emosi dan jomblo selamanya (shiny)"; 
		} 
		 
		$message = $balas; 
		$dbFilePath = __DIR__ . '/line-db.json';  // user info database file path 
		 
		// open json database 
		if (!file_exists($dbFilePath)) { 
		   file_put_contents($dbFilePath, json_encode(['user' => []])); 
		} 
		$db = json_decode(file_get_contents($dbFilePath), true); 
		 
		if (count($db['user']) === 0) { 
		   echo 'No user login.'; 

		   exit(1); 
		} else { 
		   foreach ($db['user'] as &$userInfo) { 
		       $userIds[] = $userInfo['userId']; 
		   } 
		} 
		 
		// make payload 
		$payload = [ 
		   'to' => $userIds, 
		   'messages' => [ 
		       [ 
		           'type' => 'text', 
		           'text' => $message 
		       ] 
		   ] 
		]; 
		 
		// Send Request by CURL 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/message/multicast'); 
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload)); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, [ 
		   'Content-Type: application/json', 
		   'Authorization: Bearer ' . $this->channelAccessToken 
		]); 
		$result = curl_exec($ch); 
		curl_close($ch); 
	}

	public function execute(){
		$path_foto = '../berita/uploaded_files/';

		$config['upload_path'] = $path_foto;
		$config['source_image'] = $path_foto.
		$config['allowed_types'] = 'jpg|png|gif|doc|docx|pdf';
		$config['max_size'] = 10000;
		$config['max_width'] = 4024;
		$config['max_height'] = 4000;

		$this->load->library('upload', $config);

		$this->upload->initialize($config);

		if(!$this->upload->do_upload('upload')){ //not uploading
			$error = array('status' => $this->upload->display_errors());

			$this->load->view('input_berita', $error);
		}else{
			$data = array('upload_data' => $this->upload->data());

			$table = 'posting';

			$judul = $this->input->post('judul');

			$berita_lengkap = $this->input->post('berita_lengkap');
			$berita_singkat = substr(
				$berita_lengkap, //substring from here 
				0, //starts from char number ...
				50 //quantity of char taken
			);

			$file_info = $this->upload->data();
			$file_name = $file_info['file_name'];

			$path_foto = $path_foto.$this->upload->data('file_name');

			$date_created = date('Y-m-d G:i:s');

			$data = array(
				'judul' => $judul,
				'berita_singkat' => $berita_singkat,
				'berita_lengkap' => $berita_lengkap,
				'path_foto' => $path_foto,
				'date_created' => $date_created
			);

			//push to line
			//$this->push($berita_lengkap);

			//execute input to database
			$this->models->insert_data($data, $table);

			$status = array(
				'status' => 'Posting berita sukses!'.$file_name
			);

			$this->load->view('input_berita', $status);
		}
	}
}
?>