<?php

function config()
{
	/*std::ifstream	*config;
	//int			progCount;

	config = new ifstream;
	if (configFile != NULL)
		config->open(configFile, ios::in);
	if ((config->rdstate() & std::ifstream::failbit) != 0)
	{
		*logFile << currentDateTime() << " Invalid Config File Given\n";
		echo "\x1b[31mInvalid Config File Given\n\x1b[0m";
		exit(1);
	}*/
	//Parse number of programs to be handled
	//processes = malloc(progCount * sizeof(*process));
	//malloc each space in processes to hold a process object:
	//ie: processes[0] = malloc(sizeof(process));
	//store process in processes[0] and populate data.
	//If data already exists in the item and you are reconfiguring it:
	//	lcmd, pid logging or logfile, env vars, working directory or umask
	//	set restartMe to true
}

function reconfig($param)
{
	$index = -1;
	log_message("SIGHUP signal recieved. Executing reconfig.");
	config();
	while ($GLOBALS['processes'][++$index] != NULL)
	{
		$process = $GLOBALS['processes'][$index];
		if ($process.$restartMe == TRUE)
		{
			log_message($process.$name . " " . $process.$pid . " Process detected as flagged for Restarting");
			log_message($process.$name . " " . $process.$pid . " Attempting To Restart Process");
			$process.$restartMe = FALSE;
			$process.$restart();
		}
	}

}

?>