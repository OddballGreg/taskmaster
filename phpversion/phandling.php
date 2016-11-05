<?php

function		maintain()
{
	$index = -1;
	while (isset($GLOBALS['processList'][++$index]) == TRUE)
	{
		$process = $GLOBALS['processList'][$index];
		//echo $process->_attribStat['usr_sd'];
		//print_r($process->_attribStat['exitcodes']);
		if (is_resource($process->_attribStat['stream'])) /* Check that $process has a valid stream */
		{
			$proc_details = proc_get_status($process->_attribStat['stream']); /* If so, gather process details */
			if ($proc_details['running'] == FALSE && $process->_attribStat['exited_with'] == NULL && $proc_details['exitcode'] != -1) /* if process is not running and no valid exitcode was previously gathered. */
				$process->_attribStat['exited_with'] = $proc_details['exitcode']; /* gather exitcode */
		}
		if (is_resource($process->_attribStat['stream']) == FALSE || $proc_details['running'] == FALSE) /* if the programs stream is false OR was reported as offline */
		{
			$process->_attribStat['status'] == FALSE; /* Set process as offline */
			//echo $process->_attribStat['name']." ".$process->_attribStat['status'].PHP_EOL;	//REMOVE!!!!!!!!!!!!!
			if ($process->_attribStat['reported'] == FALSE) /* Check that the process has not previously reported itself as offline */
			{
				if (isset($proc_details)) /*dicate a log message depending on what information is available */
				{
					$process->_attribStat['exited_with'] = $proc_details['exitcode'];
					log_message("{$process->_attribStat['name']} {$proc_details['pid']} Reported as OFFLINE due to exitcode {$process->_attribStat['exited_with']}");
				}
				else if ($process->_attribStat['exited_with'] != NULL)
					log_message("{$process->_attribStat['name']} Reported as OFFLINE due to {$process->_attribStat['exited_with']}");
				else
					log_message("{$process->_attribStat['name']} Reported as OFFLINE without an Exitcode. Probably could not start.");				
				$process->_attribStat['reported'] = TRUE; /* Set reported to avoid flooding the log with repeated reports */
			}
			if ($process->_attribStat['rstart_cond'] == TRUE) /* check if the process should be restarted */
			{
				if ($process->_attribStat['usr_sd'] == TRUE) /* Check if the process was shutdown because of a user command or valid exit code */
				{
					if ($process->_attribStat['reported'] == FALSE) /* Check that the process has not reported it's status before */
					{ 			
						if (isset($proc_details)) /*dicate a log message depending on what information is available */
							log_message("{$process->_attribStat['name']} {$proc_details['pid']} Will not be restarted due to User Shutdown/Accepted Exitcode.");
						else
							log_message("{$process->_attribStat['name']} {$process->_attribStat['pid']} Will not be restarted due to User Shutdown/Accepted Exitcode.");
						$process->_attribStat['reported'] = TRUE; /* Set reported to avoid flooding the log with repeated reports */
					}
				}		
				else /* if the program was not shut down by user command */
				{
					if ($process->_attribStat['exited_with'] != NULL && in_array($process->_attribStat['exited_with'], $process->_attribStat['exitcodes']) != FALSE) /* Check for accepted exit code */
					{
						if ($process->_attribStat['reported'] == FALSE) /* Check that the process has not reported it's status before */
						{
							if (isset($proc_details)) /*dicate a log message depending on what information is available */
								log_message("{$process->_attribStat['name']} {$proc_details['pid']} Recieved an accepted exitcode and will not restart automatically");
							else
								log_message("{$process->_attribStat['name']} Recieved an accepted exitcode and will not restart automatically");	
							$process->_attribStat['usr_sd'] == TRUE; /* Set that the process exited by a user accepted exit code */
							$process->_attribStat['reported'] = TRUE; /* Set reported to avoid flooding the log with repeated reports */
						}
					}
					else /* Otherwise, restart the process */
					{
						log_message("{$process->_attribStat['name']} Attempting To Restart Process");
						$process->_attribStat['exited_with'] = NULL; 
						$process->kill(); /* The process stream may need to be killed first. */
						$process->start();
					}
				}
			}
		}
		if ($process->_attribStat['restartMe'] == TRUE)  //check for programs flagged for restarting by a reconfig, restart them
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