<?php

class Test {
    public $_attribStat = array();

    function __construct($kwargs) {
        $this->_attribStat['name'] = $kwargs['name'] ;
        $this->_attribStat['lcmd'] =  $kwargs['lcmd'] ;
        $this->_attribStat['pcount'] =  $kwargs['pcount'] ;
        $this->_attribStat['autostart'] =  $kwargs['autostart'] ;
        $this->_attribStat['rstart_cond'] =  $kwargs['rstart_cond'] ;
        $this->_attribStat['exitcodes'] =  $kwargs['exitcodes'] ;
        $this->_attribStat['startwait'] =  $kwargs['startwait'] ;
        $this->_attribStat['retry'] =  $kwargs['retry'] ;
        $this->_attribStat['exitsig'] =  $kwargs['exitsig'] ;
        $this->_attribStat['killwait'] =  $kwargs['killwait'] ;
        $this->_attribStat['pid_logging'] =  $kwargs['pid_logging'] ;
        $this->_attribStat['pid_logfile'] =  $kwargs['pid_logfile'] ;
        $this->_attribStat['env_vars'] =  $kwargs['env_vars'] ;
        $this->_attribStat['wrk_dir'] =  $kwargs['wrk_dir'] ;
        $this->_attribStat['umask'] =  $kwargs['umask'] ;
        $this->_attribStat['status'] =  $kwargs['status'] ;
        $this->_attribStat['restartMe'] =  $kwargs['restartMe'] ;
        $this->_attribStat['child'] =  $kwargs['child'] ;
        echo $this->name." constructed with:".PHP_EOL;
        $this->about();
    }

    function __destruct() {
        echo $this->_attribStat['name']." Destructed...".PHP_EOL."---".PHP_EOL;
    }

    function about() {
        print_r($this->_attribStat);
    }
}
$tempAr = array();
$final = array();
$i = 0;
while ($line = fgets($handle)) {
    if (strncmp($line,"---",3)) {
        $tempVal = explode(': ',$line);
        $next[$tempVal[0]] = str_replace(";","",$tempVal[1]);
        unset($tempVal);
        array_push($tempAr,$next);
    }
    else {
        echo $i.": ";
        $tempOb = new Test($next);
        $i++;
        array_push($final,$tempOb->_attribStat['name']);
        unset($next);
        unset($tempOb);
    }
}
print_r($final);
//print_r($tempAr);
//$obj1 = new Test(array('name' => 'OBJECT NAME', 'value' => 'OBJECT VALUE'));

?>