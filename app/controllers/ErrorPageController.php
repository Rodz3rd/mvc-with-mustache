<?php

class ErrorPageController extends Controller {

	public function page404() {
		$this->view('errorPages/page404');
	}
}