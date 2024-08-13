<?php

namespace App\CPU;

use Carbon\Carbon;

class Helpers{
  public static function appName(){
    return 'Vella Billiard';
  }

  public static function dateFormat($date){
    return Carbon::parse($date)->format('d-m-Y H:i');
  }

  public static function dateFormat2($date, $type)
  {

    if ($type == 'date') {
      $d = Carbon::parse($date)->format('d-m-Y');
    } else {
      $d = Carbon::parse($date)->format('d-m-Y H:i');
    }

    return $d;
  }
}