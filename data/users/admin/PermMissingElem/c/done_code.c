// you can write to stdout for debugging purposes, e.g.
// printf("this is a debug message\n");

int solution(int A[], int N) {
        // write your code in C99 (gcc 6.2.0)
        int i;
        int tmp_count = 0;
        int tmp_zero  = -1;
        int B[1000000] = {0};

        for (i = 0; i < N; ++i) 
                B[A[i]] = 1;

        for (i = 1; i < 1000000; ++i) {
                if (tmp_count == N) {
                    if (tmp_zero == -1)
                        tmp_zero = N + 1;
                    return tmp_zero;
                }
       
                if (B[i] == 1)
                        tmp_count++;
                
                if (B[i] == 0)
                        tmp_zero = i;
        }
        return tmp_zero;
}
                            
                        