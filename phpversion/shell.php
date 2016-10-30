<?php

function shell()
{
	stream_set_blocking (STDIN, 0);
	$exit = FALSE;
	echo "Taskmaster Initiated. Service Status Summary:" . PHP_EOL . task_status() . PHP_EOL . "> ";
	while ($exit != TRUE)
	{
		if (($input = fgets(STDIN)) != NULL)
		{
			if (strcmp($input, "exit") == 1)
				$exit = task_exit($logfile, $input);
			else
				echo ("Command Not Found" . PHP_EOL);
			echo("> ");
		}
	}
}

?>