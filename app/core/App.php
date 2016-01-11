<?php

class App {

	protected $controller = "LoginController";
	protected $method = "index";
	protected $params = [];

	public function __construct() {
		global $APP_DIR, $TMP_EXT; // base app directory

		$url = $this->parseUrl();

		# if url is not set
		if ( !isset($url) ) {
			require_once "$APP_DIR/controllers/".$this->controller.".php";

			$this->controller = new $this->controller;
			call_user_func_array([$this->controller, $this->method], $this->params);

			die;
		}
		# end

		# if url is set id=1

		// getting subdirectory
		$controller_subdir = "";
		while (is_dir( "$APP_DIR/controllers/".$controller_subdir . current($url) ) && current($url) != null) {
			$controller_subdir .= current($url) . '/';
			next($url);
		}
		$this->controller = current($url);

		$has_access = false;
		if ( file_exists("$APP_DIR/controllers/". $controller_subdir . $this->controller.".php") ) {
			require_once "$APP_DIR/controllers/". $controller_subdir . $this->controller.".php";
			// echo "file exist";

			if ( class_exists( $this->controller ) && isset($this->controller) ) {
				// echo "class exist";
				$this->controller = new $this->controller;

				next($url); // post method
				
				if ( method_exists( $this->controller, current($url) ) && current($url) != null ) {
					// echo "method exist";
					$this->method = current($url);

					next($url); // post params

					$params = [];
					while ( $param = current($url) ) {
						$params = $param;

						next($url);
					}

					$has_access = true;
				}
			}
		}

		if ( !$has_access ) {
			require_once "$APP_DIR/controllers/ErrorPageController.php";

			$this->controller = new ErrorPageController;
			$this->method 	  = "page404";
		}
		/*
		* 	Render the output by controller and method
		*/
		call_user_func_array([$this->controller, $this->method], $this->params);

		# end id=1
	}

	private function parseUrl() {
		if ( isset($_GET['url']) ) {
			return explode('/', filter_var(rtrim($_GET['url']), FILTER_SANITIZE_URL)); // return parse url
		}
	}	
}