<?php

function task_status()
{
	$index = -1;
	while (isset($GLOBALS['processList'][++$index]) == TRUE)
		$GLOBALS['processList'][$index]->status(TRUE);
}

function task_exit($input)
{
	if (strncmp($input, "exit -f", 7) == 0)
	{
		echo "<taskmaster/> Force Exiting Taskmaster. Processes may have been orphaned.\n";
		log_message("Taskmaster force shut down by the user. Processes potentially orphaned\n");
		die ();
	}
	else if (online_check() != FALSE)
	{
		echo "<taskmaster/> Exiting Taskmaster now may orphan processes.\n";
		echo "Please shut them down or type 'exit -f' to force exit\n";
		return (TRUE);
	}
	else if (online_check() == FALSE)
	{
		echo "<taskmaster/> Exiting Taskmaster. Have a nice day.\n";
		log_message("Taskmaster shut down by the user.\n");
		die ();
	}
	
	return (FALSE);
}

function online_check()
{
	$return = FALSE;
	$index = -1;
	while (isset($GLOBALS['processList'][++$index]) == TRUE)
	{
		$status = $GLOBALS['processList'][$index]->status(FALSE);
		if ($status == TRUE)
			$return = TRUE;
	}
	return ($return);
}

function task_reconfig()
{
	echo "<taskmaster/> Re-parsing Taskmaster Services from {$GLOBALS['configName']}\n";
	log_message(" User requested services 'Reconfig'");
	posix_kill(getmypid(), SIGHUP);
}

function task_help()
{
	echo "Welcome to Taskmaster by ghavenga and sallen.\n";
	echo "Taskmaster is a WTC_ project aimed at handling the running of ";
	echo "processes and programs according to the .yaml file given as an arguement.\n";
	echo "The following commands are available to you:\n";
	echo "Help\nStatus\nKill\nShutdown\nRestart\nReconfig\nStart\nExit\n";
	echo "Note: The commands require that you input the name of the program as sensitively as an arguement or they will not function.\n";
}
?>