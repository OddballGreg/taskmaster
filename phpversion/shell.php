<?php

include_once('Program.class.php');

function initData() {
$tempAr = array();
$final = array();
$configOrig = array();
    while ($line = fgets($GLOBALS['configFile'])) {
	if (!isset($GLOBALS['configOrig']))
		array_push($configOrig,$line);
    if (strncmp($line,"---",3)) {
        $tempVal = explode(': ',$line);
		if ($tempVal[0] == "exitcodes" || $tempVal[0] == "env_vars")
			$next[$tempVal[0]] = explode(",",$tempVal[1]);
        else $next[$tempVal[0]] = str_replace(";","",$tempVal[1]);
        unset($tempVal);
        array_push($tempAr,$next);
    }
    else {
        $tempOb = new Process($next);
        array_push($final,$tempOb);
        unset($next);
        unset($tempOb);
    	}
	}
	if (isset($configOrig))
		$GLOBALS['configOrig'] = $configOrig;
	unset($configOrig);
	$write = fopen('configOrig.yaml', 'w');
	foreach ($GLOBALS['configOrig'] as $original)
		fwrite($write,$original);
	return $final;
}

function shell()
{
	stream_set_blocking(STDOUT, 0);
	task_status();
	echo "<taskmaster/> ";
	while (1) {
		maintain();
		if ($line = fgets(STDIN))
		{
			run(strtolower($line));
			echo "<taskmaster/> ";
		}
	}
}

function run($line)
{
	$processList = $GLOBALS['processList'];
	$newAttr = explode("->",$line);
	/*foreach ($processList as $process) {
		if (strncmp($process->getName(),$line,strlen($process->getName())) == 0)
			$process->debug_start($line);
	}*/
	if (strncmp($line,"exit",4) == 0 || strncmp($line,"q",1) == 0) {
		task_exit($line);
	}
	else if (strncmp($line,"original",8) == 0) {
		foreach ($GLOBALS['configOrig'] as $line)
			echo $line.PHP_EOL;
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
	else if (strncmp($line, "start", 5) == 0)
		task_start($line);
	else return 0;
}

?>