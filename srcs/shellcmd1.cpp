#include "taskmaster.h"

void				task_exit(char *input)
{
	cout << "TM > Exiting Taskmaster. Have a nice day." << endl;
	free(input);
	*logFile << currentDateTime() << " User exited Taskmaster\n\n";
	logFile->close();
	exit(0);
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
	cout << "Welcome to Taskmaster by ghavenga and sallen.\n";
	cout << "Taskmaster is a WTC_ project aimed at handling the running of ";
	cout << "processes and programs according to the .yaml file given as an arguement.\n";
	cout << "The following commands are available to you:\n";
	cout << "Help\nStatus\nKill\nShutdown\nRestart\nReconfig\nExit\n";
	cout << "TM > ";
}

void				task_status()
{
	cout << "TM > <process statuses printed here>" << endl;
	cout << "TM > ";
}