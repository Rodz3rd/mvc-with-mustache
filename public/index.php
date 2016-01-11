<?php
$ROOT_DIR   = dirname( dirname(__FILE__) );

$APP_DIR 	= $ROOT_DIR."/app";
$VENDOR_DIR = $ROOT_DIR."/vendor";


$PUBLIC_DIR	= strstr(str_replace('\\', '/', $ROOT_DIR), 'rodrigo');
$PUBLIC_DIR = "/$PUBLIC_DIR/public";

$ASSETS		= strstr(str_replace('\\', '/', $ROOT_DIR), 'rodrigo');
$ASSETS     = "/$ASSETS/public/assets";

$TMP_EXT 	= "html";


// Mustache Template
require_once "$VENDOR_DIR/mustache/Mustache.php";
require_once "$VENDOR_DIR/mustache/MustacheLoader.php";


// Application initialize
require_once "$APP_DIR/init.php";
$app = new App;