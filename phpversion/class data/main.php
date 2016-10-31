<?php

class Process {
    private $_start = false;
    private $_pid;
    private $_name;

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