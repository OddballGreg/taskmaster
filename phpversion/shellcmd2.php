<?php

function tast_restart($input)
{
	$args = explode(" ", $input);
	if ($args[1] != NULL)
	{
		$index = -1;
		while ($GLOBALS['processes'][++$index] != NULL)
		{
			$process = $GLOBALS['processes'][$index];
			if (strcmp($process.$name, $args[1]) == 0)
			{
				$process.restart();
				echo "TM > User requested 'restart' on program/process " . $args[1] . PHP_EOL;
				log_message("User requested 'restart' on program/process \n");
			}
		}
	}
	else
		echo "TM > The 'restart' command requires a program name arguement to function." . PHP_EOL;
	echo "TM > ";
}

function tast_kill($input)
{
	
}

function tast_shutdown($input)
{
	
}

function tast_edit($input)
{
	
}

function tast_start($input)
{
	
}
?>

void				task_restart(char *input)
{
	std::string temp(&input[8]);
	int			index;
	
	if (temp.empty() != TRUE)
	{
		index = -1;
		while (processes[++index] != NULL)
			if (strcmp(processes[index]->name, &input[8]) == 0)
			{
				processes[index]->restart();
				echo "TM > User requested 'restart' on program/process " << temp << endl;
				*logFile << currentDateTime() << " User requested 'restart' on program/process " << temp << endl;
			}
	}
	else
		echo "TM > The 'restart' command requires a program name arguement to function." . PHP_EOL;
	echo "TM > ";
}

void				task_kill(char *input)
{
	std::string temp(&input[5]);
	int			index;

	if (temp.empty() != TRUE)
	{
		index = -1;
		while (processes[++index] != NULL)
			if (strcmp(processes[index]->name, &input[5]) == 0)
			{
				processes[index]->kill();
				echo "TM > User requested 'kill' on program/process " << temp << endl;
				*logFile << currentDateTime() << " User requested 'kill' on program/process " << temp << endl;
			}
	}
	else
		echo "TM > The 'restart' command requires a program name arguement to function." << endl;
	echo "TM > ";
}

void				task_shutdown(char *input)
{
	std::string temp(&input[9]);
	int			index;

	if (temp.empty() != TRUE)
	{
		index = -1;
		while (processes[++index] != NULL)
			if (strcmp(processes[index]->name, &input[9]) == 0)
			{
				processes[index]->shutdown();
				echo "TM > User requested 'shutdown' on program/process " << temp << endl;
				*logFile << currentDateTime() << " User requested 'shutdown' on program/process " << temp << endl;
			}
	}
	else
		echo "TM > The 'restart' command requires a program name arguement to function." << endl;
	echo "TM > ";
}

void				task_edit(char *input)
{
	std::string temp(&input[5]);
	int			index;

	if (temp.empty() != TRUE)
	{
		index = -1;
		while (processes[++index] != NULL)
			if (strcmp(processes[index]->name, &input[5]) == 0)
			{
				//processes[index]->edit();
				echo "TM > You attempted to use the 'edit' command. Unfortunately this command does not yet work." << temp << endl;
				*logFile << currentDateTime() << " User 'edit'ed process <processid>'s <variablename> to <newvalue> " << temp << endl;
			}
	}
	else
		echo "TM > The 'edit' command requires a program name arguement to function." << endl;
	echo "TM > ";
}

void				task_start()
{
	std::string temp(&input[9]);
	int			index;

	if (temp.empty() != TRUE)
	{
		index = -1;
		while (processes[++index] != NULL)
			if (strcmp(processes[index]->name, &input[9]) == 0)
			{
				processes[index]->start();
				echo "TM > User requested 'start' on program/process " << temp << endl;
				*logFile << currentDateTime() << " User requested 'start' on program/process " << temp << endl;
			}
}
	else
		echo "TM > The 'start' command requires a program name arguement to function." << endl;
	echo "TM > ";
}