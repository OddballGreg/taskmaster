<?php

function task_status($param = NULL, $name = NULL)
{
	return (FALSE);
}

function task_exit($input)
{
	if (task_status("On") != FALSE)
	{
		echo "TM > Exiting Taskmaster now would orphan the following functions: " . PHP_EOL . task_status("On") . PHP_EOL . "Please shut them down or type 'exit -f' to force exit" . PHP_EOL;
		return (TRUE);
	}
	else if (task_status("On") == FALSE)
	{
		echo "TM > Exiting Taskmaster. Have a nice day." . PHP_EOL;
		log_message("Taskmaster shut down by the user." . PHP_EOL, $GLOBALS['logfile']);
		die ();
	}
	else if (strcmp($input, "exit -f") == 0)
	{
		echo "TM > Force Exiting Taskmaster. Processes may have been orphaned." . PHP_EOL;
		log_message("Taskmaster force shut down by the user. Processes potentially orphaned" . PHP_EOL, $GLOBALS['logfile']);
		die ();
	}
	return (FALSE);
}

function task_restart()
{

}

function task_reconfig()
{

}

function task_help()
{

}
?>