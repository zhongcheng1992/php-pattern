<?php
/**
* levenshtein() 函数用法
* 计算两个字符串之间的编辑距离
*/

$params = $_SERVER['argv'];

// 输入数据或默认拼写错误的单词
$input = isset($params[1]) ? $params[1] : 'carrrot';

// 要检查的单词数组
$words  = ['apple','pineapple','banana','orange','radish','carrot','pea','bean','potato'];

// 目前没有找到最短距离
$shortest = -1;

// 遍历单词来找到最接近的
foreach ($words as $key =>  $word) {

    // 计算输入单词与当前单词的距离
    $lev = levenshtein($input, $word);

    $log = '[' . $key . '] Compare ' . $input . ' with ' . $word . '; Diff level: ' . $lev . PHP_EOL;

    // 检查完全的匹配
    if ($lev == 0) {

        // 最接近的单词是这个（完全匹配）
        $closest = $word;
        $shortest = 0;

        // 退出循环；我们已经找到一个完全的匹配
        break;
    }

    // 如果此次距离比上次找到的要短
    // 或者还没找到接近的单词
    if ($lev <= $shortest || $shortest < 0) {
        // 设置最接近的匹配以及它的最短距离
        $closest  = $word;
        $shortest = $lev;
    }
    echo $log;
}

echo "Input word: $input\n";
if ($shortest == 0) {
    echo "Exact match found: $closest\n";
} else {
    echo "Did you mean: $closest?\n";
}
