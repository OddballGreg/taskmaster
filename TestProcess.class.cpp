#include "taskmaster.hpp"
#include <typeinfo>

class Process {
    char    *lcmd;          //launch command. How the program should be launched. E.g. ./desktop/folder/program arg1 arg2
    long    pcount;         //process count
    bool    autostart;
    bool    rstart_cond;    //contingent on use during alg.
    int     exitcodes;
    int     startwait;
    long    retry;
    int     exitsig;
    int     killwait;
    bool    pid_logging;     //option dicating if the output from the process should be saved or not.
    char    *pid_logfile;    //if pid_logging is set to true, what file should the output be saved to.
    char    *env_vars;
    char    *wrk_dir;
    mode_t  umask;
    double  pid;
    bool    status;
    bool    restartMe;
    bool    verbose;

public:
    Process() {
        cout << "Constructor" << endl;
    }

    ~Process() {
        cout << "Destructor" << endl;
    }
    
template <typename T>
    void adjust(T attrib, T arg) {    //can only take singular instances for now, i.e. "restart true". I.e. only 2 args
        if (strncmp(attrib,"logfile",7) == 0) {
            if (strcmp(typeid(arg).name(),"Pc") == 0)   //char*
                logfile = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type char*" << endl;
        }
        else if (strncmp(attrib,"pcount",6) == 0) {
            if (strcmp(typeid(arg).name(),"l") == 0)  //long
                pcount = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type long" << endl;
        }
        else if (strncmp(attrib,"autostart",9) == 0) {
            if (strcmp(typeid(arg).name(),"b") == 0)  //boolean
                autostart = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type bool" << endl;
        }
        else if (strncmp(attrib,"rstart_cond",11) == 0) {
            if (strcmp(typeid(arg).name(),"l") == 0)  //long
                rstart_cond = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type long" << endl;
        }
        else if (strncmp(attrib,"exitcodes",9) == 0) {
            if (strcmp(typeid(arg).name(),"i") == 0)  //integer
                exitcodes = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type int" << endl;
        }
        else if (strncmp(attrib,"startwait",9) == 0) {
            if (strcmp(typeid(arg).name(),"i") == 0)   //integer
                startwait = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type int" << endl;
        }
        else if (strncmp(attrib,"retry",5) == 0) {
            if (strcmp(typeid(arg).name(),"l") == 0)  //long
                retry = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type long" << endl;
        }
        else if (strncmp(attrib,"exitsig",7) == 0) {
            if (strcmp(typeid(arg).name(),"i") == 0)   //integer
                exitsig = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type integer" << endl;
        }
        else if (strncmp(attrib,"killwait",8) == 0) {
            if (strcmp(typeid(arg).name(),"i") == 0)   //integer
                killwait = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type integer" << endl;
        }
        else if (strncmp(attrib,"env_vars",8) == 0) {
            if (strcmp(typeid(arg).name(),"Pc") == 0)  //char*
                env_vars = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type char*" << endl;
        }
        else if (strncmp(attrib,"wrk_dir",7) == 0) {
            if (strcmp(typeid(arg).name(),"Pc") == 0)   //char*
                wrk_dir = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type char*" << endl;
        }
        else if (strncmp(attrib,"umask",5) == 0) {
            if (strcmp(typeid(arg).name(),"t") == 0)   //mode_t
                umask = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type mode_t" << endl;
        }
        else if (strncmp(attrib,"pid",3) == 0) {
            if (strcmp(typeid(arg).name(),"d") == 0)   //double
                pid = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type double" << endl;
        }
        else if (strncmp(attrib,"status",6) == 0) {
            if (strcmp(typeid(arg).name(),"b") == 0)   //boolean
                status = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type bool" << endl;
        }
        else if (strncmp(attrib,"restartMe",9) == 0) {
            if (strcmp(typeid(arg).name(),"b") == 0)   //boolean
                restartMe = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type bool" << endl;
        }
        else if (strncmp(attrib,"verbose",7) == 0) {
            if (strcmp(typeid(arg).name(),"b") == 0)   //boolean
                verbose = arg;
            else cout << "Argument for " << attrib << "is of type " << typeid(arg).name() << ". It needs to be of type bool" << endl;
        }
        else cout << "Wrong Args" << endl;
    }
};

int main() {
    Process Object;
    Object.adjust("verbose", true);
}
