<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Lintasarta extends RestController
{

    function __construct()
    {
        parent::__construct();
        $this->token = 'Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6ImZhZWE3Y2Q2YWFhYjM1YmIyYmE4MjE3ZTgyNWNkODE5I';
        $this->load->model('MSudi');
    }
    public function index_get()
    {
        if (isset($_GET['id_lintasarta'])) {
            $query = $this->MSudi->GetDataWhere('lintasarta', 'id_lintasarta', $_GET['id_lintasarta'])->result();
            $this->response([
                'status' => 200,
                'message' => 'success',
                'data' => $query
            ], 200);
        } else {
            $query = $this->MSudi->GetData('lintasarta');
            $this->response([
                'status' => 200,
                'message' => 'success',
                'data' => $query
            ], 200);
        }
    }

    public function index_post()
    {
        if (isset($_POST['id_lintasarta'])) {
            $result = $this->update();
        } else {
            $header = $this->input->request_headers();
            if (isset($header['Authorization'])) {
                if ($header['Authorization'] == $this->token) {
                    $insert = array(
                        'judul_lintasarta' => $this->input->post('judul_lintasarta'),
                        'isi_lintasarta' => $this->input->post('isi_lintasarta'),
                        'hyperlink_lintasarta' => $this->input->post('hyperlink_lintasarta'),
                        'video_lintasarta' => $this->input->post('video_lintasarta'),
                    );

                    $query = $this->MSudi->AddData('lintasarta', $insert);
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
                    'id_lintasarta' => $this->input->post('id_lintasarta'),
                    'judul_lintasarta' => $this->input->post('judul_lintasarta'),
                    'isi_lintasarta' => $this->input->post('isi_lintasarta'),
                    'hyperlink_lintasarta' => $this->input->post('hyperlink_lintasarta'),
                    'video_lintasarta' => $this->input->post('video_lintasarta'),
                );

                $query = $this->MSudi->UpdateData('lintasarta', 'id_lintasarta', $update['id_lintasarta'], $update);
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
                    'id_lintasarta' => $_GET['id_lintasarta']
                );

                $query = $this->MSudi->DeleteData('lintasarta', 'id_lintasarta', $delete['id_lintasarta'], $delete);
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
