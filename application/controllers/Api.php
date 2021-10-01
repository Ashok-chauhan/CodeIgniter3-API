<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    public function __construct(){
		parent::__construct();
		$this->load->model('Api_model');

    }
    
    public function index(){

        $response['response'] = $this->Api_model->getContent();
        $json_response = json_encode($response);
        $this->_sendResponse(200, 'application/json', $json_response);  

    }

    public function getdata(){
    	$response = $this->Api_model->getdata('https://prodman.whizti.com/api/category/7471');
    	echo $response; //do whatever needed.

    }


    public function create(){
    	if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$data = file_get_contents("php://input");
			$id = $this->Api_model->createData($data);
				
			echo $id;
			//echo 'posted';
			
		}else{
			$error = json_encode(array("error"=>'Bad Request'));
			$this->_sendResponse(400, 'application/json', $error); 
		}
    }


    public function postdata(){
    	$apiUrl = 'http://localhost/code3/api/create';
    	$postData = array(
    		'title'=>'this is test title from api',
    		'content'=>'this is test content from api'
    	);
    	$postResponse = $this->Api_model->postData($apiUrl, $postData);
    	echo $postResponse;
    }

    protected function _sendResponse($status = 200, $content_type = 'text/html', $body=''){
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        header('Content-type: ' . $content_type.'; charset=UTF-8');
        header('Content-Language: en');
        header('Content-Length: ' . strlen($body));
        
        if($body != '')
        {
            // send the body
            echo $body;
            exit;
        }
        
    
    }


    protected function _getStatusCodeMessage($status){
        
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

}
