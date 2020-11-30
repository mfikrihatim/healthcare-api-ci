<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Contact extends RestController
{

    function __construct()
    {
        parent::__construct();
        $this->token = 'Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6ImZhZWE3Y2Q2YWFhYjM1YmIyYmE4MjE3ZTgyNWNkODE5I';
        $this->load->model('MSudi');
    }
    public function index_get()
    {

        if (isset($_GET['id_kontak'])) {
            $query = $this->MSudi->GetDataWhere('kontak', 'id_kontak', $_GET['id_kontak'])->result();
            $this->response([
                'status' => 200,
                'message' => 'success',
                'data' => $query
            ], 200);
        } else {
            $query = $this->MSudi->GetData('kontak');
            $this->response([
                'status' => 200,
                'message' => 'success',
                'data' => $query
            ], 200);
        }
    }

    public function index_post()
    {
        if (isset($_POST['id_kontak'])) {
            $result = $this->update();
        } else {
            $header = $this->input->request_headers();
            if (isset($header['Authorization'])) {
                if ($header['Authorization'] == $this->token) {
                    $insert = array(
                        'whatsapp_kontak' => $this->input->post('whatsapp_kontak'),
                        'phone_kontak' => $this->input->post('phone_kontak'),
                        'instagram_kontak' => $this->input->post('instagram_kontak'),
                        'twitter_kontak' => $this->input->post('twitter_kontak'),
                        'email_kontak' => $this->input->post('email_kontak'),
                        'alamat_kontak' => $this->input->post('alamat_kontak')



                    );

                    $query = $this->MSudi->AddData('kontak', $insert);
                    $this->response([
                        'status' => 200,
                        'message' => 'success',
                        'data' => $query
                    ], 200);
                } else {
                    $this->response([
                        'status' => 401,
                        'message' => 'UnAuthorize',
                        'data' => []
                    ], 401);
                }
            } else {
                $this->response([
                    'status' => 401,
                    'message' => 'UnAuthorize',
                    'data' => []
                ], 401);
            }
        }
    }
    public function update()
    {
        $header = $this->input->request_headers();
        if (isset($header['Authorization'])) {
            if ($header['Authorization'] == $this->token) {



                $update = array(
                    'id_kontak' => $this->input->post('id_kontak'),
                    'whatsapp_kontak' => $this->input->post('whatsapp_kontak'),
                    'phone_kontak' => $this->input->post('phone_kontak'),
                    'instagram_kontak' => $this->input->post('instagram_kontak'),
                    'twitter_kontak' => $this->input->post('twitter_kontak'),
                    'email_kontak' => $this->input->post('email_kontak'),
                    'alamat_kontak' => $this->input->post('alamat_kontak')

                );

                $query = $this->MSudi->UpdateData('kontak', 'id_kontak', $update['id_kontak'], $update);
                $this->response([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $query
                ], 200);
            } else {
                $this->response([
                    'status' => 401,
                    'message' => 'UnAuthorize',
                    'data' => []
                ], 401);
            }
        } else {
            $this->response([
                'status' => 401,
                'message' => 'UnAuthorize',
                'data' => []
            ], 401);
        }
    }
    public function index_delete()
    {
        $header = $this->input->request_headers();
        if (isset($header['Authorization'])) {
            if ($header['Authorization'] == $this->token) {
                $delete = array(
                    'id_kontak' => $_GET['id_kontak']
                );

                $query = $this->MSudi->DeleteData('kontak', 'id_kontak', $delete['id_kontak'], $delete);
                $this->response([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $query
                ], 200);
            } else {
                $this->response([
                    'status' => 401,
                    'message' => 'UnAuthorize',
                    'data' => []
                ], 401);
            }
        } else {
            $this->response([
                'status' => 401,
                'message' => 'UnAuthorize',
                'data' => []
            ], 401);
        }
    }
}
