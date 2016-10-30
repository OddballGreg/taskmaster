<?php

function log_message($string)
{
	date_default_timezone_set("Africa/Johannesburg");
	file_put_contents($GLOBALS['logfile'], "<" . date(DATE_COOKIE) . ">\t" . $string . PHP_EOL, FILE_APPEND);
}

?>