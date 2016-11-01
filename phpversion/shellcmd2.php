<?php

function task_restart($input)
{
	$args = explode(" ", $input);
	if (count($args) > 1 && $args[1] != NULL)
	{
		$index = -1;
		while (isset($GLOBALS['processList'][++$index]) == TRUE)
		{
			$process = $GLOBALS['processList'][$index];
			if (strcmp($process->_attribStat['name'], trim($args[1])) == 0)
			{
				echo "<taskmaster/> User requested 'restart' on program/process {$args[1]} .";
				log_message("User requested 'restart' on program/process {$args[1]}");
				$process->restart();
			}
		}
	}
	else
		echo "<taskmaster/> The 'restart' command requires a program name arguement to function.";
}

function task_kill($input)
{
	$args = explode(" ", $input);
	if (count($args) > 1 && $args[1] != NULL)
	{
		$index = -1;
		while (isset($GLOBALS['processList'][++$index]) == TRUE)
		{
			$process = $GLOBALS['processList'][$index];
			if (strcmp($process->_attribStat['name'], trim($args[1])) == 0)
			{
				$process->kill();
				echo "<taskmaster/> User requested 'kill' on program/process {$args[1]}";
				log_message(" User requested 'kill' on program/process {$args[1]}");
			}
		}
	}
	else
		echo "<taskmaster/> The 'kill' command requires a program name arguement to function.";
}

function task_shutdown($input)
{
	$args = explode(" ", $input);
	if (count($args) > 1 && $args[1] != NULL)
	{
		$index = -1;
		while (isset($GLOBALS['processList'][++$index]) == TRUE)
		{
			$process = $GLOBALS['processList'][$index];
			if (strcmp($process->_attribStat['name'], trim($args[1])) == 0)
			{
				$process->shutdown();
				echo "<taskmaster/> User requested 'shutdown' on program {$args[1]}";
				log_message(" User requested 'shutdown' on program {$args[1]}");
			}
		}
	}
	else
		echo "<taskmaster/> The 'shutdown' command requires a program name arguement to function.";
}

function task_edit($input)
{
	$args = explode(" ", $input);
	if (count($args) > 1 && $args[1] != NULL)
	{
		$index = -1;
		while (isset($GLOBALS['processList'][++$index]) == TRUE)
		{
			$process = $GLOBALS['procesList'][$index];
			if (strcmp($process->_attribStat['name'], trim($args[1])) == 0)
			{
				//$process->edit();
				echo "<taskmaster/> You attempted to use the 'edit' command. Unfortunately this command does not yet work.{$args[1]}";
				log_message(" User 'edit'ed process <processid>'s <variablename> to <newvalue> {$args[1]}");
			}
		}
	}
	else
		echo "<taskmaster/> The 'edit' command requires a program name arguement to function.";
}

function task_start($input)
{
	$args = explode(" ", $input);
	if (count($args) > 1 && $args[1] != NULL)
	{
		$index = -1;
		while (isset($GLOBALS['processList'][++$index]) == TRUE)
		{
			$process = $GLOBALS['processList'][$index];
			if (strcmp($process->_attribStat['name'], trim($args[1])) == 0)
			{
				$process->start();
				echo "<taskmaster/> User requested 'start' on program {$args[1]}";
				log_message(" User requested 'start' on program {$args[1]}");
			}
		}
	}
	else
		echo "<taskmaster/> The 'start' command requires a program name arguement to function.";
}
?>