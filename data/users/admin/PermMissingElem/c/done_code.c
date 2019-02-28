// you can write to stdout for debugging purposes, e.g.
// printf("this is a debug message\n");

int solution(int A[], int N) {
	// write your code in C99 (gcc 6.2.0)
  		double sum=0;
        for(inti=0;i<A.length;i++)
            sum+=A[i];
        doubleres=0.5*(A.length+1)*(A.length+2)-sum;
        return(int)res;
}
                            
                        