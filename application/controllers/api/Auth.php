<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Auth extends RestController
{

    function __construct()
    {
        parent::__construct();
        $this->token = 'eyJhbGciOiJSUzI1NiIsImtpZCI6ImZhZWE3Y2Q2YWFhYjM1YmIyYmE4MjE3ZTgyNWNkODE5I';
        $this->load->model('MSudi');
    }
    public function index_get()
    {
        $query = $this->MSudi->GetData('tbl_lap_kerusakan');
        $this->response([
            'result' => $query
        ], 200);
    }

    public function index_post()
    {
        if(isset($_GET['rt'])){
            $userLogin = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'type' => '0'
            );
    
            $query = $this->MSudi->GetDataLogin('tbl_user',
            'username',
            $userLogin['username'],
            'password',
            $userLogin['password'],
            'id_level',
            $userLogin['type']
            )->row();
        }else{
            $userLogin = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'type' => $this->input->post('type')
            );
    
            $query = $this->MSudi->GetDataLogin('tbl_user',
            'username',
            $userLogin['username'],
            'password',
            $userLogin['password'],
            'id_level',
            $userLogin['type']
            )->row();
        }
        
        
        if($query != null){
            $data=new stdClass();
            $data->id = $query->id;
            $data->username = $query->username;
            $data->fullname = $query->fullname;
            $data->id_level = $query->id_level;
            $data->token = $this->token;
            $result = new stdClass();
            $result->status = 200;
            $result->message = 'success';            
            $result->data = $data;
           
            $this->response(
                $result
            , 200); 
        }else{
            $this->response([
                'status' => 401,
                'message' => 'Invalid Username And Password',
                'data' => new stdClass()
            ], 401);    
        }
    }
}
