using System;
// you can also use other imports, for example:
// using System.Collections.Generic;

// you can write to stdout for debugging purposes, e.g.
// Console.WriteLine("this is a debug message");

class Solution {
	public int solution(int[] A) {
		// write your code in C# 6.0 with .NET 4.5 (Mono)
      double sum=0;
      for(inti=0;i<A.length;i++)
        sum+=A[i];
      doubleres=0.5*(A.length+1)*(A.length+2)-sum;
      return(int)res;
	}
}
