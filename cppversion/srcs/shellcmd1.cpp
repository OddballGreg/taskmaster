#include "taskmaster.hpp"

void				task_exit(char *input)
{
	int				index;
	bool			orphans;

	index = -1;
	orphans = false;
	while (proccesses[++index] != NULL)
		if (processes[index]->status(FALSE) == TRUE)
			orphans = TRUE;
	if (orphans == TRUE)
	{
		cout << "TM > Taskmaster is still handling 1 or more processes."; 
		cout << "Exiting now would orphan those processes.";
		cout << "Type exit -f or shutdown the processes first to exit." << endl;
	}
	else if (strcmp(input[5], "-f") == 0)
	{
		cout << "TM > Forced Exiting Taskmaster. Processes may have been orphaned." << endl;
		*logFile << currentDateTime() << " User force exited Taskmaster. Processes may have been orphaned\n\n";
		logFile->close();
		exit(0);
	}
	else if (orphans == FALSE)
	{
		cout << "TM > Exiting Taskmaster. Have a nice day." << endl;
		*logFile << currentDateTime() << " User exited Taskmaster\n\n";
		logFile->close();
		exit(0);
	}
}

void				task_reconfig()
{
	cout << "TM > Re-parsing Taskmaster Services from " << configFile << endl;
	*logFile << currentDateTime() << " User requested services 'Reconfig'\n";
	raise(1);
	cout << "TM > ";
}

void				task_help()
{
	cout << endl << "Welcome to Taskmaster by ghavenga and sallen.\n";
	cout << "Taskmaster is a WTC_ project aimed at handling the running of ";
	cout << "processes and programs according to the .yaml file given as an arguement.\n";
	cout << "The following commands are available to you:\n";
	cout << "Help\nStatus\nKill\nShutdown\nRestart\nReconfig\nStart\nExit\n";
	cout << "Note: The commands require that you input exactly the process ID as an arguement or they will not function.\n";
	cout << endl << "TM > ";
}

void				task_status()
{
	int index;

	index = -1;
	while (processes[++index] != NULL)
		processes[index]->status(TRUE);
	cout << "TM > ";
}
