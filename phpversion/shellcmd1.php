<?php

function task_status($verbose)
{
	$index = -1;
	while ($GLOBALS['processes'][++$index] != NULL)
		$GLOBALS['processes'][index].status(TRUE);
	echo "TM > ";
}

function task_exit($input)
{
	if (task_status("On") != FALSE)
	{
		echo "TM > Exiting Taskmaster now would orphan the following functions: \n";
		task_status(TRUE);
		echo "\nPlease shut them down or type 'exit -f' to force exit\nTM > ";
		return (TRUE);
	}
	else if (task_status("On") == FALSE)
	{
		echo "TM > Exiting Taskmaster. Have a nice day.\n";
		log_message("Taskmaster shut down by the user.\n");
		die ();
	}
	else if (strcmp($input, "exit -f") == 0)
	{
		echo "TM > Force Exiting Taskmaster. Processes may have been orphaned.\n";
		log_message("Taskmaster force shut down by the user. Processes potentially orphaned\n");
		die ();
	}
	return (FALSE);
}

function task_reconfig()
{
	echo "TM > Re-parsing Taskmaster Services from " << configFile << endl;
	log_message(" User requested services 'Reconfig'\n");
	posix_kill (getmypid(), SIGHUP);
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