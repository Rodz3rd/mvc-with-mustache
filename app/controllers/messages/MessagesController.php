<?php

abstract class MessagesController extends Controller {
	public function __construct() {
		parent::$vars['message_link'] = "active";
	}
	
	abstract public function index();
	abstract public function viewMessage($id);
	abstract public function deleteMessage($id);

	// public function composed($id, $message) {}
}