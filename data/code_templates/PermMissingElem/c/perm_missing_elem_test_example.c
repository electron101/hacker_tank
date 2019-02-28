#include <stdio.h>
#include "perm_missing_elem.h"

int main()
{
	int    i;
	int    result;
	struct test_example tests[COUNT_EXAMPLE_TEST];

	tests[0] = (struct test_example){
		(int []){2, 3, 1, 5},
		4,
		4
	};

	for (i = 0; i < COUNT_EXAMPLE_TEST; ++i) {
		result = solution(tests[i].A, tests[i].N);
		
		printf ("| ");
		
		printf ("Example test: (");
		print_arr(tests[i].A, tests[i].N);
		printf (")");
		
		printf (" | ");

		/* функция проверки результата */
		if ( tests[i].R == result )
			printf ("OK");
		else {
			printf ("WRONG ANSWER (got %d", result);
			printf (" expected %d", tests[i].R);
			printf (")");
			printf (" | ");
		}
		
		printf (" | ");
		printf ("\n");
		printf ("\n");
	}
	return 0;
}
