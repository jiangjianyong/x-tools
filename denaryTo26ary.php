<?php

function denTo26Ary($num){
  $str = array();

  while($num > 0){
    $m = $num%26;
    if($m == 0){
        $m = 26;
    }
    $str[] = chr($m + 64);
    $num = ($num-$m)/26;
  }
  $str = array_reverse($str);
  $str = join('', $str);
  return $str;
}

echo denTo26Ary(11);
?>
