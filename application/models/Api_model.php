<?php
class Api_model extends CI_Model {
    public function __construct()
    {
            $this->load->database();
    }

    public function getContent()
    {
        
        $query = $this->db->query('select id, title, content from content limit 10'); //add table fields , limit whatever you need.
        $data = $query->result_array();
        if($data){
            return $data;
        }
        
    }

    public function createData($postData){
    	$data = json_decode($postData);
    	//print_r($data->title);
    	$dataArray = array(
    		'title'=>$data->title,
    		'content' => $data->content
    	);
    	if($this->db->insert('content', $dataArray)){
    		return $this->db->insert_id();
    	}else{
    		print 'error';
    	}

    }

    public function getData($url, $headers = array()) {
        $ch = curl_init();
       
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => FALSE);
    
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);
    
        return $response;
      }
    
      public function postData($url, $postData) {
        $ch = curl_init();
       
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => json_encode($postData));
            //CURLOPT_POSTFIELDS => http_build_query($postData));
    
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);
    
        return $response;
      }

}