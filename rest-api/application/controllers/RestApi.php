<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RestApi extends CI_Controller {
	public $json_data = array();
	//constructor
	public function __construct(){
		parent::__construct();
		$text = file_get_contents('data/rawdata.rtf');
		
		$text = substr_replace($text,'',0,stripos($text,'\cf0')+4);
		
		$text = str_replace('\{','{',$text);
		$text = str_replace('\}','}',$text);
		$text = str_replace('\"','&#34;',$text);
		$text = str_replace('\f1','',$text);
		$text = str_replace('\uc0\u65533','',$text);
		$text = str_replace('\u65533','',$text);
		$text = str_replace('\f0 ','&#39;',$text);
		$text = str_replace('\'','&#39;',$text);
		$text = str_replace("'","",$text);
		$text = str_replace('\\n','',$text);
		$text = str_replace('\\','',$text);
		$text = str_replace('\\','',$text);
		$text = str_replace('cell-image','cellImage',$text);
		$text = str_replace('channel-subscription-status','channelSubscriptionStatus',$text);
		$text = str_replace('default-image','defaultImage',$text);
		$text = str_replace('logo-image','logoImage',$text);
		$text = str_replace('template-image','templateImage',$text);
		
		
		$text = trim(preg_replace('/\s\s+/', ' ', $text));
		
		$text = substr_replace($text,'',strripos($text,'}'),strlen($text));
		$this->json_data =(array) json_decode($text);
		//print_r($json_data);

	}
	public function index(){
	}
	//read function with pagination
	public function readAll(){
		$return_data = array();
		
		for($i=0; $i<count($this->json_data); $i++){
				
			array_push($return_data,$this->json_data[$i]); 
				
		}
		
		echo json_encode($return_data);
	}
	
	//read function with pagination
	public function read($start, $end = null){
		$return_data = array();
		if($end == null){
			//print_r($this->json_data);
			for($i=0; $i<$start; $i++){
				array_push($return_data,$this->json_data[$i]); 
			}
		}
		else{
			for($i=$start; $i<$end; $i++){
				if(! isset($this->json_data[$i])){
				}
				else{
					array_push($return_data,$this->json_data[$i]); 
				}
			}
		}
		echo json_encode($return_data);
	}
	
	//get total count of videos
	public function totalVideos(){
		$return_data = array("total"=>count($this->json_data));
		
		echo json_encode($return_data);
	}
	
	
	//read the particular video by passing video id
	public function readVideo($id){
		$return_data = array();
		for($i=0; $i<count($this->json_data); $i++){
		
			if($this->json_data[$i]->id == $id){
				array_push($return_data,$this->json_data[$i]); 
				break;
			}
		}
		
		echo json_encode($return_data);
	}

	//search for particular character 
	public function searchVideo($needle){
		$return_data = array();
		for($i=0; $i<count($this->json_data); $i++){
		
			if(!strpos($this->json_data[$i]->title, $needle)){
				array_push($return_data,$this->json_data[$i]); 
				
			}
		}
		
		echo json_encode($return_data);
	}
		
}

