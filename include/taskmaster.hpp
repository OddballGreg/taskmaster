#ifndef __TASKMASTER__
# define __TASKMASTER__

#include <iostream>
#include <fstream>
#include <cstdlib>
#include <cstring>
#include <ctime>
#include <cstddef>
#include <time.h>
#include <csignal>

using namespace std;

/*global variables*/
extern std::ofstream		*logFile;
extern char					*configFile;

/*main.cpp*/
void					config();
void					reconfig(int param);
void					init(char *filename);
void					shell();
const std::string		currentDateTime();

/*shellcmd1.cpp*/
void					task_exit(char *input);
void					task_reconfig();
void					task_help();
void					task_status();

/*shellcmd2.cpp*/
void					task_restart(char *input);
void					task_kill(char *input);
void					task_shutdown(char *input);
void					task_edit(char *input);

#endif
