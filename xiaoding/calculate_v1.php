<?php
/**
 *
 * Create by PhpStorm
 * Author: shijianpeng<shijianpeng@doushen.com>
 * Date:  2020/6/26
 */

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
function rangeLeafs(array $leafs)
{

    $source = array_keys($leafs);
    $arrRangeLeafs = [];

    sort($source); //保证初始数组是有序的
    $last = count($source) - 1; //$source尾部元素下标
    $x = $last;
    $count = 1; //组合个数统计
    $arrRangeLeafs[] = implode(',', $source); //存第一种组合
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
            $arrRangeLeafs[] = implode(',', $source); //存其他组合
            $x = $last;
            $count++;
        }
        if ($x == 0) { //全部组合完毕
            break;
        }
    }

    return $arrRangeLeafs;
}

// 读数据
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
function getResult($ranges, $leafs)
{
    $resList = [];//结果集
    $num = count($leafs);
    foreach ($ranges as $list => $value) {
        $arrList = explode(',', $value);
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
        $resList[$list][] = sqrt(abs($resX) * abs($resX) + abs($resY) * abs($resY));
    }

    return $resList;
}


$fileName = 'test.txt';
// 获取叶片质量数据
$leafs = getFileData($fileName);
// 读取叶片数量
$aLLQuality = getSumuality($leafs);
// 获取排序
$ranges = rangeLeafs($leafs);
$result = getResult($ranges, $leafs);
$min = min($result);
$subscript = array_search(min($result), $result);

$result = [];
$result['min'] = $min;
$result['list'] = $ranges[$subscript];
var_dump($result);
die();


