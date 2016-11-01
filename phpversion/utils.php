<?php

function welcome() {
    $processList = $GLOBALS['processList'];
	echo "Welcome to task master.".PHP_EOL."Your config file has indicated the following processes to be managed: ".PHP_EOL;
    $i = 1;
    foreach ($processList as $process) {
        echo "  ".$i." ".$process->getName().PHP_EOL;
        $i++;
    }
}

function contains($haystack, $needle)
{
	if (strpos($haystack, $needle) === FALSE)
		return (FALSE);
	return (TRUE);
}

function cap($value, $cap)
{
	if ($value > $cap)
		return ($cap);
	return ($value);
}

?>