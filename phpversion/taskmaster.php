#!/usr/bin/php
<?php

/*php error reporting code, remove before submission                               */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*Homebrew convenience library and others required before execution 		       */
require_once("ghlib/libft_core.php");
require_once("logging.php");
require_once("shell.php");

/*Arguement parsing and checking 									    	       */
if ($argc < 2)
	die ("Please input the name and path of the .yaml file containing your service configurations.\nUsage: ./taskmaster config.yaml logfile.txt\n");
if ($argv[1] == NULL | !file_exists($argv[1]))
	die ("Error: The config file passed does not exist.\nUsage: ./taskmaster config.yaml\n");
if (!contains($argv[1], ".yaml"))
	die ("Error: The config file passed is not a .yaml file.\nUsage: ./taskmaster config.yaml\n");
if ($argv[2] != NULL)
	$logfile = $argv[2];
else
	$logfile = "tasklog.txt";

log_message("Taskmaster initiated using the configuration file '{$argv[1]}'.", $logfile);

$file = file($argv[1]); //File is read into an array of each line here.

/*config file parsing and establishing goes here.             <---------           */

/*autostart any processes defined to be started at launch in the config file */

$pid = pcntl_fork();

shell();
?>