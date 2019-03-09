using System;

namespace perm_missing_elem
{ 
	class MainClass
	{
		public static void Main (string[] args)
		{
			int i;
			int result;
			// test_struct[] tests = new test_struct[COUNT_EXAMPLE_TEST]; 
			test_struct[] tests = new test_struct[1]; 
	
			tests[0].SetValueExample( 
				new int[]{2, 3, 1, 5},
				4, 
				4
			);
			
			Solution s = new Solution();
			
			for (i = 0; i < 1; ++i) {
				result = s.solution(tests[i].A);

				Console.Write("| ");
				
				Console.Write("Example test: (");
				General.print_arr(tests[i].A, tests[i].N);
				Console.Write(")");
				
				Console.Write(" | ");

				/* функция проверки результата */
				if ( tests[i].R == result )
					Console.Write("OK");
				else {
					Console.Write("WRONG ANSWER (got {0}", result);
					Console.Write(" expected {0}", tests[i].R);
					Console.Write(")");
					Console.Write(" | ");
				}

				Console.Write(" | ");
				Console.Write("\n");
				Console.Write("\n");
			}
		}
	}
}
