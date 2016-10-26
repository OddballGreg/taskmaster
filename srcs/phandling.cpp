#include "taskmaster.hpp"

void		maintain()
{
	int		index;

	index = -1;
	while (processes[++index] != NULL)
	{
		//request status
		//if offline, request restart boolean setting
		//attempt to restart if true
		if (processes[index]->status() == FALSE)
			if (processes[index]->rstart_cond == TRUE)
				processes[index]->start();
		//request restartMe info
		//if true, restart the program(s)
		if (processes[index]->restartMe == TRUE)
		{
			processes[index]->restartMe == FALSE);
			processes[index]->restart();
		}
	}	
}

void		autostart()
{
	int		index;

	index = -1;
	while (processes[++index] != NULL)
		if (processes[index]->autostart == TRUE)
			processes[index]->start();
}