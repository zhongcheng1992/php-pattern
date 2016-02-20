<?php

/**
 * 栈 - 先进后出
*/
$stack = new SplStack();
$stack->push('data1');
$stack->push('data2');

echo $stack->pop() . PHP_EOL;
echo $stack->pop() . PHP_EOL;

/**
 * 队列 - 先进先出
*/
$queue = new SplQueue();
$queue->enqueue('data1');
$queue->enqueue('data2');
echo $queue->dequeue() . PHP_EOL;
echo $queue->dequeue() . PHP_EOL;

/**
 * 堆
*/
$heap = new SplMinHeap();
$heap->insert('data1');
$heap->insert('data2');

echo $heap->extract() . PHP_EOL;

/**
 * 固定长度数组
*/
$array = new SplFixedArray(10);
$array[0] = 0;
$array[9] = 9;
print_r($array);




