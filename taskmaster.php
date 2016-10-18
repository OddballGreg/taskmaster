#!/usr/bin/php
<?php

require_once("libft_core.php");

if ($argc < 0)
	die ("Please input the name and path of the .yaml file containing your service configurations.\nUsage: ./taskmaster config.yaml\n");
else if ($argc > 2)
	print ("Taskmaster can only make use of one configuration file at a time.\n");
if ($argc == 2)
{
	if ($argv[1] == NULL | !file_exists($argv[1]))
	{
		echo "Error: File does not exist\n";
		exit(0);
	}
	$file = file($argv[1]); //File is read into an array of each line here.

	/*             config file parsing and establishing goes here.                */
}
?>


?>