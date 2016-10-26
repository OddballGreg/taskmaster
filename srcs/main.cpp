#include "taskmaster.hpp"

/* global variables */
std::ofstream			*logFile;
char					*configFile;
void					(*sighup_handler)(int);
//process					*processes;

int				main(int argc, char *argv[])
{
	if (argc < 2)
	{
		cout << "Taskmaster requires you to input at least a .yaml config file" << endl;
		cout << "Usage: ./taskmaster ./config.yaml ./logfile.txt" << endl;
		return (0);
	}

	if (argv[2] != NULL)
		init(argv[1], argv[2]);
	else
		init(argv[1], NULL);

	config();
	autostart();
	shell();
}

void			init(char *configFileName, char *logFileName)
{
	sighup_handler = signal(1, reconfig);

	configFile = configFileName;

	logFile = new ofstream;
	if (logFileName != NULL)
		logFile->open(logFileName, ios::out | ios::app);
	else
		logFile->open("tasklog.txt", ios::out | ios::app);
}