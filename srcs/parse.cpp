#include "taskmaster.hpp"

void			config()
{
	std::ifstream	*config;
	config = new ifstream;
	if (configFile != NULL)
		config->open(configFile, ios::in);
	if ((config->rdstate() & std::ifstream::failbit) != 0)
	{
		*logFile << currentDateTime() << " Invalid Config File Given\n";
		cout << "\x1b[31mInvalid Config File Given\n\x1b[0m";
		exit(1);
	}

}

void			reconfig(int param)
{
	(void)param;
	*logFile << currentDateTime() << " SIGHUP signal recieved. Executing reconfig.\n";
	config();
}