<?php
/**
 *
 * Create by PhpStorm
 * Author: shijianpeng<shijianpeng@doushen.com>
 * Date:  2020/6/26
 */
$source = array('A', 'B', 'C', 'D', 'E');

sort($source); //保证初始数组是有序的
$last = count($source) - 1; //$source尾部元素下标
$x = $last;
$count = 1; //组合个数统计
echo implode(',', $source), "\n"; //输出第一种组合
while (true) {
    $y = $x--; //相邻的两个元素
    if ($source[$x] < $source[$y]) { //如果前一个元素的值小于后一个元素的值
        $z = $last;
        while ($source[$x] > $source[$z]) { //从尾部开始，找到第一个大于 $x 元素的值
            $z--;
        }
        /* 交换 $x 和 $z 元素的值 */
        list($source[$x], $source[$z]) = array($source[$z], $source[$x]);
        /* 将 $y 之后的元素全部逆向排列 */
        for ($i = $last; $i > $y; $i--, $y++) {
            list($source[$i], $source[$y]) = array($source[$y], $source[$i]);
        }
        echo implode(',', $source), "\n"; //输出组合
        $x = $last;
        $count++;
    }
    if ($x == 0) { //全部组合完毕
        break;
    }
}
echo 'Total: ', $count, "\n";