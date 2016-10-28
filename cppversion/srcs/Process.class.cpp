#include "taskmaster.hpp"

class 		Process
{
	char	*name			= NULL;
	char    *lcmd			= NULL;     //launch command. How the program should be launched. E.g. ./desktop/folder/program arg1 arg2
	long    pcount			= 1;        //process count
	bool    autostart		= FALSE;
	bool    rstart_cond		= FALSE;    //contingent on use during alg.
	int		*exitcodes		= NULL;
	int     startwait		= 5;
	long    retry			= 0;
	int     exitsig			= 3;
	int     killwait		= 5;
	bool    pid_logging		= FALSE;    //option dicating if the output from the process should be saved or not.
	char    *pid_logfile	= NULL;     //if pid_logging is set to true, what file should the output be saved to.
	char    **env_vars		= NULL;
	char    *wrk_dir		= NULL;
	mode_t  umask			= NULL;
	pid_t	pid				= 0;
	Process	child			= NULL;
	bool    status			= FALSE;
	bool    restartMe		= FALSE;

public:
	Process() 
	{
		name = new char [256]; //Protect against flood
		lcmd = new char [256]; //Protect against flood
		exitcodes = new int [20]; //Protect against flood
		pid_logfile = new char [256]; //Protect against flood
		env_vars = new char [50]; //Protect against flood 
		wrk_dir = new char [256]; //Protect against flood

		int index = -1;
		while (env_vars[++index] != NULL)
			env_vars[index] = new char [256];

		exitcodes[0] = '0';

		cout << "New Process Constructed" << endl;
	}

	~Process() 
	{
		int index = -1;
		while (env_vars[++index] != NULL)
			free(env_vars[index]);

		free(name);
		free(lcmd);
		free(exitcodes);
		free(pid_logfile);
		free(env_vars);
		free(wrk_dir);

		cout << "Process Destructed" << endl;
	}

	bool	status(bool verbose)
	{
		//check process for exit codes, kill process and set status
		//if unaccepted exit code and restart true, attempt to restart

		if (verbose == FALSE)
		{
			if (status == FALSE)
				return (FALSE);
			else if (child == NULL);
				return (TRUE);
			else
				return(child->status());
		}
		else
		{
			if (status == TRUE)
				cout << "TM > " << name << " " << pid << " status: \x1b[34mONLINE\x1b[0m" << endl;
			else
				cout << "TM > " << name << " " << pid << " status: \x1b[31mOFFLINE\x1b[0m" << endl;
			if (child != NULL)
				child->status(TRUE);
		}
	}

	void	start()
	{
		if (status == FALSE)
		{
			if (pid == 0)
			{
				pid = fork();
				
				//init envvars
				//set working directory
				//define umask for pid
				//create logfile if necessary
				/* research how to redirect a processes stdoutput to a file */
				//launch process and listen for exit codes
				int execve(const char *path, char *const argv[], char *const envp[]);
				//if exit code detected within startwait seconds, retry launch process up to retry times
				//output debug message if start aborted due to continued death.
			}
		}
		else
			*logFile << currentDateTime() <<  " Process ID " << pid << " already online during start() call\n";
		if (child != NULL)
			child->start();
	}

	void	restart()
	{
		if (status == FALSE)
			start();
		else
		{
			shutdown();
			start();
		}
		if (child != NULL)
			child->restart();
	}

	void	shutdown()
	{
		if (status == TRUE)
		{
			//send clean exit code to process
			//wait for killwait seconds
			kill();
		}
		if (child != NULL)
			child->shutdown();
	}

	void	kill()
	{
		if (status == TRUE)
		{
			//kill process
			//attach child process to parent process
		}
		if (child != NULL)
			child->kill();
	}
}