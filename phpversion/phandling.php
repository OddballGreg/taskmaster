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
		if (is_resource($process->_attribStat['stream']))
		{
			$proc_details = proc_get_status($process->_attribStat['stream']);
			if ($proc_details['running'] == FALSE && $process->_attribStat['exited_with'] == NULL && $proc_details['exitcode'] != -1)
				$process->_attribStat['exited_with'] = $proc_details['exitcode'];
		}
		if (is_resource($process->_attribStat['stream']) == FALSE || $proc_details['running'] == FALSE)
		{
			$process->_attribStat['status'] == FALSE;
			if ($process->_attribStat['reported'] == FALSE)
			{
				if (isset($proc_details))
				{
					$process->_attribStat['exited_with'] = $proc_details['exitcode'];
					log_message("{$process->_attribStat['name']} {$proc_details['pid']} Reported as OFFLINE due to exitcode {$process->_attribStat['exited_with']}");
				}
				else if ($process->_attribStat['exited_with'] != NULL)
					log_message("{$process->_attribStat['name']} Reported as OFFLINE due to {$process->_attribStat['exited_with']}");
				else
					log_message("{$process->_attribStat['name']} Reported as OFFLINE without an Exitcode. Probably did not start.");				
				$process->_attribStat['reported'] = TRUE;
			}
			if ($process->_attribStat['rstart_cond'] == TRUE)
			{
				if ($process->_attribStat['usr_sd'] == TRUE)
					if ($process->_attribStat['reported'] == FALSE)
					{ 			
						if (isset($proc_details))
							log_message("{$process->_attribStat['name']} {$proc_details['pid']} Will not be restarted due to User Shutdown/Accepted Exitcode.");
						else
							log_message("{$process->_attribStat['name']} {$process->_attribStat['pid']} Will not be restarted due to User Shutdown/Accepted Exitcode.");
						$process->_attribStat['reported'] = TRUE;
					}		
				else
				{
					//add functionality to check the exit code against accepted exit codes before restarting.
					if ($process->_attribStat['exited_with'] != NULL && in_array($process->_attribStat['exited_with'], $process->_attribStat['exitcodes']))
					{
						if (isset($proc_details))
							log_message("{$process->_attribStat['name']} {$proc_details['pid']} Recieved an accepted exitcode and will not restart automatically");
						else
							log_message("{$process->_attribStat['name']} Recieved an accepted exitcode and will not restart automatically");	
						$process->_attribStat['usr_sd'] == TRUE;
					}
					else
					{
						log_message("{$process->_attribStat['name']} Attempting To Restart Process");
						$process->_attribStat['exited_with'] = NULL;
						$process->kill();
						$process->start();
					}
				}
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