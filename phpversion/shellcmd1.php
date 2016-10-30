<?php

function task_status($param = NULL, $name = NULL)
{
	return (FALSE);
}

function task_exit($confirm, $logfile, $input)
{
	if (task_status("On") != FALSE)
	{
		echo "Exiting Taskmaster now would orphan the following functions: " . PHP_EOL . task_status("On") . PHP_EOL . "Please enter either Y or N to confirm exit or resume" . PHP_EOL;
		return (TRUE);
	}
	else if (task_status("On") == FALSE || $confirm === TRUE)
	{
		if (strcmp($input, "Y") == 1)
		{
			log_message("Taskmaster shut down by the user." . PHP_EOL, $logfile);
			die ("Exiting" . PHP_EOL);
		}
		else if (strcmp($input, "N") == 1)
			return (FALSE);
		else
		{
			echo "Please enter either Y or N to confirm exit or resume" . PHP_EOL;
			return (TRUE);
		}
	}
	return (FALSE);
}

function task_restart()
{

}
?>