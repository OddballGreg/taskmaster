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
#include <unistd.h>
#include <string.h>

using namespace std;

/* global variables */
extern std::ofstream		*logFile;
extern char					*configFile;
extern void					(*sighup_handler)(int);
//extern process				*processes;

/* main.cpp */
void					init(char *configFileName, char *logFileName);

/* shell.cpp */
void					shell();
void                    run(char *input);

/* utils.cpp */
const std::string		currentDateTime();
std::string				*str_split(char *input);

/* shellcmd1.cpp */
void					task_exit();
void					task_reconfig();
void					task_help();
void					task_status();

/* shellcmd2.cpp */
void					task_restart(char *input);
void					task_kill(char *input);
void					task_shutdown(char *input);
void					task_edit(char *input);
void                    task_start(char *input);

/* parse.cpp */
void					config();
void					reconfig(int param);

/* phandling.cpp */
void					maintain();
void					autostart();

#endif
