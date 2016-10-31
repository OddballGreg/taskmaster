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
        //echo "constructor".PHP_EOL;
        $this->name = $kwargs[0][0];
        $this->_attrib_00 = $kwargs[1][1];  //1, not 0, to grep actual value and assign it
        $this->_attrib_01 = $kwargs[2][1];
    }
    
    public function __destruct() {
        //echo "destructor".PHP_EOL;
    }

    public function getName() {
        return $this->name;
    }

    public function attribStat() {
        $attribStat = array($this->_attrib_00,$this->_attrib_01);
        return $attribStat;
    }

	//REMIND Greg to comment the hell out of this function. It's a bit much to wrap ones head around without reference
    public function start() 
	{
		if ($this->aborted == FALSE)
		{
			if ($this->status == FALSE)
			{
				if ($this->pid == 0)
				{
					$env = phpinfo(INFO_ENVIRONMENT);
					for ($x; $env[$x] != NULL; $x++)
					{
						for ($y; $_env_vars[$y] != NULL; $y++)
						{
							$env_pair = explode("=", $env[$x]);
							$_env_pair = explode("=", $_env_vars[$y]);
							if (strcmp($env_pair[0], $_env_pair[0]) == 0)
								$env[$x] = $_env_vars[$y];
						}
					}
					for ($x; $_env_vars[$x] != NULL; $x++)
					{
						$exists = FALSE;
						for ($y; $env[$y] != NULL; $y++)
						{
							$env_pair = explode("=", $env[$y]);
							$_env_pair = explode("=", $_env_vars[$x]);
							if (strcmp($env_pair[0], $_env_pair[0]) == 0)
								$exits = TRUE;
						}
						if ($exists == FALSE)
							$env[] = $_env_vars[$x];
					}
					if ($_pid_logging == TRUE)
					{
						if ($this->_pid_logfile != NULL)
							$descriptorspec['0'] = fopen($this->_pid_logfile, 'a');
						else
							$descriptorspec['0'] = fopen($this->_name . $this->pid . "txt", 'a');
					}
					$attempts = 0;
					pexec:
					$attempts++;
					if ($_umask != NULL)
						$mask = umask($_umask);
					$this->_stream = proc_open($_lcmd, $descriptorspec, $pipes, $_wrkdir, $env);
					$proc_details = proc_get_status($this->_stream);
					$this->pid = $proc_details['pid'];
					if ($this->_umask != NULL)
						umask($mask); //then set it back after the fork
					$wait = time() + $_startwait;
					while (time() <= $_startwait)
						if (pcntl_waitpid($proc_details['pid'], $status, WNOHANG) == $this->pid)
						{
							if ($attempts <= $this->_retry)
							{
								log_message("Program {$this->name} at process {$this->pid} failed to start. Retrying for the {$attempts} time.\n");
								jump(pexec);
							}
							else
							{
								log_message("Program {$this->name} at process {$this->pid} failed to start after {$this->retry} attempts\n");
								$this->aborted = TRUE;
								proc_close($this->stream);
							}
						}
					$this->_status = TRUE;
				}
				else
				{
					if ($this->child != NULL)
						$this->child->start();
				}
			}
			else
				log_message("Process ID {$this->pid} already online during start() call\n");
			if ($this->pcount > 1)
			{
				log_message("Program {$this->_name} is creating \n");
				$this->child = clone $this;
				$this->child->_pcount = $this->_pcount - 1;
				$this->child->start();
			}
		}
    }

	public function status($verbose)
	{
		//check process for exit codes, kill process and set status
		//if unaccepted exit code and restart true, attempt to restart

		if ($verbose == FALSE)
		{
			if ($this->_status == FALSE)
				return (FALSE);
			else if ($this->_child == NULL)
				return (TRUE);
			else
				return($this->_child->status());
		}
		else
		{
			if ($this->_status == TRUE)
				echo "TM > " . $this->_name . " " . $this->_pid . " status: \x1b[34mONLINE\x1b[0m\n";
			else
				echo "TM > " . $this->_name . " " . $this->_pid . " status: \x1b[31mOFFLINE\x1b[0m\n";
			if ($this->_child != NULL)
				$this->_child->status(TRUE);
		}
	}

	public function restart()
	{
		if ($this->status == FALSE)
			$this->start();
		else
		{
			$this->shutdown();
			$this->start();
		}
		if ($this->child != NULL)
			$this->child->restart();
	}

	public function shutdown()
	{
		if ($this->status == TRUE)
		{
			//send clean exit code to process
			//wait for killwait seconds
			$this->kill();
		}
		if ($this->child != NULL)
			$this->child->shutdown();
	}

	public function kill()
	{
		if ($this->status == TRUE)
		{
			//kill process
			//attach child process to parent process
		}
		if ($this->child != NULL)
			$this->child->kill();
	}

}

?>