<?php

function task_restart($input)
{
	$args = explode(" ", $input);
	if (count($args) > 1 && $args[1] != NULL)
	{
		$index = -1;
		while ($GLOBALS['processes'][++$index] != NULL)
		{
			$process = $GLOBALS['processes'][$index];
			if (strcmp($process->name, $args[1]) == 0)
			{
				echo "<taskmaster/> User requested 'restart' on program/process {$args[1]} .\n";
				log_message("User requested 'restart' on program/process {$args[1]}\n");
				$process->restart();
			}
		}
	}
	else
		echo "<taskmaster/> The 'restart' command requires a program name arguement to function." . PHP_EOL;
}

function task_kill($input)
{
	$args = explode(" ", $input);
	if (count($args) > 1 && $args[1] != NULL)
	{
		$index = -1;
		while ($GLOBALS['processes'][++$index] != NULL)
		{
			$process = $GLOBALS['processes'][$index];
			if (strcmp($process->name, $args[1]) == 0)
			{
				$process->kill();
				echo "<taskmaster/> User requested 'kill' on program/process {$args[1]}\n";
				log_message(" User requested 'kill' on program/process {$args[1]}\n");
			}
		}
	}
	else
		echo "<taskmaster/> The 'kill' command requires a program name arguement to function.\n";
}

function task_shutdown($input)
{
	$args = explode(" ", $input);
	if (count($args) > 1 && $args[1] != NULL)
	{
		$index = -1;
		while ($GLOBALS['processes'][++$index] != NULL)
		{
			$process = $GLOBALS['processes'][$index];
			if (strcmp($process->name, $args[1]) == 0)
			{
				$process->shutdown();
				echo "<taskmaster/> User requested 'shutdown' on program/process {$args[1]}\n";
				log_message(" User requested 'shutdown' on program/process {$args[1]}\n");
			}
		}
	}
	else
		echo "<taskmaster/> The 'shutdown' command requires a program name arguement to function.\n";
}

function task_edit($input)
{
	$args = explode(" ", $input);
	if (count($args) > 1 && $args[1] != NULL)
	{
		$index = -1;
		while ($GLOBALS['processes'][++$index] != NULL)
		{
			$process = $GLOBALS['processes'][$index];
			if (strcmp($process->name, $args[1]) == 0)
			{
				//$process->edit();
				echo "<taskmaster/> You attempted to use the 'edit' command. Unfortunately this command does not yet work.{$args[1]}\n";
				log_message(" User 'edit'ed process <processid>'s <variablename> to <newvalue> {$args[1]}\n");
			}
		}
	}
	else
		echo "<taskmaster/> The 'edit' command requires a program name arguement to function.\n";
}

function task_start($input)
{
	$args = explode(" ", $input);
	if (count($args) > 1 && $args[1] != NULL)
	{
		$index = -1;
		while ($GLOBALS['processes'][++$index] != NULL)
		{
			$process = $GLOBALS['processes'][$index];
			if (strcmp($process->name, $args[1]) == 0)
			{
				$process->start();
				echo "<taskmaster/> User requested 'start' on program/process {$args[1]}\n";
				log_message(" User requested 'start' on program/process {$args[1]}\n");
			}
		}
	}
	else
		echo "<taskmaster/> The 'start' command requires a program name arguement to function.\n";
}
?>