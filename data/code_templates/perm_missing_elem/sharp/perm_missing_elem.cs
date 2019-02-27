using System;

namespace perm_missing_elem
{
	public static class PermMissingElem {
		public const int COUNT_EXAMPLE_TEST = 1;
		public const int COUNT_CORRECT_TEST = 12;
	};

	public struct test_struct {
		head_t headline_test;	/* заголовок теста */
		int[] a;	/* исходный набор данных */
		int   r;	/* ожидаемый набор данных */
		int   n;	/* число элементов в массиве */
		
		public void SetValueExample(int[] na, int nr, int nn) {
			a = na;
			r = nr;
			n = nn;
		}
		
		public void SetValueExtand(head_t nhead, int[] na, int nr, int nn) {
			headline_test = nhead;
			a = na;
			r = nr;
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

		public int R
		{
			get { return r; }
			set { r = value; }
		}
		
		public int N
		{
			get { return n; }
			set { n = value; }
		}
	};
}
