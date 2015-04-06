<?php

function denTo26Ary($num){
  $str = '';
  while($num > 0){
    $m   = $num%26;
    if($m == 0){
      $m = 26;
    }
    $str = chr($m + 64) . $str;
    $num = ($num-$m)/26;
  }
  return $str;
}

echo denTo26Ary(11);
?>
