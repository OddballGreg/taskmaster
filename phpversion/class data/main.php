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
        echo "constructor".PHP_EOL;

        $this->_attribStat['name'] = $kwargs[0][0];
        $this->_attribStat['pid'] = trim($kwargs[1][1],";");
        $this->_attribStat['lcmd'] = trim($kwargs[2][1],";");
        $this->_attribStat['pcount'] = trim($kwargs[3][1],";");
        $this->_attribStat['autostart'] = trim($kwargs[4][1],";");
        $this->_attribStat['rstart_cond'] = trim($kwargs[5][1],";");
        $this->_attribStat['exitcodes'] = trim($kwargs[6][1],";");
        $this->_attribStat['startwait'] = trim($kwargs[7][1],";");
        $this->_attribStat['retry'] = trim($kwargs[8][1],";");
        $this->_attribStat['exitsig'] = trim($kwargs[9][1],";");
        $this->_attribStat['killwait'] = trim($kwargs[10][1],";");
        $this->_attribStat['pid_logging'] = trim($kwargs[11][1],";");
        $this->_attribStat['pid_logfile'] = trim($kwargs[12][1],";");
        $this->_attribStat['env_vars'] = trim($kwargs[13][1],";");
        $this->_attribStat['wrk_dir'] = trim($kwargs[14][1],";");
        $this->_attribStat['umask'] = trim($kwargs[15][1],";");
        $this->_attribStat['status'] = trim($kwargs[16][1],";");
        $this->_attribStat['restartMe'] = trim($kwargs[17][1],";");
        $this->_attribStat['child'] = trim($kwargs[18][1],";");
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
                var_dump($process->attribStat());
            }
        }
        else if (strncmp($line,"adjust",6) == 0) {
            $newAttr = explode("->",$line);
            echo "new array: ";
            print_r($newAttr);
            $finalAttr = array();
            $finalAttr[$newAttr[2]] = $newAttr[3];
            echo "input: ";
            print_r($finalAttr);
            foreach($processList as $process) {
                foreach ($finalAttr as $name => $value) {
                    $process->_attribStat[$name] = trim($finalAttr[$name]);
                    echo "new: ".$process->attribStat()[$name];
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