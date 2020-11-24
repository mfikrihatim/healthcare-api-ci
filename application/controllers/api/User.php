<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController
{

    function __construct()
    {
        parent::__construct();
        $this->token = 'Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6ImZhZWE3Y2Q2YWFhYjM1YmIyYmE4MjE3ZTgyNWNkODE5I';
        $this->load->model('MSudi');
    }
    public function index_get()
    {
        $header = $this->input->request_headers();
        if (isset($header['Authorization'])) {
            if ($header['Authorization'] == $this->token) {
                if (isset($_GET['id'])) {
                    $query = $this->MSudi->GetDataWhere2('tbl_user', 'is_active', 1, 'id', $_GET['id'])->result();
                    $this->response([
                        'status' => 200,
                        'message' => 'success',
                        'data' => $query
                    ], 200);
                } else {
                    $query = $this->MSudi->GetDataWhere('tbl_user', 'is_active', 1)->result();
                    $this->response([
                        'status' => 200,
                        'message' => 'success',
                        'data' => $query
                    ], 200);
                }
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

    public function index_post()
    {
        if (isset($_POST['id'])) {
            $result = $this->update();
        } else {
            $header = $this->input->request_headers();
            if (isset($header['Authorization'])) {
                if ($header['Authorization'] == $this->token) {

                    if (isset($_POST['nohp'])) {
                        if ($_POST['nohp'] != null || $_POST['nohp'] != '') {
                            $query = $this->MSudi->GetDataWhere3('tbl_user', 'id_level', $_POST['id_level'], 'nohp', $_POST['nohp'])->result();

                            if (count($query) > 0) {
                                $this->response([
                                    'status' => 400,
                                    'message' => 'Phone number sudah ada',
                                    'data' => []
                                ], 400);
                            }
                        }
                    }
                    if (isset($_POST['email'])) {
                        if ($_POST['email'] != null || $_POST['email'] != '') {
                            $query = $this->MSudi->GetDataWhere3('tbl_user', 'id_level', $_POST['id_level'], 'email', $_POST['email'])->result();

                            if (count($query) > 0) {
                                $this->response([
                                    'status' => 400,
                                    'message' => 'Email number sudah ada',
                                    'data' => []
                                ], 400);
                            }
                        }
                    }
                    if (isset($_POST['username'])) {
                        if ($_POST['username'] != null || $_POST['username'] != '') {
                            $query = $this->MSudi->GetDataWhere3('tbl_user', 'id_level', $_POST['id_level'], 'username', $_POST['username'])->result();

                            if (count($query) > 0) {
                                $this->response([
                                    'status' => 400,
                                    'message' => 'Username sudah ada',
                                    'data' => []
                                ], 400);
                            }
                        }
                    }


                    // Check form submit or not
                    if (isset($_POST['image'])) {
                        $data['filenames'] = $_POST['image'];
                        // array_push( $data['filenames'],$_POST['image']);
                    }
                    if (isset($_FILES['files'])) {

                        $data = array();
                        $data['filenames'] = "";


                        if (!empty($_FILES['files']['name'])) {

                            // Define new $_FILES array - $_FILES['file']
                            $_FILES['file']['name'] = $_FILES['files']['name'];
                            $_FILES['file']['type'] = $_FILES['files']['type'];
                            $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'];
                            $_FILES['file']['error'] = $_FILES['files']['error'];
                            $_FILES['file']['size'] = $_FILES['files']['size'];

                            // Set preference
                            $config['upload_path'] = 'uploads/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif|JPG';
                            // $config['max_size'] = '500000000'; // max_size in kb
                            $config['file_name'] = $_FILES['files']['name'];

                            //Load upload library
                            $this->load->library('upload', $config);

                            try {

                                // File upload
                                if ($this->upload->do_upload('file')) {
                                    // Get data about the file
                                    $uploadData = $this->upload->data();
                                    $filename = site_url('uploads/') . $uploadData['file_name'];
                                    $replcate = str_replace("index.php/", "", $filename);
                                    $filename = $replcate;

                                    $data['filenames'] =  $filename;
                                    // Initialize array
                                    // array_push($data['filenames'], $filename);
                                }
                            }

                            //catch exception
                            catch (Exception $e) {
                                echo 'Message: ' . $e->getMessage();
                            }
                        }
                    }
                    if (isset($_FILES['files'])) {

                        $replcate = str_replace("\/", "/", $data['filenames']);
                        $data['filenames'] = $replcate;
                    } else if (isset($_POST['image'])) {
                    } else {
                        $data['filenames'] = "";
                    }

                    $insert = array(
                        'username' => $this->input->post('username'),
                        'password' => $this->input->post('password'),
                        'fullname' => $this->input->post('fullname'),
                        'id_level' => $this->input->post('id_level'),
                        'nohp' => $this->input->post('nohp'),
                        'email' => $this->input->post('email'),
                        'status' => $this->input->post('status'),
                        'prov_id' => $this->input->post('prov_id'),
                        'city_id' => $this->input->post('city_id'),
                        'dis_id' => $this->input->post('dis_id'),
                        'subdis_id' => $this->input->post('subdis_id'),
                        'postal_id' => $this->input->post('postal_id'),
                        'foto' => $data['filenames'],
                        'alamat_lengkap' => $this->input->post('alamat_lengkap'),
                        'created_by' => $this->input->post('userlogin'),
                        'created_date' => date("Y-m-d H:i:s"),
                        'updated_by' => null,
                        'updated_date' => null,
                        'deleted_by' => null,
                        'deleted_date' => null,
                        'is_active' => 1
                    );

                    $query = $this->MSudi->AddData('tbl_user', $insert);
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
                    'id' => $this->input->post('id'),
                    'username' => $this->input->post('username'),
                    'password' => $this->input->post('password'),
                    'fullname' => $this->input->post('fullname'),
                    'id_level' => $this->input->post('id_level'),
                    'nohp' => $this->input->post('nohp'),
                    'email' => $this->input->post('email'),
                    'status' => $this->input->post('status'),
                    'prov_id' => $this->input->post('prov_id'),
                    'city_id' => $this->input->post('city_id'),
                    'dis_id' => $this->input->post('dis_id'),
                    'subdis_id' => $this->input->post('subdis_id'),
                    'postal_id' => $this->input->post('postal_id'),
                    'alamat_lengkap' => $this->input->post('alamat_lengkap'),
                    'updated_by' => $this->input->post('userlogin'),
                    'updated_date' => date("Y-m-d H:i:s"),

                );

                $query = $this->MSudi->UpdateData('tbl_user', 'id', $update['id'], $update);
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
                    'is_active' => 0,
                    'deleted_by' => $_GET['userlogin'],
                    'deleted_date' => date("Y-m-d H:i:s"),
                    'id' => $_GET['id']
                );

                $query = $this->MSudi->UpdateData('tbl_user', 'id', $delete['id'], $delete);
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
