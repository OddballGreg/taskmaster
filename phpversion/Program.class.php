<?php

class Process {
    
	public $_attribStat = array(
        "name" => false,
        "pid" => NULL,
        "lcmd" => NULL,
        "pcount" => NULL,
        "autostart" => false,
        "rstart_cond" => NULL,
        "exitcodes" => 0,
        "startwait" => NULL,
        "retry" => false,
        "exitsig" => NULL,
        "killwait" => NULL,
        "pid_logging" => false,
        "pid_logfile" => NULL,
        "env_vars" => NULL,
        "wrk_dir" => NULL,
        "umask" => NULL,
        "status" => false,
        "restartMe" => false,
        "child" => NULL,
		"stream" => NULL,
		"aborted" => FALSE
    );

    public function __construct($kwargs) {
        echo "constructor".PHP_EOL;
        $this->_attribStat['name'] = trim($kwargs['name:'],";");
        $this->_attribStat['pid'] = trim($kwargs['pid:'],";");
        $this->_attribStat['lcmd'] = trim($kwargs['lcmd:'],";");
        $this->_attribStat['pcount'] = trim($kwargs['pcount:'],";");
        $this->_attribStat['autostart'] = trim($kwargs['autostart:'],";");
        $this->_attribStat['rstart_cond'] = trim($kwargs['rstart_cond:'],";");
        $this->_attribStat['exitcodes'] = trim($kwargs['exitcodes:'],";");
        $this->_attribStat['startwait'] = trim($kwargs['startwait:'],";");
        $this->_attribStat['retry'] = trim($kwargs['retry:'],";");
        $this->_attribStat['exitsig'] = trim($kwargs['exitsig:'],";");
        $this->_attribStat['killwait'] = trim($kwargs['killwait:'],";");
        $this->_attribStat['pid_logging'] = trim($kwargs['pid_logging:'],";");
        $this->_attribStat['pid_logfile'] = trim($kwargs['pid_logfile:'],";");
        $this->_attribStat['env_vars'] = trim($kwargs['env_vars:'],";");
        $this->_attribStat['wrk_dir'] = trim($kwargs['wrk_dir:'],";");
        $this->_attribStat['umask'] = trim($kwargs['umask:'],";");
        $this->_attribStat['status'] = trim($kwargs['status:'],";");
        $this->_attribStat['restartMe'] = trim($kwargs['restartMe:'],";");
        $this->_attribStat['child'] = trim($kwargs['child:'],";");
    }

	public function adjust($pargs) {
        echo "pargs: ".$pargs.PHP_EOL;
        $this->_attribStat[$pargs[0]] == $pargs[1];
    }

    public function getName() {
        return $this->_attribStat['name'];
    }

    public function attribStat() {
        return $this->_attribStat;
    }

    public function debug_start($lcmd) {
        echo exec($lcmd);
    }
    
    public function __destruct() {
        echo "destructor".PHP_EOL;
    }



	/* We should probably consider breaking down the functionality of this method into smaller functions/methods. It's a bit frightening to look at. */
    public function start() 
	{
		/* Check that the program was not aborted in the past */
		if ($this->_attribStat['aborted'] == FALSE)
		{
			/* Start will only start offline programs, if you want to restart already running programs, use restart() */
			if ($this->_attribStat['status'] == FALSE)
			{
				/* Further assurance the there is actually no program running */
				if ($this->_attribStat['pid'] == 0)
				{
					/* get the environment and add or modify according to user input */
					$env = $this->_gen_env();
					/* Generate a file descriptor to redirect the programs stdout if the user requested it */
					if ($this->_attribStat['pid_logging'] == TRUE)
					{
						if ($this->_attribStat['pid_logfile'] != NULL)
							$descriptorspec['0'] = fopen($this->_attribStat['pid_logfile'], 'a');
						else
							$descriptorspec['0'] = fopen($this->_attribStat['name'] . $this->_attribStat['pid'] . "txt", 'a');
					}
					/* assembly loop to retry program initialization until it runs or must be aborted due to too many attempts*/
					$attempts = 0;
					pexec:
					$attempts++;
					/* Set the umask if necessary */
					if ($this->_attribStat['umask'] != NULL)
						$mask = umask($this->_attribStat['umask']);
					/* Create the Process stream and save the pid */
					$this->_attribStat['stream'] = proc_open("exec " . $this->_attribStat['lcmd'], $descriptorspec, $pipes, $this->_attribStat['wrk_dir'], $env);
					$proc_details = proc_get_status($this->_attribStat['stream']);
					$this->_attribStat['pid'] = $proc_details['pid'];
					/* Set back the umask post fork */
					if ($this->_attribStat['umask'] != NULL)
						umask($mask);
					/* Calculate how much time in seconds to give the program to start before it is considered properly started */
					$wait = time() + $this->_attribStat['startwait'];
					/* Continually check for the process status to make sure it's okay, if not, retry until limit is reached, the output abort debug message and close stream */
					while (time() <= $this->_attribStat['startwait'])
						if (pcntl_waitpid($proc_details['pid'], $status, WNOHANG) == $this->_attribStat['pid'])
						{
							if ($attempts <= $this->_attribStat['retry'])
							{
								log_message("Program {$this->_attribStat['name']} at process {$this->_attribStat['pid']} failed to start. Retrying for the {$attempts} time.\n");
								jump(pexec);
							}
							else
							{
								log_message("Program {$this->_attribStat['name']} at process {$this->_attribStat['pid']} failed to start after {$this->_attribStat['retry']} attempts\n");
								$this->_attribStat['aborted'] = TRUE;
								proc_close($this->_attribStat['stream']);
								$this->_attribStat['pid'] = 0;
							}
						}
					/* If succesful, set status to TRUE for online */
					$this->_attribStat['status'] = TRUE;
				}
				else
				{
					/* Repeat this process for any children the process may have or should have */
					if ($this->_attribStat['pcount'] > 1)
					{
						if ($this->_attribStat['child'] != NULL)
							$this->_attribStat['child']->start();
						else
						{
							log_message("Program {$this->_attribStat['name']} is creating a child process\n");
							$this->_attribStat['child'] = clone $this;
							$this->_attribStat['child']->_pcount = $this->_attribStat['pcount'] - 1;
							$this->_attribStat['child']->start();
						}
					}
				}
			}
			else
				log_message("Process ID {$this->_attribStat['pid']} already online during start() call\n");
			if ($this->_attribStat['pcount'] > 1)
			{
				log_message("Program {$this->_attribStat['name']} is creating a child process\n");
				$this->_attribStat['child'] = clone $this;
				$this->_attribStat['child']->_pcount = $this->_attribStat['pcount'] - 1;
				$this->_attribStat['child']->start();
			}
		}
    }

