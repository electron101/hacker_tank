#ifndef PERM_MISSING_ELEM_H
#define PERM_MISSING_ELEM_H

#include "general.h"

#define COUNT_EXAMPLE_TEST 1
#define COUNT_CORRECT_TEST 12

struct test_extend {
	head_t headline_test;	/* заголовок теста */
	int    *A;		/* исходный набор данных */
	int    R;		/* ожидаемый набор данных */
	int    N;		/* число элементов в массиве */
};

struct test_example {
	int  *A;	/* исходный набор данных */
	int  R;		/* ожидаемый набор данных */
	int  N;		/* число элементов в массиве */
};

/* Прототипы */
int solution(int A[], int N);

/*
 * Печать на консоль.
 * Пример вывода:
 * 1 | double | two elements, K <= N | 0.001 | 0 | WRONG ANSWER (got [-1000, 32765] expected [-1000, 5]) |
 * 0 | example3 | third example test | 1 | OK
 */
void out_to_console(int result, struct test_extend tests, 
		double time_spent) {
	int i;
	int ok;

	if (tests.R == result)
		ok = 1;
	else 
		ok = 0;

	printf ("%d | %s | %s | %.3f | %d | ", 
			tests.headline_test.category, 
			tests.headline_test.name_test, 
			tests.headline_test.help, 
			round_up(time_spent, 3),
			ok );

	/* если тест пройден */
	if ( ok == 1 )
		printf ("OK");
	else {
		printf ("WRONG ANSWER (got ");
		printf ("%d", result);
		printf (" expected ");
		printf ("%d", tests.R);
		printf (")");
	}
	printf (" |");
	printf ("\n");
}

#endif
