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

/*global variables*/
std::ofstream	*logfile;
char			*configfile;

using namespace std;

void reconfig(int param);
void init(char *filename);
void shell();
const std::string currentDateTime();

#endif
