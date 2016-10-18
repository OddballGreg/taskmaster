#!/usr/bin/php
<?php

/*php error reporting code, remove before submission                               */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*Homebrew convenience library and others required before execution 		       */
require_once("ghlib/libft_core.php");
require_once("logging.php");
require_once("management.php");
require_once("shell.php");

/*Arguement parsing and checking 									    	       */
if ($argc < 2)
	die ("Please input the name and path of the .yaml file containing your service configurations.\nUsage: ./taskmaster config.yaml\n");
else if ($argc > 2)
	die ("Taskmaster can only make use of one configuration file at a time.\nUsage: ./taskmaster config.yaml\n");
if ($argv[1] == NULL | !file_exists($argv[1]))
	die ("Error: The config file passed does not exist.\nUsage: ./taskmaster config.yaml\n");
if (!contains($argv[1], ".yaml"))
	die ("Error: The config file passed is not a .yaml file.\nUsage: ./taskmaster config.yaml\n");

$logfile = "tasklog.txt";

log_message("Taskmaster initiated using the configuration file '{$argv[1]}'.", $logfile);

$file = file($argv[1]); //File is read into an array of each line here.

/*config file parsing and establishing goes here.             <---------           */

/*autostart any processes defined to be started at launch in the config file */

stream_set_blocking (STDIN, 0);
$exit = FALSE;
$confirm = FALSE;
echo "Taskmaster Initiated. Service Status Summary:" . PHP_EOL . task_status() . PHP_EOL . "> ";
while ($exit != TRUE)
{

	if (($input = fgets(STDIN)) != NULL)
	{
		if (strcmp($input, "exit") == 1 || $confirm == TRUE)
			$confirm = task_exit($confirm, $logfile);
		else
			echo ("Command Not Found" . PHP_EOL);
		echo("> ");
	}
}
?>