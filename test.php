<?php

$var = [1,2];

next($var);next($var);

while ( $val = current($var) ) {
	echo $val;
	
	next($var);
}