/* 
 * File:   main.c
 * Author: Dominik Wlazlowski
 * 
 * Native app for easy starting program written in Java, in any OS
 */

#include <stdio.h>
#include <stdlib.h>

/*
 * App starter - main.
 */
int main(int argc, char **argv, char **env)
{
    int res;
    char *command = "java -Xmx256m -Dfile.encoding=UTF-8 -jar firstticket-all.jar";
    
    // environment check
    // while (*env) printf("%s\n", *env++); getchar();
    
    res = system(command);
    
    // printf("Code: %d", res); // dbg
    if (res > 0) {
        // an error occured
        printf("An error occured. Please check: 1. Jar file, 2. Your java version - OpenJDK is not compatibile.");
        getchar();
    }
    
    return EXIT_SUCCESS;
}
