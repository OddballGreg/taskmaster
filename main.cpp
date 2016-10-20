#include "taskmaster.h"
using namespace std;

void shell();

int main    ()
{
    shell();
}

void shell ()
{
    char*  input;

    input = (char *)calloc(256, sizeof(char));
    cout << "TM > ";
    while (1)
    {
        cin.getline(input, 256);
        if (strcmp(input, "exit") == 0 || strcmp(input, "Exit") == 0)
        {
            cout << "TM > Exiting Taskmaster. Have a nice day." << endl;
            free(input);
            exit(0);
        }
        else
            cout << "TM > Command Not Recognized" << endl << "TM > ";
    }
}
