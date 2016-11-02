<?php

function		maintain()
{
	$index = -1;
	while (isset($GLOBALS['processList'][++$index]) == TRUE)
	{
		$process = $GLOBALS['processList'][$index];
		//request status
		//if offline, request restart boolean setting
		//attempt to restart if true
		if (is_resource($process->_attribStat['stream']) != FALSE)
			$proc_details = proc_get_status($process->_attribStat['stream']);
		if (is_resource($process->_attribStat['stream']) == FALSE || $proc_details['running'] == FALSE)
		{
			$process->_attribStat['status'] == FALSE;
			$process->kill();
			if ($process->_attribStat['reported'] == FALSE)
			{
				log_message("{$process->_attribStat['name']} {$process->_attribStat['pid']} Reported as OFFLINE due to exitcode {$proc_details['exitcode']}");
				$process->_attribStat['reported'] = TRUE;
			}
			if ($process->_attribStat['rstart_cond'] == TRUE)
			{
				log_message("{$process->_attribStat['name']} {$process->_attribStat['pid']} Attempting To Restart Process");
				$process->start();
			}
		}
		//request restartMe info
		//if true, restart the program(s)
		if ($process->_attribStat['restartMe'] == TRUE)
		{
			log_message($process->_attribStat['name'] . " " . $process->_attribStat['pid'] . " Process detected as flagged for Restarting");
			log_message($process->_attribStat['name'] . " " . $process->_attribStat['pid'] . " Attempting To Restart Process");
			$process->_attribStat['restartMe'] == FALSE;
			$process->restart();
		}
	}	
}

function		autostart()
{
	$index = -1;
	while (isset($GLOBALS['processList'][++$index]) == TRUE)
	{
		$process = $GLOBALS['processList'][$index];
		if ($process->_attribStat['autostart'] == TRUE)
			$process->start();
	}
}

?>