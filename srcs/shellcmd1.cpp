#include "taskmaster.hpp"

void				task_exit()
{
	cout << "TM > Exiting Taskmaster. Have a nice day." << endl;
	*logFile << currentDateTime() << " User exited Taskmaster\n\n";
	logFile->close();
	exit(0);
	//anti orphaning handling needed
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
	cout << "Help\nStatus\nKill\nShutdown\nRestart\nReconfig\nExit\n";
	cout << "Note: The commands require that you input exactly the process ID as an arguement or they will not function.\n";
	cout << endl << "TM > ";
}

void				task_status()
{
	cout << "TM > <process statuses printed here>" << endl;
	/*
	int index;
	index = -1;
	while (processes[++index] != NULL)
		cout << processes[index]->status();
	*/
	cout << "TM > ";
}

//void				task_start()