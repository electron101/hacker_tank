using System;

namespace perm_missing_elem
{
	public enum category_test {
		EXAMPLE,
		CORRECT,
		PERFORM
	};

	// headline_test_extend 
	public struct head_t {
		public category_test category;	/* категория теста */
		public string name_test;	/* имя теста */
		public string help;		/* имя теста */


		public head_t(category_test ncategory, string nname_test, string nhelp)
		{
			category  = ncategory;
			name_test = nname_test;
			help      = nhelp;
		}
		
		public category_test Category
		{
			get { return category; }
			set { category = value; }
		}

		public string Name_test
		{
			get { return name_test; }
			set { name_test = value; }
		}

		public string Help
		{
			get { return help; }
			set { help = value; }
		}
	};
	
	static public class General
	{
		/* Печать массива. Выходной формат [3, 8, 9, 7, 6] */
		public static void print_arr(int[] A, int N) {
			int i;

			Console.Write("[");
			for (i = 0; i < N; ++i) {
				if (i != N - 1) 
					Console.Write("{0}, ", A[i]);
				else
					Console.Write("{0}", A[i]);
			}

			Console.Write("]");
		}

		/* Округление числа(number) до digits знаков после запятой */
		public static double round_up(double number, int digits)
		{
			    double factor = Convert.ToDouble(Math.Pow(10, digits));
			    return Math.Ceiling(number * factor) / factor;
		}
		
		/*
		 * Печать на консоль.
		 * Пример вывода:
		 * 1 | double | two elements, K <= N | 0.001 | 0 | WRONG ANSWER (got [-1000, 32765] expected [-1000, 5]) |
		 * 0 | example3 | third example test | 1 | OK
		 */
		public static void out_to_console(int result, test_struct tests, 
				double time_spent) {
			int ok;
			
			if (tests.R == result)
				ok = 1;
			else 
				ok = 0;
				
					Console.Write("{0} | {1} | {2} | {3:F3} | {4} | ", 
					tests.Head.Category,
					tests.Head.Name_test, 
					tests.Head.Help, 
					round_up(time_spent, 3),
					ok );

			/* если тест пройден и массивы верны */
			if ( ok == 1 )
				Console.Write("OK");
			else {
				Console.Write("WRONG ANSWER (got ");
				Console.Write("{0}", result);
				Console.Write(" expected ");
				Console.Write("{0}", tests.R);
				Console.Write(")");
			}
			Console.Write (" |");
			Console.Write ("\n");
		}
	}
}
