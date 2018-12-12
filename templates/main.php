<!-- Основная страница -->
<style>
    .CodeMirror {border-top: 1px solid #888; border-bottom: 1px solid #888;}
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
            <div class="col-xs-5">
                <div class="col-xs-12" style="margin-bottom: 5px;">
                <b>Cyclic Rotation</b>
                </div>
                <div class="col-xs-12">
<p>
 An array A consisting of N integers is given. Rotation of the array means that each element is shifted right by one index, and the last element of the array is moved to the first place. For example, the rotation of array A = [3, 8, 9, 7, 6] is [6, 3, 8, 9, 7] (elements are shifted right by one index and 6 is moved to the first place).
</p>
<p>
The goal is to rotate array A K times; that is, each element of A will be shifted to the right K times.
</p>
<p>
Write a function:
</p>
<p style="font-family: consolas;">class Solution { public int[] solution(int[] A, int K); } </p>
<p>
that, given an array A consisting of N integers and an integer K, returns the array A rotated K times.
</p>
<p>
For example, given
</p>
<p>
    A = [3, 8, 9, 7, 6]<br>
    K = 3
</p>
<p>
the function should return [9, 7, 6, 3, 8]. Three rotations were made:
</p>
<p>
    [3, 8, 9, 7, 6] -> [6, 3, 8, 9, 7]<br>
    [6, 3, 8, 9, 7] -> [7, 6, 3, 8, 9]<br>
    [7, 6, 3, 8, 9] -> [9, 7, 6, 3, 8]<br>
</p>
<p>
For another example, given
</p>
<p>
    A = [0, 0, 0]<br>
    K = 1
</p>
<p>
the function should return [0, 0, 0]
</p>
Given
<p>
    A = [1, 2, 3, 4]<br>
    K = 4
</p>
<p>
the function should return [1, 2, 3, 4]
</p>
<p>
Assume that:
</p>
<p>
N and K are integers within the range [0..100];
each element of array A is an integer within the range [−1,000..1,000].
In your solution, focus on correctness. The performance of your solution will not be the focus of the assessment.
</p>
                </div>
            </div>
            <div class="col-xs-7">
                <div class="col-xs-8">
                    <select name="keymap" id="keymap" class="form-control select" style="width: 120px;">
                        <option value="0" selected>Обычный</option>
                        <option value="1">VIM</option>
                    </select>
                </div>
                <div class="col-xs-2" style="margin-bottom: 5px;">
                    <select name="lang" id="lang" class="form-control select" style="width: 120px;">
                        <option value="0" selected>C</option>
                        <option value="1">C#</option>
                    </select>
                </div>
                <div class="col-xs-2" style="border: 0px solid black;">
                    <button type="button" class="btn btn-primary" id="apply" value="full" style="margin-left:15px;"><i class="fa fa-check"></i> Подтвердить</button>
                </div>

                <div class="col-xs-12">
                    <textarea id="c-code">
using System;
// you can also use other imports, for example:
// using System.Collections.Generic;

// you can write to stdout for debugging purposes, e.g.
// Console.WriteLine("this is a debug message");

class Solution {
    public int solution(int N) {
        // write your code in C# 6.0 with .NET 4.5 (Mono)
    }
}
                    </textarea>
                    <div style="font-size: 13px; width: 300px; height: 30px;">Key buffer: <span id="command-display"></span></div>
                    </div>
                    <div class="col-xs-12">
                    <div class="col-xs-10" style="background-color: #eeeeee; min-height: 40px; padding: 2px;"><b>Вывод</b></div>
                    <div class="col-xs-2" style="background-color: #eeeeee; min-height: 40px;  padding: 2px;"><button type="button" class="btn btn-success" id="run" value="test" style="margin-left:15px;"><i class="fa fa-play"></i> Запуск</button></div>
                    </div>
                    <div class="col-xs-12" id="output">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>