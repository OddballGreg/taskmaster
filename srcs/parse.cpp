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