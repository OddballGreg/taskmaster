#include "taskmaster.hpp"

class 		Process
{
	char    *lcmd			= NULL;          //launch command. How the program should be launched. E.g. ./desktop/folder/program arg1 arg2
	long    pcount			= 1;         //process count
	bool    autostart		= FALSE;
	bool    rstart_cond		= FALSE;    //contingent on use during alg.
	int		*exitcodes		= NULL;		//IF NULL, consider only 0 to be a good exit
	int     startwait		= 5;
	long    retry			= 0;
	int     exitsig			= 3;
	int     killwait		= 5;
	bool    pid_logging		= FALSE;     //option dicating if the output from the process should be saved or not.
	char    *pid_logfile	= NULL;    //if pid_logging is set to true, what file should the output be saved to.
	char    **env_vars		= NULL;
	char    *wrk_dir		= NULL;
	mode_t  umask			= NULL;
	double  pid				;
	bool    status			= FALSE;
	bool    restartMe		= FALSE;
	bool    verbose			= FALSE;

public:
    Process() 
	{
		lcmd = (char)malloc(sizeof(char) * 256);
		exitcodes = (int)malloc(sizeof(int) * 20); // Will need protection against flooding
		pid_logfile = (char)malloc(sizeof(char) * 256);
		env_vars = (char *)malloc(sizeof(char *) * 50); // Will need protection against flooding.
		
        cout << "New Process Constructed" << endl;
    }

    ~Process() 
	{
        cout << "Process Destructed" << endl;
    }
}