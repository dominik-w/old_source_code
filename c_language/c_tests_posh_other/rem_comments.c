/*
 * Removing comments from C code.
 */

#include <stdio.h>
#include <stdlib.h>

void recomment(int c);
void in_comment(void);
void echo_quote(int c);

/*int main(int argc, char **argv)
{
    int c, d;
    
    while ((c = getchar()) != EOF) {
        recomment(c);
    }
    
    return EXIT_SUCCESS;
}*/

/* Read each char and remove comments */
void recomment(int c)
{
    int d;
    
    if (c == '/')
        if ((d = getchar()) == '*')
            in_comment();  /* begin of comment */
        else if (d == '/') {
            putchar(c);    /* next char */
            recomment(d);
        } else {
            putchar(c);    /* it's not a comment */
            putchar(d);
        }
    else if (c == '\'' || c == '"')
        echo_quote(c);     /* begin of constant */
    else
        putchar(c);        /* not a comment */
}

/* Looking for the end of comment */
void in_comment(void)
{
    int c, d;
    
    c = getchar();  /* previous char */
    d = getchar();  /* next char */
    while (c != '*' || d != '/') {
        c = d;
        d = getchar();
    }
}

/* Print the text of constant and search for the end */
void echo_quote(int c)
{
    int d;
    
    putchar(c);
    while ((d = getchar()) != c) {
        putchar(d);
        if (d == '\\')
            putchar(getchar());
    }
    putchar(c);
}
