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

void			shell()
{
	char		input[256];

	cout << "TM > ";
	while (1)
	{
		cin.getline(input, 256);
		if (strcmp(input, "exit") == 0 || strcmp(input, "Exit") == 0)
			task_exit();
		else if (strcmp(input, "reconfig") == 0 || strcmp(input, "Reconfig") == 0)
			task_reconfig();
		else if (strcmp(input, "help") == 0 || strcmp(input, "Help") == 0)
			task_help();
		else if (strncmp(input, "restart", 7) == 0 || strncmp(input, "Restart", 7) == 0)
			task_restart(input);
		else if (strcmp(input, "status") == 0 || strcmp(input, "Status") == 0)
			task_status();
		else if (strncmp(input, "kill", 4) == 0 || strncmp(input, "Kill", 4) == 0)
			task_kill(input);
		else if (strncmp(input, "shutdown", 8) == 0 || strncmp(input, "Shutdown", 8) == 0)
			task_shutdown(input);
		else if (strncmp(input, "edit", 4) == 0 || strncmp(input, "Edit", 4) == 0)
			task_edit(input);
		else
			cout << "TM > Command Not Recognized" << endl << "TM > ";
	}
}
