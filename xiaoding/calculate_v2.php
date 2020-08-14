<?php
/**
 *
 * Create by PhpStorm
 * Author: shijianpeng<shijianpeng@doushen.com>
 * Date:  2020/6/26
 */

// 定义P
const PI = 3.14;


// 获取X轴对应弧度数
function getYMachineData(int $num)
{
    $mathine = [];

    for ($i = 0; $i < $num; $i++) {
        $mathine[$i] = cos($i * ((2 * PI) / $num));
    }

    return $mathine;
}

// 获取X轴对应弧度数
function getXMachineData(int $num)
{
    $mathine = [];

    for ($i = 0; $i < $num; $i++) {
        $mathine[$i] = sin($i * ((2 * PI) / $num));
    }

    return $mathine;
}

//获取所有质量总和
function getSumuality($leafs)
{
    $quality = 0;

    foreach ($leafs as $list => $value) {
        $quality += $value;
    }

    return $quality;
}


// 获取组合数
function rangeLeafs(array $leafs){

    $source = array_keys($leafs);

    sort($source); //保证初始数组是有序的
    $last = count($source) - 1; //$source尾部元素下标
    $x = $last;
    $count = 1; //组合个数统计

    $list = implode(',', $source);
    $result = [];
    $result['min'] = getSingleResult($list,$leafs);
    $result['list'] = $list;
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
            $list = implode(',', $source); //存其他组合
            $mid = getSingleResult($list,$leafs);

            if ($mid <= $result['min'])
            {
                $result['min'] = $mid;
                $result['list'] = $list;
            }

            $x = $last;
            $count++;
        }
        if ($x == 0) { //全部组合完毕
            break;
        }
    }

    return $result;
}


function getFileData($fileName)
{
    if (!file_exists($fileName)) {
        echo "file not exists.";
        die();
    }
    //$str = file_get_contents($fileName);
    $handler = file($fileName);
    $data = [];
    foreach ($handler as $l => $v) {
        $data['Line_' . $l] = floatval($v);
    }
    return $data;
}


// 计算
function getSingleResult($ranges, $leafs)
{
    $num = count($leafs);

    $arrList = explode(',', $ranges);
    $arrX = getXMachineData($num);
    $resX = 0;
    foreach ($arrList as $k => $v) {
        $m = $leafs[$v];
        $coefficientX = $arrX[$k];
        $resX += $m * $coefficientX;
    }

    $arrY = getYMachineData($num);
    $resY = 0;
    foreach ($arrList as $k => $v) {
        $m = $leafs[$v];
        $coefficientY = $arrY[$k];
        $resY += $m * $coefficientY;
    }
    $res = sqrt(abs($resX) * abs($resX) + abs($resY) * abs($resY));
    return $res;
}



$fileName = 'test.txt';
//叶片
$time = [];
$time['start'] = microtime(true);
$leafs = getFileData($fileName);
$ranges = rangeLeafs($leafs);
$time['end']  = microtime(true);
$time['during'] = $time['end'] - $time['start'];
var_dump($ranges,$time);
die();


