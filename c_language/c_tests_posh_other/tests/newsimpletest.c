/*
 * File:   newsimpletest.c
 * Author: Dominik
 *
 * Created on 2011-08-28, 16:25:52
 */

#include <stdio.h>
#include <stdlib.h>

/*
 * Simple C Test Suite
 */

void echo_quote(int c);

void testEcho_quote() {
    int c;
    echo_quote(c);
    if (1 /*check result*/) {
        printf("%%TEST_FAILED%% time=0 testname=testEcho_quote (newsimpletest) message=error message sample\n");
    }
}

void in_comment();

void testIn_comment() {
    in_comment();
    if (1 /*check result*/) {
        printf("%%TEST_FAILED%% time=0 testname=testIn_comment (newsimpletest) message=error message sample\n");
    }
}

void recomment(int c);

void testRecomment() {
    int c;
    recomment(c);
    if (1 /*check result*/) {
        printf("%%TEST_FAILED%% time=0 testname=testRecomment (newsimpletest) message=error message sample\n");
    }
}

int main(int argc, char** argv) {
    printf("%%SUITE_STARTING%% newsimpletest\n");
    printf("%%SUITE_STARTED%%\n");

    printf("%%TEST_STARTED%%  testEcho_quote (newsimpletest)\n");
    testEcho_quote();
    printf("%%TEST_FINISHED%% time=0 testEcho_quote (newsimpletest)\n");

    printf("%%TEST_STARTED%%  testIn_comment (newsimpletest)\n");
    testIn_comment();
    printf("%%TEST_FINISHED%% time=0 testIn_comment (newsimpletest)\n");

    printf("%%TEST_STARTED%%  testRecomment (newsimpletest)\n");
    testRecomment();
    printf("%%TEST_FINISHED%% time=0 testRecomment (newsimpletest)\n");

    printf("%%SUITE_FINISHED%% time=0\n");

    return (EXIT_SUCCESS);
}
