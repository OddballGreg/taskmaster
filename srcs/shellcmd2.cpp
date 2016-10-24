#include "taskmaster.hpp"

void				task_restart(char *input)
{
	(void)input;
	cout << "TM > User requested 'restart' on program/process <insert arg>" << endl;
	*logFile << currentDateTime() << " User requested 'restart' on program/process <insert arg>\n";
	cout << "TM > ";
}

void				task_kill(char *input)
{
	(void)input;
	cout << "TM > User requested 'kill' on program/process <insert arg>" << endl;
	*logFile << currentDateTime() << " User requested 'kill' on program/process <insert arg>\n";
	cout << "TM > ";
}

void				task_shutdown(char *input)
{
	(void)input;
	cout << "TM > User requested 'shutdown' on program/process <insert arg>" << endl;
	*logFile << currentDateTime() << " User requested 'shutdown' on program/process <insert arg>\n";
	cout << "TM > ";
}

void				task_edit(char *input)
{
	(void)input;
	cout << "TM > User 'edit'ed process <processid>'s <variablename> to <newvalue>" << endl;
	*logFile << currentDateTime() << " User 'edit'ed process <processid>'s <variablename> to <newvalue>\n";
	cout << "TM > ";
}