#include "taskmaster.hpp"

void			config()
{
	std::ifstream	*config;
	//int			progCount;

	config = new ifstream;
	if (configFile != NULL)
		config->open(configFile, ios::in);
	if ((config->rdstate() & std::ifstream::failbit) != 0)
	{
		*logFile << currentDateTime() << " Invalid Config File Given\n";
		cout << "\x1b[31mInvalid Config File Given\n\x1b[0m";
		exit(1);
	}
	//Parse number of programs to be handled
	//processes = malloc(progCount * sizeof(*process));
	//malloc each space in processes to hold a process object:
	//ie: processes[0] = malloc(sizeof(process));
	//store process in processes[0] and populate data.
	//If data already exists in the item and you are reconfiguring it:
	//	lcmd, pid logging or logfile, env vars, working directory or umask
	//	set restartMe to true
}

void			reconfig(int param)
{
	(void)param;
	int index;

	index = -1;
	*logFile << currentDateTime() << " SIGHUP signal recieved. Executing reconfig.\n";
	config();
	while (processes[++index] != NULL)
		if (processes[index]->restartMe == TRUE)
		{
			*logFile << currentDateTime() << " " << processes[index]->name<< " " << processes[index]->pid << " Process detected as flagged for Restarting\n";
			*logFile << currentDateTime() << " " << processes[index]->name<< " " << processes[index]->pid << " Attempting To Restart Process\n";
			processes[index]->restartMe = FALSE;
			processes[index]->restart();
		}
}