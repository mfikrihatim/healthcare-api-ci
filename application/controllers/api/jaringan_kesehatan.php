<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class jaringan_kesehatan extends RestController
{

    function __construct()
    {
        parent::__construct();
        $this->token = 'Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6ImZhZWE3Y2Q2YWFhYjM1YmIyYmE4MjE3ZTgyNWNkODE5I';
        $this->load->model('MSudi');
    }
    public function index_get()
    {

        if (isset($_GET['id_jaringan_kesehatan'])) {
            $query = $this->MSudi->GetDataWhere('jaringan_kesehatan', 'id_jaringan_kesehatan', $_GET['id_jaringan_kesehatan'])->result();
            $this->response([
                'status' => 200,
                'message' => 'success',
                'data' => $query
            ], 200);
        } else {
            $query = $this->MSudi->GetData('jaringan_kesehatan');
            $this->response([
                'status' => 200,
                'message' => 'success',
                'data' => $query
            ], 200);
        }
    }

    public function index_post()
    {
        if (isset($_POST['id_jaringan_kesehatan'])) {
            $result = $this->update();
        } else {
            $header = $this->input->request_headers();
            if (isset($header['Authorization'])) {
                if ($header['Authorization'] == $this->token) {
                    $insert = array(
                        'nama_jaringan_kesehatan' => $this->input->post('nama_jaringan_kesehatan'),
                        'langitude_jaringan_kesehatan' => $this->input->post('langitude_jaringan_kesehatan'),
                        'longitude_jaringan_kesehatan' => $this->input->post('longitude_jaringan_kesehatan'),
                        'alamat_jaringan_kesehatan' => $this->input->post('alamat_jaringan_kesehatan'),
                    );

                    $query = $this->MSudi->AddData('jaringan_kesehatan', $insert);
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
                    'id_jaringan_kesehatan' => $this->input->post('id_jaringan_kesehatan'),
                    'nama_jaringan_kesehatan' => $this->input->post('nama_jaringan_kesehatan'),
                    'langitude_jaringan_kesehatan' => $this->input->post('langitude_jaringan_kesehatan'),
                    'longitude_jaringan_kesehatan' => $this->input->post('longitude_jaringan_kesehatan'),
                    'alamat_jaringan_kesehatan' => $this->input->post('alamat_jaringan_kesehatan'),
                );

                $query = $this->MSudi->UpdateData('jaringan_kesehatan', 'id_jaringan_kesehatan', $update['id_jaringan_kesehatan'], $update);
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
                    'id_jaringan_kesehatan' => $_GET['id_jaringan_kesehatan']
                );

                $query = $this->MSudi->DeleteData('jaringan_kesehatan', 'id_jaringan_kesehatan', $delete['id_jaringan_kesehatan'], $delete);
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
