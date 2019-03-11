#include <stdio.h>
#include <stdlib.h>
#include "cyclic_rotation.h"

int main()
{
	int    i;
	int    j;
	struct Results result2;
	struct test_example tests[COUNT_EXAMPLE_TEST];

	tests[0] = (struct test_example){
		(int []){3, 8, 9, 7, 6}, 
		(int []){9, 7, 6, 3, 8}, 
		3, 
		5
	};

	tests[1] = (struct test_example){ 
		(int []){0, 0, 0}, 
		(int []){0, 0, 0}, 
		1, 
		3
	};

	tests[2] = (struct test_example){ 
		(int []){1, 2, 3, 4}, 
		(int []){1, 2, 3, 4}, 
		4, 
		4
	};
	

	for (i = 0; i < COUNT_EXAMPLE_TEST; ++i) {
		result2 = solution(tests[i].A, tests[i].N, tests[i].K);
		
		printf ("| ");
		
		printf ("Example test: (");
		print_arr(tests[i].A, tests[i].N);
		printf (", %d)", tests[i].K);
		
		printf (" | ");

		/* функция проверки результата */
		if ( cmp_arr(tests[i].R, result2.A, tests[i].N) == 0 )
			printf ("OK");
		else {
			printf ("WRONG ANSWER (got ");
			print_arr (result2.A, result2.N);
			printf (" expected ");
			print_arr (tests[i].R, tests[i].N);
			printf (")");
			printf (" | ");
		}
		
		printf (" | ");
		printf ("\n");
		printf ("\n");
	}

	return 0;
}
