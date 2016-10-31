<?php

class Process {
    private $_name;
    private $_pid;
    private $_lcmd;
    private $_pcount;
    private $_autostart;
    private $_rstart_cond;
    private $_exitcodes;
    private $_startwait;
    private $_retry;
    private $_exitsig;
    private $_killwait;
    private $_pid_logging;
    private $_pid_logfile;
    private $_env_vars;
    private $_wrk_dir;
    private $_umask;
    private $_status;
    private $_restartMe;
    private $_child;
    private $_attribStat;

    public function __construct($kwargs) {
        //echo "constructor".PHP_EOL;
        $this->_name = $kwargs[0][0];
        $this->_pid = trim($kwargs[1][1],";");
        $this->_lcmd = trim($kwargs[2][1],";");
        $this->_pcount = trim($kwargs[3][1],";");
        $this->_autostart = trim($kwargs[4][1],";");
        $this->_rstart_cond = trim($kwargs[5][1],";");
        $this->_exitcodes = trim($kwargs[6][1],";");
        $this->_startwait = trim($kwargs[7][1],";");
        $this->_retry = trim($kwargs[8][1],";");
        $this->_exitsig = trim($kwargs[9][1],";");
        $this->_killwait = trim($kwargs[10][1],";");
        $this->_pid_logging = trim($kwargs[11][1],";");
        $this->_pid_logfile = trim($kwargs[12][1],";");
        $this->_env_vars = trim($kwargs[13][1],";");
        $this->_wrk_dir = trim($kwargs[14][1],";");
        $this->_umask = trim($kwargs[15][1],";");
        $this->_status = trim($kwargs[16][1],";");
        $this->_restartMe = trim($kwargs[17][1],";");
        $this->_child = trim($kwargs[18][1],";");
    }
    
    public function __destruct() {
        //echo "destructor".PHP_EOL;
    }

    public function adjust($pargs) {
        foreach ($pargs as $arg => $value) {
            foreach ($this->_attribStat as $process) {
                if (strncmp($process,$arg,strlen($process)) == 0) {
                    $process = $value;
                }
            }
        }
    }

    public function getName() {
        return $this->_name;
    }

    public function attribStat() {
        $this->_attribStat = array(
                    $this->_name,
                    $this->_pid,
                    $this->_lcmd,
                    $this->_pcount,
                    $this->_autostart,
                    $this->_rstart_cond,
                    $this->_exitcodes,
                    $this->_startwait,
                    $this->_retry,
                    $this->_exitsig,
                    $this->_killwait,
                    $this->_pid_logging,
                    $this->_pid_logfile,
                    $this->_env_vars,
                    $this->_wrk_dir,
                    $this->_umask,
                    $this->_status,
                    $this->_restartMe,
                    $this->_child,
            );
        return $_attribStat;
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
    while ($line = fgets($handle)) { 
        if (strncmp($line,"---",3))
            array_push($array, explode("\t",trim(trim($line),":")));
        else {
            array_push($vector, $array);
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
        foreach ($processList as $process) {
            if (strncmp($process->getName(),$line,strlen($process->getName())) == 0)
                $process->start($line);
        }
        if (strncmp($line,"exit",4) == 0 || strncmp($line,"q",1) == 0)
            exit();
        else if (strncmp($line,"status",6) == 0) {
            foreach ($processList as $process) {
                echo $process->getName().PHP_EOL;
                print_r($process->attribStat());
                var_dump($process);
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