	public function maintain()
	{
		//check process for exit codes, kill process and set status
		//if unaccepted exit code and restart true, attempt to restart
		$proc_details = proc_get_status($this->_attribStat['stream']);
		if ($proc_details['running'] == FALSE)
		{
			log_message("{$this->_attribStat['name']} {$this->_attribStat['pid']} has reported as 'OFFLINE', due to exit code {$proc_details['exitcode']} \n");
			if ($this->_attribStat['rstart_cond'] == TRUE && in_array($proc_details['exitcode'], $this->_attribStat['exitcodes']) == FALSE)
			{
				log_message("{$this->_attribStat['name']} {$this->_attribStat['pid']} is set to be restarted after recieving an unnaccepted exitcode. Attempting Restart.\n");
				$this->start();
			}
		}
		if ($this->_attribStat['child'] != NULL)
			$this->_attribStat['child']->maintain();
	}

	public function status($verbose)
	{
		/* internal */
		if ($verbose == FALSE)
		{
			if ($this->_attribStat['status'] == FALSE)
				return (FALSE);
			else if ($this->_attribStat['child'] == NULL)
				return (TRUE);
			else
				return($this->_attribStat['child']->status(FALSE));
		}
		/* external */
		else
		{
			if ($this->_attribStat['status'] == TRUE)
				echo "TM > " . $this->_attribStat['name'] . " " . $this->_attribStat['pid'] . " status: \x1b[34mONLINE\x1b[0m\n";
			else
				echo "TM > " . $this->_attribStat['name'] . " " . $this->_attribStat['pid'] . " status: \x1b[31mOFFLINE\x1b[0m\n";
			if ($this->_attribStat['child'] != NULL)
				$this->_attribStat['child']->status(TRUE);
		}
	}

	public function restart()
	{
		if ($this->_attribStat['status'] == FALSE)
			$this->start();
		else
		{
			$this->shutdown();
			$this->start();
		}
		/* Restart is intentionally not recursive, because it calls other methods which already are. */
	}

	public function shutdown()
	{
		if ($this->_attribStat['status'] == TRUE)
		{
			proc_terminate($this->_attribStat['stream'], $this->_attribStat['exitsig']);
			sleep($this->_attribStat['killwait']);
			$this->kill();
		}
		if ($this->_attribStat['child'] != NULL)
			$this->_attribStat['child']->shutdown();
	}

	public function kill()
	{
		if ($this->_attribStat['status'] == TRUE)
		{
			proc_terminate($this->_attribStat['stream']);
			$this->_attribStat['pid'] = 0;
			$this->_attribStat['status'] = FALSE;	
		}
		if ($this->_attribStat['child'] != NULL)
			$this->_attribStat['child']->kill();
	}

	private function _gen_env()
	{
		$env = phpinfo(INFO_ENVIRONMENT);
		for ($x; $env[$x] != NULL; $x++)
		{
			for ($y; $this->_attribStat['env_vars'][$y] != NULL; $y++)
			{
				$env_pair = explode("=", $env[$x]);
				$_env_pair = explode("=", $this->_attribStat['env_vars'][$y]);
				if (strcmp($env_pair[0], $_env_pair[0]) == 0)
					$env[$x] = $this->_attribStat['env_vars'][$y];
			}
		}
		for ($x; $this->_attribStat['env_vars'][$x] != NULL; $x++)
		{
			$exists = FALSE;
			for ($y; $env[$y] != NULL; $y++)
			{
				$env_pair = explode("=", $env[$y]);
				$_env_pair = explode("=", $this->_attribStat['env_vars'][$x]);
				if (strcmp($env_pair[0], $_env_pair[0]) == 0)
					$exits = TRUE;
			}
			if ($exists == FALSE)
				$env[] = $this->_attribStat['env_vars'][$x];
		}
		return ($env);
	}

	public function reset_pcount()
	{
		if ($this->_attribStat['pcount'] <= 1)
			if ($this->_attribStat['child'] != NULL)
			{
				$this->_attribStat['child']->shutdown();
				$this->_attribStat['child']->remove_children();
		}
		else
		{
			log_message("Program {$this->_attribStat['name']} is creating a child process\n");
			$this->_attribStat['child'] = clone $this;
			$this->_attribStat['child']->_pcount = $this->_attribStat['pcount'] - 1;
			$this->_attribStat['child']->reset_pcount();
		}
	}

	private function remove_children()
	{
		while ($this->_attribStat['child'] != NULL)
			$this->_attribStat['child']->remove_children();
	}

}

?>