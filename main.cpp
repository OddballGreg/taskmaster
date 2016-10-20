#include "taskmaster.h"

int        main(int argc, char *argv[])
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
    shell();
}

void       init(char *filename)
{
    logfile = new ofstream;
    if (filename != NULL)
        logfile->open(filename, ios::out | ios::app);
    else
        logfile->open("logfile.txt", ios::out | ios::app);
    cout << "Logfile Succesfully Opened\n";
    *logfile << "Logfile Succesfully Opened\n";
    logfile->flush();

}

const std::string currentDateTime() 
{
    time_t     now = time(0);
    struct tm  tstruct;
    char       buf[80];

    tstruct = *localtime(&now);
    // Visit http://en.cppreference.com/w/cpp/chrono/c/strftime
    // for more information about date/time format
    strftime(buf, sizeof(buf), "%Y-%m-%d.%X", &tstruct);

    return buf;
}

void       shell()
{
    char   *input;

    input = (char *)calloc(256, sizeof(char));
    cout << "TM > ";
    while (1)
    {
        cin.getline(input, 256);
        if (strcmp(input, "exit") == 0 || strcmp(input, "Exit") == 0)
        {
            cout << "TM > Exiting Taskmaster. Have a nice day." << endl;
            free(input);
            *logfile << currentDateTime() << " User exited Taskmaster\n";
            logfile->close();
            exit(0);
        }
        else
            cout << "TM > Command Not Recognized" << endl << "TM > ";
    }
}
