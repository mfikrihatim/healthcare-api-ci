<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class konsultasi extends RestController
{

    function __construct()
    {
        parent::__construct();
        $this->token = 'Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6ImZhZWE3Y2Q2YWFhYjM1YmIyYmE4MjE3ZTgyNWNkODE5I';
        $this->load->model('MSudi');
    }
    public function index_get()
    {

        if (isset($_GET['id_konsultasi'])) {
            $query = $this->MSudi->GetDataWhere('konsultasi', 'id_konsultasi', $_GET['id_konsultasi'])->result();
            $this->response([
                'status' => 200,
                'message' => 'success',
                'data' => $query
            ], 200);
        } else {
            $query = $this->MSudi->GetData('konsultasi');
            $this->response([
                'status' => 200,
                'message' => 'success',
                'data' => $query
            ], 200);
        }
    }

    public function index_post()
    {
        if (isset($_POST['id_konsultasi'])) {
            $result = $this->update();
        } else {
            $header = $this->input->request_headers();
            if (isset($header['Authorization'])) {
                if ($header['Authorization'] == $this->token) {
                    $insert = array(
                        'nama_konsultasi' => $this->input->post('nama_konsultasi'),
                        'perusahaan_konsultasi' => $this->input->post('perusahaan_konsultasi'),
                        'posisi_konsultasi' => $this->input->post('posisi_konsultasi'),
                        'email_konsultasi' => $this->input->post('email_konsultasi'),
                        'telp_konsultasi' => $this->input->post('telp_konsultasi'),
                        'pertanyaan_konsultasi' => $this->input->post('pertanyaan_konsultasi'),

                    );

                    $query = $this->MSudi->AddData('konsultasi', $insert);
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
                    'id_konsultasi' => $this->input->post('id_konsultasi'),
                    'nama_konsultasi' => $this->input->post('nama_konsultasi'),
                    'perusahaan_konsultasi' => $this->input->post('perusahaan_konsultasi'),
                    'posisi_konsultasi' => $this->input->post('posisi_konsultasi'),
                    'email_konsultasi' => $this->input->post('email_konsultasi'),
                    'telp_konsultasi' => $this->input->post('telp_konsultasi'),
                    'pertanyaan_konsultasi' => $this->input->post('pertanyaan_konsultasi'),
                );

                $query = $this->MSudi->UpdateData('konsultasi', 'id_konsultasi', $update['id_konsultasi'], $update);
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
                    'id_konsultasi' => $_GET['id_konsultasi']
                );

                $query = $this->MSudi->DeleteData('konsultasi', 'id_konsultasi', $delete['id_konsultasi'], $delete);
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
