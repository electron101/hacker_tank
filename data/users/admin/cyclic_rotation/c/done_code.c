#include <time.h>
#include "cyclic_rotation.h"

int main()
{
 	int     i;
	int     j;
	struct  Results result2;
	struct  test_extend ext_tests[COUNT_EXAMPLE_TEST + COUNT_CORRECT_TEST];
	clock_t begin;
	clock_t end;
	double  time_spent;

	
	/*--------------*/
	/* EXAMPLE TEST */
	/*--------------*/
	
	/* Инициализация */
	
	ext_tests[0] = (struct test_extend) {
		EXAMPLE,
		"example1",
		"first example test",
		(int []) {3, 8, 9, 7, 6}, 
		(int []) {9, 7, 6, 3, 8}, 
		3, 
		5
	};

	ext_tests[1] = (struct test_extend) { 
		EXAMPLE,
		"example2",
		"second example test",
		(int []) {0, 0, 0}, 
		(int []) {0, 0, 0}, 
		1, 
		3
	};

	ext_tests[2] = (struct test_extend) { 
		EXAMPLE,
		"example3",
		"third example test",
		(int []) {1, 2, 3, 4}, 
		(int []) {1, 2, 3, 4}, 
		4, 
		4
	};


	/*--------------*/
	/* CORRECT TEST */
	/*--------------*/
	
	/* Инициализация */
	
	ext_tests[3] = (struct test_extend) {
		CORRECT,
		"extreme_empty",
		"empty array",
		(int []) {}, 
		(int []) {}, 
		89, 
		0
	};
	
	ext_tests[4] = (struct test_extend) {
		CORRECT,
		"single",
		"one element, 0 <= K <= 5",
		(int []) {-4}, 
		(int []) {-4}, 
		1, 
		1
	};
	
	ext_tests[5] = (struct test_extend) {
		CORRECT,
		"single",
		"one element, 0 <= K <= 5",
		(int []) {723}, 
		(int []) {723}, 
		3, 
		1
	};
	
	ext_tests[6] = (struct test_extend) {
		CORRECT,
		"single",
		"one element, 0 <= K <= 5",
		(int []) {464}, 
		(int []) {464}, 
		5, 
		1
	};
	
	ext_tests[7] = (struct test_extend) {
		CORRECT,
		"double",
		"two elements, K <= N",
		(int []) {5, -1000}, 
		(int []) {-1000, 5}, 
		1, 
		2
	};
	
	ext_tests[8] = (struct test_extend) {
		CORRECT,
		"double",
		"two elements, K <= N",
		(int []) {-9, 0}, 
		(int []) {-9, 0}, 
		2, 
		2
	};
	
	ext_tests[9] = (struct test_extend) {
		CORRECT,
		"small1",
		"small functional tests, K < N",
		(int []) {1, 2, 3, 4, 5, 6, 7}, 
		(int []) {6, 7, 1, 2, 3, 4, 5}, 
		2, 
		7
	};
	
	ext_tests[10] = (struct test_extend) {
		CORRECT,
		"small1",
		"small functional tests, K < N",
		(int []) {-1, -2, -3, -4, -5, -6, -7}, 
		(int []) {-2, -3, -4, -5, -6, -7, -1}, 
		6, 
		7
	};
	
	ext_tests[11] = (struct test_extend) {
		CORRECT,
		"small2",
		"small functional tests, K >= N",
		(int []) {1, 2, 3, 4, 5, 6, 7}, 
		(int []) {1, 2, 3, 4, 5, 6, 7}, 
		14,
		7
	};
	
	ext_tests[12] = (struct test_extend) {
		CORRECT,
		"small2",
		"small functional tests, K >= N",
		(int []) {-1, -2, -3, -4, -5, -6}, 
		(int []) {-3, -4, -5, -6, -1, -2}, 
		10, 
		6
	};
	
	ext_tests[13] = (struct test_extend) {
		CORRECT,
		"small2",
		"small functional tests, K >= N",
		(int []) {3, 5, 1, 1, 2}, 
		(int []) {3, 5, 1, 1, 2}, 
		5, 
		5
	};
	
	ext_tests[14] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {1, -1, 8, 6, 7, 4, 4, 1, -8, 5, 9, -3, -1, 0, 9}, 
		(int []) {9, 1, -1, 8, 6, 7, 4, 4, 1, -8, 5, 9, -3, -1, 0}, 
		1, 
		15
	};
	
	ext_tests[15] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {-7, 1, 4, -6, 6, -7, 9, 4, 3, 4, 9, 4, -8, 6, 10}, 
		(int []) {6, 10, -7, 1, 4, -6, 6, -7, 9, 4, 3, 4, 9, 4, -8}, 
		2, 
		15
	};
	
	ext_tests[16] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {-5, 2, 8, 5, 5, 9, 2, 4, -7, -3, 5, 6, 0, -4, -9}, 
		(int []) {0, -4, -9, -5, 2, 8, 5, 5, 9, 2, 4, -7, -3, 5, 6}, 
		3, 
		15
	};
	
	ext_tests[17] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {1, -2, 7, 10, -1, 10, 10, 10, 3, -8, -9, -4, 7, 0, -9},
		(int []) {-4, 7, 0, -9, 1, -2, 7, 10, -1, 10, 10, 10, 3, -8, -9},
		4, 
		15
	};
	
	ext_tests[18] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {7, -9, -6, 10, 3, 3, 10, 3, 0, 4, -2, 5, 9, 4, 10},
		(int []) {-2, 5, 9, 4, 10, 7, -9, -6, 10, 3, 3, 10, 3, 0, 4},
		5, 
		15
	};
	
	ext_tests[19] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {-9, 0, 3, -2, -2, -5, -2, -7, 1, 8, -5, -4, 7, -4, 1},
		(int []) {8, -5, -4, 7, -4, 1, -9, 0, 3, -2, -2, -5, -2, -7, 1},
		6, 
		15
	};
	
	ext_tests[20] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {5, 9, -4, -8, -6, 5, 4, -8, 1, -5, -9, 8, 1, -1, 9},
		(int []) {1, -5, -9, 8, 1, -1, 9, 5, 9, -4, -8, -6, 5, 4, -8},
		7, 
		15
	};
	
	ext_tests[21] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {9, -4, 10, 0, -7, 6, -8, 0, 4, 9, 6, -5, 6, -8, 2},
		(int []) {0, 4, 9, 6, -5, 6, -8, 2, 9, -4, 10, 0, -7, 6, -8},
		8, 
		15
	};
	
	ext_tests[22] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {6, -1, -9, 7, -5, -6, -4, 10, -8, -1, 2, -8, 10, 0, -6},
		(int []) {-4, 10, -8, -1, 2, -8, 10, 0, -6, 6, -1, -9, 7, -5, -6},
		9, 
		15
	};
	
	ext_tests[23] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {2, 6, 1, -1, -7, -6, 8, -7, 3, 9, 5, -8, -2, 10, 7},
		(int []) {-6, 8, -7, 3, 9, 5, -8, -2, 10, 7, 2, 6, 1, -1, -7},
		10, 
		15
	};
	
	ext_tests[24] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {-9, -5, 0, 1, 10, 2, 8, 10, 1, -1, 7, 7, 0, -9, -9},
		(int []) {10, 2, 8, 10, 1, -1, 7, 7, 0, -9, -9, -9, -5, 0, 1},
		11, 
		15
	};
	
	ext_tests[25] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {-8, 1, 4, 7, -4, 7, -9, 7, -1, -7, -5, 5, 6, 8, -6},
		(int []) {7, -4, 7, -9, 7, -1, -7, -5, 5, 6, 8, -6, -8, 1, 4},
		12, 
		15
	};
	
	ext_tests[26] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {-5, 3, -4, 3, 6, -4, 7, -6, -6, -3, -8, -9, 3, -6, 10},
		(int []) {-4, 3, 6, -4, 7, -6, -6, -3, -8, -9, 3, -6, 10, -5, 3},
		13, 
		15
	};
	
	ext_tests[27] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {5, 9, 10, 2, 0, 10, 5, 3, 4, 4, -5, -9, -7, 9, -6},
		(int []) {9, 10, 2, 0, 10, 5, 3, 4, 4, -5, -9, -7, 9, -6, 5},
		14, 
		15
	};
	
	ext_tests[28] = (struct test_extend) {
		CORRECT,
		"small_random_all_rotations",
		"small random sequence, all rotations, N = 15",
		(int []) {-8, 1, -2, 9, -9, -7, 1, 1, 7, 1, -2, 0, -3, 9, -9},
		(int []) {-8, 1, -2, 9, -9, -7, 1, 1, 7, 1, -2, 0, -3, 9, -9},
		15, 
		15
	};
	
	ext_tests[29] = (struct test_extend) {
		CORRECT,
		"medium_random",
		"medium random sequence, N = 100",
		(int []) {-94, 620, 201, 395, 215, -526, 579, 833, 231, 715, 
		-267, -340, -839, -374, 68, -282, -85, 273, -702, -993, 211, 
		152, -594, 167, -475, -276, 745, -677, -593, 697, -623, 314, 
		-126, 135, -735, 646, 609, 401, 479, -604, 116, -789, 56, 277, 
		-606, 681, 553, 310, -47, 851, -126, -836, 2, 280, -112, 84, 
		-996, -368, 408, 969, -671, 785, -161, -240, -524, -338, -595, 
		642, -938, 441, -963, -265, 209, 93, -988, 604, -669, 122, -530,
	       	284, -28, 344, 5, 531, -820, 894, -829, -816, -475, 579, 711, 
		-589, -80, -451, 171, 396, -232, 134, 37, -169},

		(int []) {-126, -836, 2, 280, -112, 84, -996, -368, 408, 969, 
		-671, 785, -161, -240, -524, -338, -595, 642, -938, 441, -963, 
		-265, 209, 93, -988, 604, -669, 122, -530, 284, -28, 344, 5, 
		531, -820, 894, -829, -816, -475, 579, 711, -589, -80, -451, 
		171, 396, -232, 134, 37, -169, -94, 620, 201, 395, 215, -526, 
		579, 833, 231, 715, -267, -340, -839, -374, 68, -282, -85, 273, 
		-702, -993, 211, 152, -594, 167, -475, -276, 745, -677, -593, 
		697, -623, 314, -126, 135, -735, 646, 609, 401, 479, -604, 116, 
		-789, 56, 277, -606, 681, 553, 310, -47, 851},

		50, 
		100
	};
	
	ext_tests[30] = (struct test_extend) {
		CORRECT,
		"medium_random",
		"medium random sequence, N = 100",
		(int []) {355, -779, -832, -329, 625, -969, -721, -295, 922, 
		-280, -730, -418, 460, -713, 14, -227, 860, 923, 295, 521, 
		-672, 343, 237, -979, 3, -51, 795, -130, 34, 140, 886, 946, 
		-82, 611, -827, -901, 199, -547, -195, 121, 173, -368, 260, 
		-810, -80, -727, -480, -664, -804, 815, 857, -476, -286, -350, 
		-454, 274, 599, -660, -857, -811, 37, 586, 692, 955, 197, 866, 
		-946, -605, 876, -584, 516, -395, 48, -225, -205, 525, 49, 316, 
		861, -198, -313, 274, 326, 402, 925, 429, -325, 80, 327, -624, 
		-173, -637, 962, -925, -682, -285, 498, 930, 111, 373},

		(int []) {-51, 795, -130, 34, 140, 886, 946, -82, 611, -827, 
		-901, 199, -547, -195, 121, 173, -368, 260, -810, -80, -727, 
		-480, -664, -804, 815, 857, -476, -286, -350, -454, 274, 599, 
		-660, -857, -811, 37, 586, 692, 955, 197, 866, -946, -605, 876, 
		-584, 516, -395, 48, -225, -205, 525, 49, 316, 861, -198, -313, 
		274, 326, 402, 925, 429, -325, 80, 327, -624, -173, -637, 962, 
		-925, -682, -285, 498, 930, 111, 373, 355, -779, -832, -329, 
		625, -969, -721, -295, 922, -280, -730, -418, 460, -713, 14, 
		-227, 860, 923, 295, 521, -672, 343, 237, -979, 3},
		
		75, 
		100
	};

	ext_tests[31] = (struct test_extend) {
		CORRECT,
		"maximal",
		"maximal N and K",
		(int []) {-695, -16, -247, -598, -808, -753, -980, -191, -387, 
		 361, 34, -806, -84, -801, 357, 515, -336, -770, -37, 568, -703,
		-811, -963, -654, 608, 470, -320, 180, -113, 376, 473, -251,
		-641, -774, 151, -892, -527, 172, -82, -357, -911, 952, -606, 5,
	       	-850, 308, -924, -629, 538, 39, 940, 836, 228, 534, 739, -608,
		   3, 976, 129, 447, -92, -398, -805, -175, -172, 347, -67, -142,
		-925, 851, 501, -836, 803, 895, -274, 510, 203, -198, 882, -703,
	       	 398, 378, 690, -817, -89, -15, -425, 914, -40, 705, 361, 869,
		-694, 113, -307, -309, -541, 626, 106, -466},
		
		(int []) {-695, -16, -247, -598, -808, -753, -980, -191, -387, 
		361, 34, -806, -84, -801, 357, 515, -336, -770, -37, 568, -703, 
		-811, -963, -654, 608, 470, -320, 180, -113, 376, 473, -251, 
		-641, -774, 151, -892, -527, 172, -82, -357, -911, 952, -606, 5,
	       	-850, 308, -924, -629, 538, 39, 940, 836, 228, 534, 739, -608, 
		3, 976, 129, 447, -92, -398, -805, -175, -172, 347, -67, -142, 
		-925, 851, 501, -836, 803, 895, -274, 510, 203, -198, 882, -703,
	       	398, 378, 690, -817, -89, -15, -425, 914, -40, 705, 361, 869, 
		-694, 113, -307, -309, -541, 626, 106, -466},
		
		100,
		100
	};

	/* Вывод в консоль */
	for (i = 0; i < COUNT_EXAMPLE_TEST + COUNT_CORRECT_TEST; ++i) {
		/* errno = 0; */
		begin = clock();
		result2 = solution(ext_tests[i].A, 
				ext_tests[i].N, ext_tests[i].K);
		end = clock();
		
		/* if (errno != 0) */
		/* 	fprintf(stderr, "printf failed!\n"); */
		
		/* время в секундах */
		time_spent = (double)(end - begin) / CLOCKS_PER_SEC;
		// /* округление секунд до тысячных (0.001) или (0.034) */
		// time_spent = round((time_spent) * 1000 + 0.5) / 1000; 
		
		out_to_console (result2, ext_tests[i], time_spent);
	}

	return 0;
}
// you can write to stdout for debugging purposes, e.g.
// printf("this is a debug message\n");

/* УДАЛИТЬ ЭТУ ФУНКЦИЮ */
struct Results solution(int A[], int N, int K) {
        struct Results result;
        // write your code in C99 (gcc 6.2.0)
        result.A = A;
        result.N = N;

        if (K == N)
                return result;

        if (N == 1)
                return result;

        if (K == 0 || N == 0)
                return result;

        /* if (K > N) */
        /*         K = K % N; */

        int i;
        int j;
        int B[N];

        for (j = 0; j < K; ++j) {
                B[0] = A[N - 1];

                for (i = 0; i < N - 1; ++i)
                        B[i + 1] = A[i];

                for (i = 0; i < N; ++i) 
                        A[i] = B[i];
        }

        for (i = 0; i < N; ++i) 
                result.A[i] = B[i];
        result.N = N;

        return result;
}
