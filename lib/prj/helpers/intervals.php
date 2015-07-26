<?php
function make_intervals($array){
    $return = array();
    sort($array);
    $end = 0;
    $start = 0;
    foreach($array as  $k=>$value){
        if(!$start)
            $start = $value;
        if(!$end)
            $end = $value;
        if(isset($array[$k+1]))
            $nextValue = $array[$k+1];
        else
            $nextValue = $value;
        if($nextValue != $value+1){
            if($start==$end){
                $return[] = $start;
            }else{
                $return[] = $start.'-'.$end;
            }
            $start=0;
            $end=0;
        }else{
            $end = $nextValue;
        }

    }
    return $return;
}

