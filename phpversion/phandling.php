<?php

function		maintain()
{
	$index = -1;
	while ($GLOBALS['processes'][++$index] != NULL)
	{
		$process = $GLOBALS['processes'][$index];
		//request status
		//if offline, request restart boolean setting
		//attempt to restart if true
		if ($process->status() == FALSE)
		{
			log_message($process->_attribStat['name'] . " " . $process->_attribStat['pid'] . " Reported as OFFLINE\n");
			if ($process->_attribStat['rstart_cond'] == TRUE)
			{
				log_message($process->_attribStat['name'] . " " . $process->_attribStat['pid'] . " Attempting To Restart Process\n");
				$process->start();
			}
		}
		//request restartMe info
		//if true, restart the program(s)
		if ($process->_attribStat['restartMe'] == TRUE)
		{
			log_message($process->_attribStat['name'] . " " . $process->_attribStat['pid'] . " Process detected as flagged for Restarting\n");
			log_message($process->_attribStat['name'] . " " . $process->_attribStat['pid'] . " Attempting To Restart Process\n");
			$process->_attribStat['restartMe'] == FALSE;
			$process->restart();
		}
	}	
}

function		autostart()
{
	$index = -1;
	while ($GLOBALS['processes'][++$index] != NULL)
	{
		$process = $GLOBALS['processes'][$index];
		if ($process->_attribStat['autostart'] == TRUE)
			$process->start();
	}
}

?>