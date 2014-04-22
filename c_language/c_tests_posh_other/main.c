/* 
 * File:   main.c
 * Author: Dominik
 *
 */

#include <stdio.h>
#include <stdlib.h>
#include <inttypes.h>
#include <time.h>
#include "posh.h"

#include <stddef.h> /* remove if C++ */
#include <string.h>

#define TRUE 1
#define FALSE 0

#define N_VALS 5
#define MASK 0xff

int is_big_endian( void )
{
  union
  {
    unsigned long l;
    unsigned char c[ 4 ];
  } u;

  /* W big-endian najbardziej znaczacy bajt bedzie pod najnizszym adresem */
  if ( u.c[ 0 ] == 0xFF )
    return 1;

  return 0;
}

int *foo() {
    static int dummy = 5;
    
    return &dummy;
}

void waiting(int secs)
{
    clock_t endwait;
    endwait = clock() + secs * CLK_TCK;
    while (clock() < endwait) {}
}

int main(int argc, char **argv)
{
    /*int c;
    
    while ((c = getchar()) != EOF) {
        recomment(c);
    }*/
    
    /* ----- */
    
    if (is_big_endian() == 1)
        printf("Big-endian");
    else printf("Little-endian");
    
    printf("\n");
    
    printf("%s", POSH_GetArchString());
    
    /*
    int i = 0;
    for (i = 0; i < 1000000; i++) {
        malloc(32);
    }*/
    
    printf("\n");
    
    static int my_vector[5] = { 1, 2, 3, 4, 5 };
    printf("Vector address: %p", my_vector);
    
    printf("\n");
    
    int my_val = 5;
    // <=> my_val % 2 != 0
    if ((my_val & 1) != 0)
        printf("!0");
    else printf("0");
    
    printf("\n");
    
    int x = 1;
    if (*(char *) & x == 1)
        printf("Little\n");
    else printf("Big\n");
    
    int a = 12;
    int *b = NULL;
    b = &a;
    printf("%d", *b);
    
    printf("\n");
    
    float vals[5];
    float *vp;
    
    for ( vp = &vals[0]; vp < &vals[N_VALS]; )
        *vp++ = 1;
    
    //
    int *ip = foo();
    
    printf("\n");
    
    printf("work: ");
    int i;
    for (i = 0; i < 12000; i++) {
        printf("%c\b", "|/-\\"[i%4]);
        fflush(stdout);
        // waiting(1);
    }
    printf("Done!\n");
    
    unsigned long color = 0x002a162f;
    unsigned char red, green, blue;
    
    red   = color & MASK;
    green = (color >> 8) & MASK;
    blue  = (color >> 16) & MASK;
    
    printf("%d\n", red);
    printf("%d\n", green);
    printf("%d\n", blue);
    
    printf("\n");
    
    wchar_t *wcs1 = L"Foo.";
    wchar_t *wcs2 = L"Bar.";
    wchar_t calosc[25];
    
    wcscpy(calosc, wcs1);
    *(calosc + wcslen(wcs1)) = L' ';
    wcscpy(calosc + wcslen(wcs1) + 1, wcs2);
    
    printf("Output: %ls\n", calosc);
    
    printf("\n");
    
    // tip - change the constant through a pointer
    const int CONST = 0;
    int *c = &CONST;
    *c = 1;
    printf("%i\n", CONST); /* 1 */
    
    printf("\n");
    
    const int MY_CONST = 0;
    int *c = &MY_CONST;
    *c = 100; // [years]
    *c++; --(*c); // :-P
    printf("A: %i\n", MY_CONST);

    getchar();
    
    return EXIT_SUCCESS;
}

/*
 * Test only
 */
/* int main(int argc, char** argv) {
    
    printf("C test!");
    getchar(); // 
    return EXIT_SUCCESS;
}
*/
