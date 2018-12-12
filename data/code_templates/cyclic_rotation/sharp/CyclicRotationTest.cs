using System;

namespace cyclic_rotation
{
	public static class CyclicRotationTest {
		public const int COUNT_EXAMPLE_TEST = 3;
		public const int COUNT_CORRECT_TEST = 29;
	};

	public struct test_struct {
		head_t headline_test;	/* заголовок теста */
		int[]  a;	/* исходный набор данных */
		int[]  r;	/* ожидаемый набор данных */
		int    k;	/* число смещений */
		int    n;	/* число элементов в массиве */
		
		public void SetValueExample(int[] na, int[] nr, int nk, int nn) {
			a = na;
			r = nr;
			k = nk;
			n = nn;
		}
		
		public void SetValueExtand(head_t nhead, int[] na, int[] nr, int nk, int nn) {
			headline_test = nhead;
			a = na;
			r = nr;
			k = nk;
			n = nn;
		}
		
		public head_t Head
		{
			get { return headline_test; }
			set { headline_test = value; }
		}

		public int[] A
		{
			get { return a; }
			set { a = value; }
		}

		public int[] R
		{
			get { return r; }
			set { r = value; }
		}
		
		public int K
		{
			get { return k; }
			set { k = value; }
		}
		
		public int N
		{
			get { return n; }
			set { n = value; }
		}
	};
}
