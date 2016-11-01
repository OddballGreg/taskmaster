#!/goinfre/sallen/mamp/php/bin/php
<?php

/*php error reporting code, remove before submission                               */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*Homebrew convenience library and others required before execution 		       */
require_once("utils.php");
require_once("logging.php");
require_once("shell.php");
require_once("shellcmd1.php");
require_once("shellcmd2.php");
require_once("config.php");
require_once("phandling.php");

/*Arguement parsing and checking 									    	       */
if ($argc < 2)
	die ("Please input the name and path of the .yaml file containing your service configurations.\nUsage: ./taskmaster config.yaml logfile.txt\n");
if ($argv[1] == NULL | !file_exists($argv[1]))
	die ("Error: The config file passed does not exist.\nUsage: ./taskmaster config.yaml\n");
if (!contains($argv[1], ".yaml"))
	die ("Error: The config file passed is not a .yaml file.\nUsage: ./taskmaster config.yaml\n");
if ($argc > 2 && $argv[2] != NULL)
	$GLOBALS['logfile'] = $argv[2];
else
	$GLOBALS['logfile'] = "tasklog.txt";

$handle = fopen($argv[1],"r");
$GLOBALS['processList'] = initData($handle);
print_r($GLOBALS['processList']);
log_message("Taskmaster initiated using the configuration file '{$argv[1]}'.");

//$GLOBALS['configName'] = $argv[1];
//$file = file($GLOBALS['configName']); //File is read into an array of each line here.

/*config file parsing and establishing goes here.             <---------           */

/*autostart any processes defined to be started at launch in the config file */

//Init signal handler
pcntl_signal(SIGHUP,  "reconfig");

autostart();
welcome();
shell();
?>