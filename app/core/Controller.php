<?php

class Controller extends Mustache {

	protected function model($model) {
		global $APP_DIR; // base app directory

		require_once "$APP_DIR/models/$model" . ".php";

		return new $model;
	}

	protected function view($template, $vars = []) {
		$path="views";
		if ( stripos($template, '/') > 0 ) {
			$path .= "/".substr($template, 0, strrpos($template, '/'));
			$template = substr($template, strrpos($template, '/') + 1);
		}

		$this->initMustache($path, $template, $vars);
		$this->generateView();
	}

	/**
	* 	The methods below are for mustache template
	*/
	protected static $vars;
	protected $template;
	protected $loader;

	private function initMustache($path, $template, $vars) {
		global $APP_DIR, $TMP_EXT;

		$this->initializeVars();
		$this->addVars($vars);
		$this->setTemplate($path, $template);
		$this->loader = new MustacheLoader("$APP_DIR/$path", $TMP_EXT);

	}

	private function initializeVars() {
		global $ASSETS, $PUBLIC_DIR;

		self::$vars['SITE_NAME'] = "Message System";
		self::$vars['NOW'] 		 = DATE('y-m-d');
		self::$vars['PUBLIC']	 = $PUBLIC_DIR;
		self::$vars['ASSETS'] 	 = $ASSETS;
		
	}

	private function addVars($vars) {
		foreach ($vars as $var) {
			self::$vars = array_merge(self::$vars, $var);
		}
	}

	private function setTemplate($path, $template) {
		global $APP_DIR, $TMP_EXT;

		$template = "$APP_DIR/$path/$template.$TMP_EXT";
		if ( is_file( $template ) ) {
			$this->template = $template;
		} else {
			error_log("Error: file is not existed.");
		}
	}

	private function generateView() {
		$template_content = file_get_contents($this->template);

		echo parent::render($template_content, self::$vars, $this->loader);
	}
}