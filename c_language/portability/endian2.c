#include <stdio.h>
#include <stdint.h>

int main() {
  uint32_t val = 0x04030201;
  unsigned char *v = (unsigned char *)&val;
  int byte_order = v[0] * 1000 + v[1] * 100 + v[2] * 10 + v[3];

  if (byte_order == 4321) {
    printf("Porz퉐ek big-endian (4321)\n");
  } else if (byte_order == 1234) {
    printf("Porz퉐ek little-endian (1234)\n");
  } else if (byte_order == 3412) {
    printf("Porz퉐ek PDP (3412)\n");
  } else {
    printf("Inny porz퉐ek (%d)\n", byte_order);
  }
  
  getch(); 
  
  return 0;
}
