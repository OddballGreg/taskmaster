#ifndef __TASKMASTER__
# define __TASKMASTER__

#include <iostream>
#include <fstream>
#include <cstdlib>
#include <cstring>
#include <ctime>
#include <cstddef>
#include <time.h>

/*global variables*/
std::ofstream *logfile;

using namespace std;

void init(char *filename);
void shell();

#endif
