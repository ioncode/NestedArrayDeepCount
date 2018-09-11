<?php
/**
 * Created by PhpStorm.
 * User: Андрей Сергеевич
 * Date: 11.09.2018
 * Time: 14:05
 */

namespace test;

//Необходимо написать функцию, которая получает на вход массив и определяет уровень вложенности полученного массива.
//В случае если массив содержит цикл, например, через ссылку, функция должна вернуть false.

/**
 * @param array $array
 * @param int $deep
 * @return bool|int
 */
function checker (array $array, $deep=0){
//    echo 'Start with array from '.count($array)." elements on level ".$deep.PHP_EOL;
    try{

        $nestedArrays=array_filter($array, function ($item, $key){
            if (is_callable($item)){
                throw new \Exception;
            }
            elseif (is_array($item)) {
                return true;
            }
        }, ARRAY_FILTER_USE_BOTH);
        if ($nestedArrays){
            $deep++;
            foreach ($nestedArrays as $nestedArray){
                return checker($nestedArray, $deep);
            }
        }
    }
    catch (\Exception $e){
        return false;
    };
    return $deep;
}

$loop=function (){

    for($i = 1; $i <= 10; $i++){
        echo $i;
        return $i;
    }

};

$falseTest=[
    "var",
    'string',
    [1, [6, 7, 8], 3],
    null,
    function(){
        for($i = 1; $i <= 10; $i++){
            echo $i;
        }
    },
    &$loop
];
$deepTest=[
    "var",
    [1, [6, [1, [6, 7, 8], 3], 8], 3],
    'string',
    [1, [6, 7, 8], 3],
    null,
];

var_dump([checker($falseTest), checker($deepTest), checker(['key'=>'val'])]);