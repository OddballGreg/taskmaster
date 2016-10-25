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
}

void			reconfig(int param)
{
	(void)param;
	*logFile << currentDateTime() << " SIGHUP signal recieved. Executing reconfig.\n";
	config();
	//restart necessary servers
}