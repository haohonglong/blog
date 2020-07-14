<?php

function unique_rand($min, $max, $num) {

    $arr = array();
    while (count($arr) < $num) {
        $n = mt_rand($min, $max);

        if(strlen($n) != 7 || in_array($n,$arr)){
            continue;
        }
        $arr[] = $n;
//        $arr = array_flip(array_flip($arr));
    }
//    shuffle($arr);
    return $arr;
}
function bubble_sort($arr) {
    $size = count($arr);
    for ($i=0; $i<$size; $i++) {
        $fla = true;
        for ($j=$i+1; $j<$size; $j++) {
            if ($arr[$i] > $arr[$j]) {
                swap($arr, $i, $j);
                $fla = false;
            }
        }
        if($fla && $i) {
            echo $i;
            echo "\n";
            break;
        }

    }
    return $arr;
}

function combSort($arr) {
    $size = count($arr);
    $step = $size;
    // 第一部分
    while(($step /= 1.3) > 1) {
        for ($i = $size-1; $i >= $step; $i--) {
            $k = $i -$step;
            if($arr[$k]>$arr[$i]){
                // 交换位置
                swap($arr, $k, $i);
            }
        }
    }
    // 第二部分：进行冒泡排序
    return bubble_sort($arr);
}



function swap(&$arr, $a, $b) {
    $tmp = $arr[$a];
    $arr[$a] = $arr[$b];
    $arr[$b] = $tmp;
}


$arr = unique_rand(0, 9999999, 20000);
$arr = combSort($arr);
print_r($arr);




function shellSort($arr){
    $size = count($arr);
    $h = 1;
    // 增量序列
    while($h < $size/3){
        // h = 1,4,13,40,……
        $h = $h*3 + 1;
    }

    while($h>=1){
        for ($i = $h; $i < $size; $i++) {
            // 进行插入排序，诺a[j]比a[j-h]小，则向前挪动h
            for ($j = $i; $j >= $h && $arr[$j-$h]>$arr[$j]; $j -= $h) {
                swap($arr, $j, $j-$h);
            }
        }
        $h /= 3;
    }
    return $arr;
}

