#include <stdio.h>
#include <unistd.h>
#include <string.h>

int main(int argc, char **argv) {
    (void)argc;
    printf("%s output\n",argv[0]);
    return 0;
}