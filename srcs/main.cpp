#include "taskmaster.h"

int				main(int argc, char *argv[])
{
	if (argc < 2)
	{
		cout << "Taskmaster requires you to input a .yaml config file" << endl;
		return (0);
	}
	if (argv[2] != NULL)
		init(argv[2]);
	else
		init(NULL);
	configFile = argv[1];
	config();
	/*this function designates a function to be run when SIGHUP is called*/
	void (*sighup_handler)(int);
	sighup_handler = signal(1, reconfig);
	shell();
}

void			config()
{
	std::ifstream	*config;
	config = new ifstream;
	if (configFile != NULL)
		config->open(configFile, ios::in);

}

void			reconfig(int param)
{
	(void)param;
	*logFile << currentDateTime() << " SIGHUP signal recieved. Executing reconfig.\n";
	config();
}

void			init(char *filename)
{
	logFile = new ofstream;
	if (filename != NULL)
		logFile->open(filename, ios::out | ios::app);
	else
		logFile->open("logfile.txt", ios::out | ios::app);
	cout << "Logfile Succesfully Opened\n";
	*logFile << "<debug> Logfile Succesfully Opened\n";
	logFile->flush();

}

const std::string currentDateTime() 
{
	time_t		now = time(0);
	struct tm	tstruct;
	char		buf[80];

	tstruct = *localtime(&now);
	// Visit http://en.cppreference.com/w/cpp/chrono/c/strftime
	// for more information about date/time format
	strftime(buf, sizeof(buf), "%Y-%m-%d.%X", &tstruct);

	return buf;
}

void			shell()
{
	char		*input;

	input = (char *)calloc(256, sizeof(char));
	cout << "TM > ";
	while (1)
	{
		cin.getline(input, 256);
		if (strcmp(input, "exit") == 0 || strcmp(input, "Exit") == 0)
		{
			cout << "TM > Exiting Taskmaster. Have a nice day." << endl;
			free(input);
			*logFile << currentDateTime() << " User exited Taskmaster\n\n";
			logFile->close();
			exit(0);
		}
		else if (strcmp(input, "reconfig") == 0 || strcmp(input, "Reconfig") == 0)
		{
			cout << "TM > Re-parsing Taskmaster Services from " << configFile << endl;
			*logFile << currentDateTime() << " User requested services 'Reconfig'\n";
			raise(1);
			cout << "TM > ";
		}
		else
			cout << "TM > Command Not Recognized" << endl << "TM > ";
	}
}
