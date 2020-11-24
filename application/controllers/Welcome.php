<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Welcome extends RestController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('MSudi');
	}
	public function index_get()
	{
		// $query = $this->MSudi->GetData('tbl_pembayaran');
		// $this->response([
		// 	'result' => $query
		// ], 200);
	}
}
