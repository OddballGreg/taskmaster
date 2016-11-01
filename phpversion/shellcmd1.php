<?php

function task_status($verbose)
{
	if ($verbose = TRUE)
	{
		$index = -1;
		$result = FALSE;
		//while ($GLOBALS['processes'][++$index] != NULL)
			//$result = $GLOBALS['processes'][$index]->status(FALSE);
			if ($result == TRUE)
				return (TRUE);
		return (FALSE);
	}
	else
	{
		$index = -1;
		//while ($GLOBALS['processes'][++$index] != NULL)
			//$GLOBALS['processes'][$index]->status(TRUE);
		return (FALSE);
	}

	echo "TM > ";
}

function task_exit($input)
{
	if (task_status(FALSE) != FALSE)
	{
		echo "TM > Exiting Taskmaster now may orphan processes.\n";
		echo "Please shut them down or type 'exit -f' to force exit\nTM > ";
		return (TRUE);
	}
	else if (task_status(FALSE) == FALSE)
	{
		echo "TM > Exiting Taskmaster. Have a nice day.\n";
		log_message("Taskmaster shut down by the user.\n");
		die ();
	}
	else if (strncmp($input, "exit -f", 7) == 0)
	{
		echo "TM > Force Exiting Taskmaster. Processes may have been orphaned.\n";
		log_message("Taskmaster force shut down by the user. Processes potentially orphaned\n");
		die ();
	}
	return (FALSE);
}

function task_reconfig()
{
	echo "TM > Re-parsing Taskmaster Services from {$GLOBALS['configName']}\n";
	log_message(" User requested services 'Reconfig'\n");
	posix_kill(getmypid(), SIGHUP);
	echo "TM > ";
}

function task_help()
{
	echo "Welcome to Taskmaster by ghavenga and sallen.\n";
	echo "Taskmaster is a WTC_ project aimed at handling the running of ";
	echo "processes and programs according to the .yaml file given as an arguement.\n";
	echo "The following commands are available to you:\n";
	echo "Help\nStatus\nKill\nShutdown\nRestart\nReconfig\nStart\nExit\n";
	echo "Note: The commands require that you input exactly the process ID as an arguement or they will not function.\n";
	echo "TM > ";
}
?>