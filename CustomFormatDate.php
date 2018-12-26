<?php
namespace App\Helpers;

use Carbon\Carbon;

class CustomFormatDate {
    private const VALID_MONTHS = array(
        'enero'         => '01',
        'febrebro'      => '02',
        'marzo'         => '03',
        'abril'         => '04',
        'mayo'          => '05',
        'junio'         => '06',
        'julio'         => '07',
        'agosto'        => '08',
        'septiembre'    => '09',
        'octubre'       => '10',
        'noviembre'     => '11',
        'diciembre'     => '12',
        'january'       => '01',
        'february'      => '02',
        'march'         => '03',
        'april'         => '04',
        'may'           => '05',
        'june'          => '06',
        'july'          => '07',
        'august'        => '08',
        'september'     => '09',
        'october'       => '10',
        'november'      => '11',
        'december'      => '12' 
    );
    private CONST ERROR = 'invalid_format';
    private $date;
    public function __construct(string $dateGiven = ''){
        $this->date = $dateGiven;
    }
    public function getDateWithYMDFormat(){
        $format = $this->getGivenFormat();
        $final_date = $this->getFormattedDate($format);
        if($final_date != self::ERROR){
            return $final_date;
        }
        else {
            return $this->date;
        }
        
    }
    public function setDate($newDate){
        $this->date = $newDate;
    }
    //return the given format
    private function getGivenFormat(){
        
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$this->date)) {
            return "YYYY-MM-DD";
        } 
        else if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$this->date)){
            return 'DD-MM-YYYY';
        }
        else if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{2}$/",$this->date)){
            return 'DD-MM-YY';
        }
        else if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/",$this->date)){
            return 'DD/MM/YYYY';
        }
        else if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{2}$/",$this->date)){
            return 'DD/MM/YY';
        }
        else if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-([a-z]{3}|[A-Z]{3})-[0-9]{4}$/",$this->date)){
            return 'DD-month-YYYY';
        }
        else if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-([a-z]{3}|[A-Z]{3})-[0-9]{2}$/",$this->date)){
            return 'DD-month-YY';
        }
        else {
            return self::ERROR;
        }
    }
    private function getFormattedDate($format){
        switch($format){
            case 'YYYY-MM-DD':
                return $this->generateFromYYYYMMDD();
                break;
            case 'DD-MM-YYYY':
                return $this->generateFromDDMMYYYY();
                break;    
            case 'DD-MM-YY':
                return $this->generateFromDMY();
                break;
            case 'DD-month-YYYY':
                return $this->generateFromDDMMYYYYWithDay();
                break;
            case 'DD-month-YY':
                return $this->generateFromDDMMYYWithDay();
                break;
            case 'DD/MM/YYYY':
                return $this->generateFromDDMMYYYYWithSlash();
                break;
            case 'DD/MM/YY':
                return $this->generateFromDDMMYYWithSlash();
                break;
            default:
                return self::ERROR;
                break;
        }
    }
    private function generateFromYYYYMMDD(){
        return Carbon::createFromFormat('Y-m-d', $this->date)->format('Y-m-d');
    }
    private function generateFromDDMMYYYY(){
        return Carbon::createFromFormat('d-m-Y', $this->date)->format('Y-m-d');
    }
    private function generateFromDMY(){
        $full_year = $this->getCurrentYearFromString($this->date);
        $splitted_date = explode("-", $this->date);
        return Carbon::createFromFormat('d-m-Y', "$splitted_date[0]-$splitted_date[1]-$full_year")->format('Y-m-d');
    }
    private function generateDDMMYYYY($date){
        return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
    }
    private function generateFromDDMMYYYYWithDay(){
        $day = explode("-",$this->date);
        $number_month = $this->getNumberMonth($day[1]);
        if($number_month != self::ERROR){
            return "$day[2]-$number_month-$day[0]";
        }
        else {
            return self::ERROR;
        }
    }
    private function generateFromDDMMYYYYWithSlash(){
        return Carbon::createFromFormat('d/m/Y', $this->date)->format('Y-m-d');
    }
    private function generateFromDDMMYYWithSlash(){
        $full_year = $this->getCurrentYearFromString($this->date);
        $exploded_date = explode("/",$this->date);
        return Carbon::createFromFormat('Y-m-d', "$full_year-$exploded_date[1]-$exploded_date[0]")->format("Y-m-d");
    }
    private function generateFromDDMMYYWithDay(){
        $full_year = $this->getCurrentYearFromString($this->date);
        $numbers_of_date = explode("-", $this->date);
        $month = $this->getNumberMonth($numbers_of_date[1]);
        $valid_date_to_format = "$numbers_of_date[0]-$month-$full_year";
        return $this->generateDDMMYYYY($valid_date_to_format);
    }
    private function getNumberMonth($string){
        $number_month = '';
        $lower_case_day = strtolower($string);
        foreach(self::VALID_MONTHS AS $key => $value){
            $mounth_found_it = strpos($key, $lower_case_day);
            if($mounth_found_it !== FALSE){
                $number_month = $value;
                break;
            }
        }
        if($number_month !='' ){
            return $number_month;
        }
        else {
            return self::ERROR;
        }
    }
    private function getCurrentYearFromString($string){
        if(strpos($string, "/") !== FALSE){
            $numbers_of_date = explode("/",$string);
        }
        else if(strpos($string, "-") !== FALSE){
            $numbers_of_date = explode("-",$string);
        }
        $year = date('Y');
        $first_two_digits = "$year[0]$year[1]";
        try {
            return "$first_two_digits$numbers_of_date[2]";
        } catch (\Throwable $th) {
            return self::ERROR;
        }
    }
}

?>
