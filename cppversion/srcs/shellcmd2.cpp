#include "taskmaster.hpp"

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
				cout << "TM > User requested 'restart' on program/process " << temp << endl;
				*logFile << currentDateTime() << " User requested 'restart' on program/process " << temp << endl;
			}
	}
	else
		cout << "TM > The 'restart' command requires a program name arguement to function." << endl;
	cout << "TM > ";
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
				cout << "TM > User requested 'kill' on program/process " << temp << endl;
				*logFile << currentDateTime() << " User requested 'kill' on program/process " << temp << endl;
			}
	}
	else
		cout << "TM > The 'restart' command requires a program name arguement to function." << endl;
	cout << "TM > ";
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
				cout << "TM > User requested 'shutdown' on program/process " << temp << endl;
				*logFile << currentDateTime() << " User requested 'shutdown' on program/process " << temp << endl;
			}
	}
	else
		cout << "TM > The 'restart' command requires a program name arguement to function." << endl;
	cout << "TM > ";
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
				cout << "TM > You attempted to use the 'edit' command. Unfortunately this command does not yet work." << temp << endl;
				*logFile << currentDateTime() << " User 'edit'ed process <processid>'s <variablename> to <newvalue> " << temp << endl;
			}
	}
	else
		cout << "TM > The 'edit' command requires a program name arguement to function." << endl;
	cout << "TM > ";
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
				cout << "TM > User requested 'start' on program/process " << temp << endl;
				*logFile << currentDateTime() << " User requested 'start' on program/process " << temp << endl;
			}
}
	else
		cout << "TM > The 'start' command requires a program name arguement to function." << endl;
	cout << "TM > ";
}