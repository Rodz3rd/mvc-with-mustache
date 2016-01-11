<?php

class UsersController extends Controller {
	public function __construct() {
		parent::$vars['user_link'] = "active";
	}

	public function index() {
		$data = ['data'=> [ 
							['key' => 1],['key' => 2],['key' => 3],['key' => 4],['key' => 5],['key' => 6],['key' => 7],['key' => 8],['key' => 9],['key' => 10],
							['key' => 11],['key' => 12],['key' => 13],['key' => 14],['key' => 15],['key' => 16],
							['key' => 1],['key' => 2],['key' => 3],['key' => 4],['key' => 5],['key' => 6],['key' => 7],['key' => 8],['key' => 9],['key' => 10],
							['key' => 11],['key' => 12],['key' => 13],['key' => 14],['key' => 15],['key' => 16]
						  ]
				];

		// pagination
		$pag_num = ceil(count($data['data']) / 15);
		for ($i = 1; $i <= $pag_num; $i++) {
			$pagination[] = ['num' => $i];
		}
		$pagination[0]['active'] = "class='active'";

		$this->view("admin/users/index", [
												$data,
												['pagination'=>$pagination],
											]);
	}
}