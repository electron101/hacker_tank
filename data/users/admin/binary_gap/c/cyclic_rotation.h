#ifndef CYCLIC_ROTATION_H
#define CYCLIC_ROTATION_H

#include "general.h"

#define COUNT_EXAMPLE_TEST 3
#define COUNT_CORRECT_TEST 29

struct Results {
	int *A;
	int N; // Length of the array
};

struct test_extend {
	head_t headline_test;	/* заголовок теста */
	int    *A;		/* исходный набор данных */
	int    *R;		/* ожидаемый набор данных */
	int    K;		/* число смещений */
	int    N;		/* число элементов в массиве */
};

struct test_example {
	int  *A;		/* исходный набор данных */
	int  *R;		/* ожидаемый набор данных */
	int  K;			/* число смещений */
	int  N;			/* число элементов в массиве */
};

/* Прототипы */
struct Results solution(int A[], int N, int K);

/*
 * Печать на консоль.
 * Пример вывода:
 * 1 | double | two elements, K <= N | 0.001 | 0 | WRONG ANSWER (got [-1000, 32765] expected [-1000, 5]) |
 * 0 | example3 | third example test | 1 | OK
 */
void out_to_console(struct Results result2, struct test_extend tests, 
		double time_spent) {
	int i;
	int ok;

	ok =  cmp_arr(tests.R, result2.A, tests.N);

	/* инверсия результата, 0 - тест не пройден, 1 - тест пройден */
	if (ok == 0)
		ok = 1;
	else 
		ok = 0;

	printf ("%d | %s | %s | %.3f | %d | ", 
			tests.headline_test.category, 
			tests.headline_test.name_test, 
			tests.headline_test.help, 
			round_up(time_spent, 3),
			ok );

	/* если тест пройден и массивы верны */
	if ( ok == 1 )
		printf ("OK");
	else {
		printf ("WRONG ANSWER (got ");
		print_arr (result2.A, result2.N);
		printf (" expected ");
		print_arr (tests.R, tests.N);
		printf (")");
	}
	printf (" |");
	printf ("\n");
}

// void out_to_console(head_t test, double time_spent, int ok) {
//
// 	printf ("%d | %s | %s | %.3f | %d | ", test.category, test.name_test, 
// 			test.help, time_spent, ok );
//
// 	if ( ok == 1 )
// 		printf ("OK");
// 	else {
// 		printf ("WRONG ANSWER (got ");
// 		print_arr (result2.A, result2.N);
// 		printf (" expected ");
// 		print_arr (tests.R, tests.N);
// 		printf (")");
// 	}
// 	printf (" |");
// 	printf ("\n");
// }
//
// void check_solution(struct Results result2, struct test_extend tests, 
// 		double time_spent) {
// 	int ok;
// 	
// 	ok =  cmp_arr(tests.R, result2.A, tests.N);
// 	
// 	/* инверсия результата, 0 - тест не пройден, 1 - тест пройден */
// 	if (ok == 0)
// 		ok = 1;
// 	else 
// 		ok = 0;
//
// 	out_to_console( tests.headline_test, time_spent, ok );
// 	// out_to_console( tests.category, tests.name_test, 
// 	// 		tests.help, time_spent, ok );
// }

#endif
