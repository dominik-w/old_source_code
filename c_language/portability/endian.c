#include <stdio.h>

#define BIG_ENDIAN 1
#define LITTLE_ENDIAN 2
#define ENDIAN (*(short int *)"\1\2" == 0x102 ? \
  BIG_ENDIAN : LITTLE_ENDIAN)

int main(void) {
  printf("%s endian\n", (ENDIAN == BIG_ENDIAN ? "big" : "little"));

 getch();
  return 0;
}
