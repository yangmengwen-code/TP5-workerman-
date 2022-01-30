<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function pickItemColumnAsKey($arr, $key, $unique = false)
{
    $newArr = array();
    if (!empty($arr)) {
        foreach ($arr as $row) {
            if (is_object($row)) {
                if (isset($row->$key)) {
                    $newRow = $row;
                    $newKey = strval($row->$key);
                    if (!isset($newArr[$newKey])) {
                        $newArr[$newKey] = array();
                    }

                    if ($unique) {
                        $newArr[$newKey] = $newRow;
                    } else {
                        $newArr[$newKey][] = $newRow;
                    }
                }

            } else if (is_array($row)) {
                if (isset($row[$key])) {
                    $newRow = $row;
                    $newKey = strval($row[$key]);
                    if (!isset($newArr[$newKey])) {
                        $newArr[$newKey] = array();
                    }

                    if ($unique) {
                        $newArr[$newKey] = $newRow;
                    } else {
                        $newArr[$newKey][] = $newRow;
                    }
                }
            }
        }
    }

    return $newArr;
}