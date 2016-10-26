#include "taskmaster.hpp"

void			shell()
{
	char		input[256];

	cout << "TM > ";
	while (1)
	{
		maintain();
		cin.getline(input, 256);
		run(input);
	}
}

void            run(char *input)
{
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