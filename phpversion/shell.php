<?php

include_once('Program.class.php');

function initData($handle) {
    $processes = array();
    $vector = array();
    $array = array();
    $temp = array();
    while ($line = fgets($handle)) { 
        if (strncmp($line,"---",3)) {
            $temp = explode("\t",trim(trim($line),":"));
            $raw[$temp[0]] = $temp[1];
            array_push($array, $raw);
            $temp = array();
        }
        else {
            array_push($vector, $array[18]);
            $array = array();
        }
    }
    unset($array);
    foreach ($vector as $process)
        array_push($processes, new Process($process));
    unset($vector);
    return $processes;
}

function shell()
{
	//task_status(TRUE); 
	echo "<taskmaster/> ";
	while ($line = fgets(STDIN)) {
		maintain();
		run(strtolower($line));
        echo "<taskmaster/> ";	
	}
}

function run($line)
{
	$processList = $GLOBALS['processList'];
	$newAttr = explode("->",$line);
	foreach ($processList as $process) {
		if (strncmp($process->getName(),$line,strlen($process->getName())) == 0)
			$process->debug_start($line);
	}
	if (strncmp($line,"exit",4) == 0 || strncmp($line,"q",1) == 0) {
		task_exit($line);
	}
	else if (strncmp($line,"status",6) == 0) {      //use e.g. "status->ls" i.e. status of attrib within object
		foreach($processList as $process) {
			if (strncmp($process->getName(),$newAttr[1],strlen($process->getName())) == 0) {
				echo $process->getName().PHP_EOL;
				foreach($process->attribStat() as $key => $value)
					echo $key.": ".$value.PHP_EOL;
			}
		}
	}
	else if (strncmp($line,"update",6) == 0) {      //use e.g. "adjust->ls->pid->8000"
		$finalAttr = array();
		$finalAttr[$newAttr[2]] = $newAttr[3];
		foreach($processList as $process) {
			foreach ($finalAttr as $name => $value) {
				if ($process->getName() == $newAttr[1]) {
					$process->_attribStat[$name] = trim($finalAttr[$name]);
					echo PHP_EOL."\t".$process->getName()."'s ".$name." succesfully updated to ".$value.PHP_EOL;
				}
			}
		}
	}
	else if (strncmp($line, "reconfig", 8) == 0)
		task_reconfig();
	else if (strncmp($line, "help", 4) == 0)
		task_help();
	else if (strncmp($line, "restart", 7) == 0)
		task_restart($line);
	else if (strncmp($line, "status", 6) == 0)
		task_status(TRUE);
	else if (strncmp($line, "kill", 4) == 0)
		task_kill($line);
	else if (strncmp($line, "shutdown", 8) == 0)
		task_shutdown($line);
	else if (strncmp($line, "edit", 4) == 0)
		task_edit($line);
	else return 0;
}

?>