<?php

function shell()
{
	stream_set_blocking (STDIN, 0);
	$exit = FALSE;
	echo "Taskmaster Initiated. Service Status Summary:" . PHP_EOL . task_status() . PHP_EOL . "TM > ";
	while ($exit != TRUE)
	{
		maintain();
		if (($input = fgets(STDIN)) != NULL)
		{
			run(strtolower($input));
			$input = strtolower($input);
			echo("TM > ");
		}
	}
}

function run($input)
{
	if (strcmp($input, "exit") == 0)
		task_exit();
	else if (strcmp($input, "reconfig") == 0)
		task_reconfig();
	else if (strcmp($input, "help") == 0)
		task_help();
	else if (strncmp($input, "restart", 7) == 0)
		task_restart($input);
	else if (strcmp($input, "status") == 0)
		task_status();
	else if (strncmp($input, "kill", 4) == 0)
		task_kill($input);
	else if (strncmp($input, "shutdown", 8) == 0)
		task_shutdown($input);
	else if (strncmp($input, "edit", 4) == 0)
		task_edit($input);
	else
		echo "TM > Command Not Recognized\n" . "TM > ";
}

?>