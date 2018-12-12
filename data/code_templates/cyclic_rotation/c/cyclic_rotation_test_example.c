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
		
		printf ("Example test: (");
		print_arr(tests[i].A, tests[i].N);
		printf (", %d)", tests[i].K);
		
		printf ("\n");

		/* функция проверки результата */
		if ( cmp_arr(tests[i].R, result2.A, tests[i].N) == 0 )
			printf ("OK");
		else {
			printf ("WRONG ANSWER (got ");
			print_arr (result2.A, result2.N);
			printf (" expected ");
			print_arr (tests[i].R, tests[i].N);
			printf (")");
		}
		
		printf ("\n");
		printf ("\n");
	}

	return 0;
}
/* #<{(| УДАЛИТЬ ЭТУ ФУНКЦИЮ |)}># */
/* struct Results solution(int A[], int N, int K) { */
/*         struct Results result; */
/*         // write your code in C99 (gcc 6.2.0) */
/*         result.A = A; */
/*         result.N = N; */
/*  */
/*         if (K == N) */
/*                 return result; */
/*  */
/*         if (N == 1) */
/*                 return result; */
/*  */
/*         if (K == 0 || N == 0) */
/*                 return result; */
/*  */
/*         #<{(| if (K > N) |)}># */
/*         #<{(|         K = K % N; |)}># */
/*  */
/*         int i; */
/*         int j; */
/*         int B[N]; */
/*  */
/*         for (j = 0; j < K; ++j) { */
/*                 B[0] = A[N - 1]; */
/*  */
/*                 for (i = 0; i < N - 1; ++i) */
/*                         B[i + 1] = A[i]; */
/*  */
/*                 for (i = 0; i < N; ++i)  */
/*                         A[i] = B[i]; */
/*         } */
/*  */
/*         for (i = 0; i < N; ++i)  */
/*                 result.A[i] = B[i]; */
/*         result.N = N; */
/*  */
/*         return result; */
/* } */
