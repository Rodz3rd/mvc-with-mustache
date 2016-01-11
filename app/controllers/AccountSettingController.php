<?php

class AccountSettingController extends Controller {
	public function __construct() {
		parent::$vars['setting_link'] = "active";
	}

	public function index() {
		$this->view("admin/accountSetting/index");
	}
}