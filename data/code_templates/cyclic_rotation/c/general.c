#include "general.h"

int cmp_arr(int one[], int two[], int N) {
	int i;
	
	for (i = 0; i < N; ++i) {
		if (one[i] != two[i])
			return 1;
	}
	return 0;
}

void print_arr(int A[], int N) {
	int i;

	printf ("[");
	for (i = 0; i < N; ++i) {
		if (i != N - 1) 
			printf ("%d, ", A[i]);
		else
			printf ("%d", A[i]);
	}

	printf ("]");
}

double round_up(double number, int digits) {
	double factor = pow(10, digits);
	return ceil(number * factor) / factor;
}


int random_between(int min, int max) {
	    return rand() % (max - min + 1) + min;
}

