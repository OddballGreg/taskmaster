<?php

function shell()
{
	stream_set_blocking (STDIN, 0);
	$exit = FALSE;
	echo "Taskmaster Initiated. Service Status Summary:\n"; 
	task_status(TRUE); 
	echo "\nTM > ";
	while ($exit != TRUE)
	{
		maintain();
		if (($input = fgets(STDIN)) != NULL)
		{
			$input = strtolower($input);
			run($input);
		}
	}
}

function run($input)
{
	if (strncmp($input, "exit", 4) == 0)
		task_exit($input);
	else if (strncmp($input, "reconfig", 8) == 0)
		task_reconfig();
	else if (strncmp($input, "help", 4) == 0)
		task_help();
	else if (strncmp($input, "restart", 7) == 0)
		task_restart($input);
	else if (strncmp($input, "status", 6) == 0)
		task_status(TRUE);
	else if (strncmp($input, "kill", 4) == 0)
		task_kill($input);
	else if (strncmp($input, "shutdown", 8) == 0)
		task_shutdown($input);
	else if (strncmp($input, "edit", 4) == 0)
		task_edit($input);
	else
		echo "TM > Command Not Recognized\n";
}

?>