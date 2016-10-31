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
        "child" => NULL
    );

    public function __construct($kwargs) {
        //echo "constructor".PHP_EOL;
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
    
    public function __destruct() {
        //echo "destructor".PHP_EOL;
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

    public function start($command) {
        exec($command, $contents);
        foreach($contents as $file)
            echo $file.PHP_EOL;
    }
}

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

function initShell($processList) {
    echo "<taskmaster/> ";
    while($line = fgets(STDIN))
    {
        $newAttr = explode("->",$line);
        foreach ($processList as $process) {
            if (strncmp($process->getName(),$line,strlen($process->getName())) == 0)
                $process->start($line);
        }
        if (strncmp($line,"exit",4) == 0 || strncmp($line,"q",1) == 0) {
            echo exec("clear");
            exit();
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
        echo "<taskmaster/> ";
    }
}

function welcome($processList) {
    echo "Welcome to task master.".PHP_EOL."Your config file has indicated the following processes to be managed: ".PHP_EOL;
    $i = 1;
    foreach ($processList as $process) {
        echo "  ".$i." ".$process->getName().PHP_EOL;
        $i++;
    }
}

if ($argv[1] && $argc == 2)
    $handle = fopen($argv[1],"r");
else { echo "No configuration file detected. Aborting.".PHP_EOL; exit(); }
$processList = initData($handle);
fclose($handle);
welcome($processList);
initShell($processList);
?>