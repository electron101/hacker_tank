#ifndef GENERAL_H
#define GENERAL_H

#include <stdio.h>
#include <stdlib.h>
#include <math.h>

enum category_test {
	EXAMPLE,
	CORRECT,
	PERFORM
};

/* заголовок теста */
typedef struct {
	enum category_test category;	/* категория теста */
	char *name_test;		/* имя теста */
	char *help;			/* описание теста */
} head_t;


/* Сравнение двух массивов. Возвращаемое значение: 
 * 0   - если массивы равны
 * 1   - если массивы не равны */
int cmp_arr(int one[], int two[], int N);

/* Печать массива. Выходной формат [3, 8, 9, 7, 6] */
void print_arr(int A[], int N);

/* Округление числа(number) до digits знаков после запятой */
double round_up(double number, int digits);

/* Сулчайное число от min до max */
int random_between(int min, int max);

#endif
