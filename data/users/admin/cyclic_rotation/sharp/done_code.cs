using System;

namespace cyclic_rotation
{ 
	class MainClass
	{
		public static void Main (string[] args)
		{
			int i;
			int[] result2;
			test_struct[] tests = new test_struct[3]; 
	
			tests[0].SetValueExample( 
				new int[]{3, 8, 9, 7, 6}, 
				new int[]{9, 7, 6, 3, 8}, 
				3, 
				5
			);
			
			tests[1].SetValueExample( 
				new int[]{0, 0, 0},
				new int[]{0, 0, 0}, 
				1, 
				3
			);
			
			tests[2].SetValueExample( 
				new int[]{1, 2, 3, 4},
				new int[]{1, 2, 3, 4}, 
				4, 
				4
			);
			
			Solution s = new Solution();
			
			for (i = 0; i < 3; ++i) {
				result2 = s.solution(tests[i].A, 
						tests[i].K);

				Console.Write("Example test: (");
				General.print_arr(tests[i].A, tests[i].N);
				Console.Write(", {0})", tests[i].K);
				
				Console.Write("\n");

				/* функция проверки результата */
				if ( General.cmp_arr(tests[i].R, result2, tests[i].N) == 0 )
					Console.Write("OK");
				else {
					Console.Write("WRONG ANSWER (got ");
					General.print_arr (result2, result2.Length);
					Console.Write(" expected ");
					General.print_arr (tests[i].R, tests[i].N);
					Console.Write(")");
				}

				Console.Write("\n");
				Console.Write("\n");
			}
		}
	}
}
// you can also use other imports, for example:
// using System.Collections.Generic;

// you can write to stdout for debugging purposes, e.g.
// Console.WriteLine("this is a debug message");

class Solution {
    public int[] solution(int[] A, int K) {
        // write your code in C# 6.0 with .NET 4.5 (Mono)
      K = K+1;
       int l = A.Length;
            int start = l - K;
            int [] outA = new int [l];
            int j = 0;
            if (l == 0 || K == 0)
            {
                return A;
            }
            if (start < 0)
            {
                start = -(start - 1);
            }
            for (int i = start; i < l; i++)
            {
                outA[j] = A[i];
                j++;
            }
            for (int m = 0; m < start; m++)
            {
                outA[j] = A[m];
                j++;
            }
            return outA;
    }
}
