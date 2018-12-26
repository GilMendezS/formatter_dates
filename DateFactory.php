<?php
namespace App\Factories;

use App\Helpers\CustomFormatDate;

class DateFactory {
    public static function createFormatYMDFrom($date){
        $formatter = new CustomFormatDate($date);
        return $formatter->getDateWithYMDFormat();
    }
}
