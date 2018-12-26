<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Factories\DateFactory;
use App\Helpers\CustomFormatDate;
use App\Http\Controllers\Api\DatatableController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatesTest extends TestCase
{
    public function testDDMMYYYYIfFormatIsCorrectTest(){
        $date = '01-01-2018';
        $final_date = DateFactory::createFormatYMDFrom($date);
        $this->assertEquals('2018-01-01', $final_date);
    }
    public function testYYYYMMDDFormatIsCorrectTest(){
        $date = '2018-12-31';
        $final_date = DateFactory::createFormatYMDFrom($date);
        $this->assertEquals('2018-12-31', $final_date);
    }
    public function testDDMMYYFormtIsCorrectTest(){
        $date = '01-01-18';
        $final_date = DateFactory::createFormatYMDFrom($date);
        $this->assertEquals('2018-01-01', $final_date);
    }
    public function testDMYWithEspDayTest(){
        $date = "01-ago-18";
        $final_date = DateFactory::createFormatYMDFrom($date);
        $this->assertEquals('2018-08-01', $final_date);
    }
    public function testDMYWithUpperEspDayTest(){
        $date = "01-AGO-18";
        $final_date = DateFactory::createFormatYMDFrom($date);
        $this->assertEquals('2018-08-01', $final_date);
    }
    public function testDMYWithEngDayTest(){
        $date = "01-aug-18";
        $final_date = DateFactory::createFormatYMDFrom($date);
        $this->assertEquals('2018-08-01', $final_date);
    }
    public function testDMYWithUpperEngDayTest(){
        $date = "01-APR-2018";
        $final_date = DateFactory::createFormatYMDFrom($date);
        $this->assertEquals('2018-04-01', $final_date);
    }
    public function testDDMMYYYYWithSlashTest(){
        $date = "01/02/2018";
        $final_date = DateFactory::createFormatYMDFrom($date);
        $this->assertEquals('2018-02-01', $final_date);
    }
    public function testDDMMYYWithSlashTest(){
        $date = "01/03/18";
        $final_date = DateFactory::createFormatYMDFrom($date);
        $this->assertEquals('2018-03-01', $final_date);
    }
    public function testToReturnTheSameDateWithInvalidFormat(){
        $date = "01/03/18 y 01/10/2019";
        $final_date = DateFactory::createFormatYMDFrom($date);
        $this->assertEquals('01/03/18 y 01/10/2019', $final_date);
    }
    public function testDateWithSlashFormatTest(){
        $date = "31/05/2019";
        $final_date = DateFactory::createFormatYMDFrom($date);
        $this->assertEquals('2019-05-31', $final_date);
    }
}
