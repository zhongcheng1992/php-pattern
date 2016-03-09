<?php

/**
 * `<=>` combined comparison operator
 * PHP7 太空船操作符,又称组合（结合）比较运算符.
 * 语法形如: $a = $b <=> $c;
 * 如果两边相等则返回0，如果$b大于$c 则返回1， 如果$c大于$b 则返回-1.
 *
*/
$a = rand(1, 10);
$b = rand(1, 10);

$c = $a <=> $b;
echo '$a = ' . $a . ', and $b = ' . $b . ', ($a <=> $b) === ' . $c . PHP_EOL;

/**
 * `??` null coalescing operator
 * PHP7 空合并运算符.
 * 语法形如: $c = $a ?? $b;
 * 如果$a已经定义，未被注销且不为null, 就将$a赋值给$c, 否则将$b赋值给$c.
 * 注意: 如果空合并运算符前边的变量不存在时不会报错, 如果后边的变量不存在, 则会触发E_NOTICE级别的错误
*/

// $a = null;   //赋值$b
// unset($a);   //赋值$b
// unset($b);   //PHP Notice错误

$c = $a ?? $b;
echo '$a = ' . $a . ', and $b = ' . $b . ', ($a ?? $b) === ' . $c . PHP_EOL;
