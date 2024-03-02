<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vmt_banks')->truncate();

        DB::table('vmt_banks')->insert([
            ['id'=>'1','bank_name'=> 'ANDHRA BANK', 'min_length' => '15', 'max_length' => '15'],
            ['id'=>'2','bank_name'=> 'ANDHRA PRADESH GRAMEENA VIKAS BANK', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'3','bank_name'=> 'ALLAHABAD BANK', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'4','bank_name'=> 'ASSAM GRAMIN VIKASH BANK', 'min_length' => '13', 'max_length' => '13'],
            ['id'=>'5','bank_name'=> 'ARYAVART BANK', 'min_length' => '15', 'max_length' => '15'],
            ['id'=>'6','bank_name'=> 'AU SMALL FINANCE BANK', 'min_length' => '16', 'max_length' => '16'],
            ['id'=>'7','bank_name'=> 'AXIS BANK', 'min_length' => '15', 'max_length' => '15'],
            ['id'=>'8','bank_name'=> 'BANDHAN BANK', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'9','bank_name'=> 'BANK OF BARODA', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'10','bank_name'=> 'BANK OF INDIA', 'min_length' => '15', 'max_length' => '15'],
            ['id'=>'11','bank_name'=> 'BANK OF MAHARASHTRA', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'12','bank_name'=> 'BARODA RAJASTHAN KSHETRIYA GRAMIN BANK', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'13','bank_name'=> 'BARODA UP GRAMIN BANK', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'14','bank_name'=> 'BANGIYA GRAMIN VIKASH BANK', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'15','bank_name'=> 'CENTRAL BANK OF INDIA', 'min_length' => '10', 'max_length' => '10'],
            ['id'=>'16','bank_name'=> 'CANARA BANK', 'min_length' => '13', 'max_length' => '13'],
            ['id'=>'17','bank_name'=> 'CATHOLIC SYRIAN BANK', 'min_length' => '18', 'max_length' => '18'],
            ['id'=>'18','bank_name'=> 'CITI BANK', 'min_length' => '10', 'max_length' => '10'],
            ['id'=>'19','bank_name'=> 'CITY UNION BANK', 'min_length' => '15', 'max_length' => '15'],
            ['id'=>'20','bank_name'=> 'CORPORATION BAN', 'min_length' => '	8', 'max_length' => '	8'],
            ['id'=>'21','bank_name'=> 'DCB BANK', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'22','bank_name'=> 'DENA BANK', 'min_length' => '12', 'max_length' => '12'],
            ['id'=>'23','bank_name'=> 'DHANALAKSHMI BANK', 'min_length' => '16', 'max_length' => '16'],
            ['id'=>'24','bank_name'=> 'EQUITAS SMALL FINANCE BANK', 'min_length' => '12', 'max_length' => '12'],
            ['id'=>'25','bank_name'=> 'FEDERAL BANK', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'26','bank_name'=> 'HDFC BANK', 'min_length' => '13', 'max_length' => '14'],
            ['id'=>'27','bank_name'=> 'HSBC BANK', 'min_length' => '12', 'max_length' => '12'],
            ['id'=>'28','bank_name'=> 'ICICI BANK', 'min_length' => '12', 'max_length' => '12'],
            ['id'=>'29','bank_name'=> 'IDFC FIRST BANK', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'30','bank_name'=> 'INDIAN BANK', 'min_length' => '	9', 'max_length' => '	9'],
            ['id'=>'31','bank_name'=> 'INDIAN OVERSEAS BANK', 'min_length' => '15', 'max_length' => '15'],
            ['id'=>'32','bank_name'=> 'INDUSIND BANK', 'min_length' => '13', 'max_length' => '13'],
            ['id'=>'33','bank_name'=> 'IDBI BANK', 'min_length' => '13', 'max_length' => '16'],
            ['id'=>'34','bank_name'=> 'JAMMU AND KASHMIR BANK', 'min_length' => '16', 'max_length' => '16'],
            ['id'=>'35','bank_name'=> 'KARNATAKA BANK', 'min_length' => '16', 'max_length' => '16'],
            ['id'=>'36','bank_name'=> 'KARUR VYSYA BANK', 'min_length' => '16', 'max_length' => '16'],
            ['id'=>'37','bank_name'=> 'KARNATAKA VIKAS GRAMEENA BANK', 'min_length' => '16', 'max_length' => '16'],
            ['id'=>'38','bank_name'=> 'KERALA GRAMIN BANK', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'39','bank_name'=> 'KOTAK MAHINDRA BANK', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'40','bank_name'=> 'LAKSHMI VILAS BANK', 'min_length' => '16', 'max_length' => '16'],
            ['id'=>'41','bank_name'=> 'NAINITAL BANK', 'min_length' => '16', 'max_length' => '16'],
            ['id'=>'42','bank_name'=> 'MADHYANCHAL GRAMIN BANK', 'min_length' => '10', 'max_length' => '10'],
            ['id'=>'43','bank_name'=> 'ORIENTAL BANK OF COMMERCE', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'44','bank_name'=> 'ODISHA GRAMYA BANK', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'45','bank_name'=> 'PUNJAB NATIONAL BANK', 'min_length' => '16', 'max_length' => '16'],
            ['id'=>'46','bank_name'=> 'PUNJAB & SIND BANK', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'47','bank_name'=> 'Prathama UP Gramin Bank', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'48','bank_name'=> 'RBL BANK', 'min_length' => '12', 'max_length' => '12'],
            ['id'=>'49','bank_name'=> 'RAJASTHAN MARUDHARA GRAMIN BANK', 'min_length' => '12', 'max_length' => '12'],
            ['id'=>'50','bank_name'=> 'STANDARD CHARTERED BANK', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'51','bank_name'=> 'STATE BANK OF BIKANER AND JAIPUR', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'52','bank_name'=> 'SAPTAGIRI GRAMIN BANK', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'53','bank_name'=> 'SARVA HARYANA GRAMIN BANK', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'54','bank_name'=> 'STATE BANK OF INDIA', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'55','bank_name'=> 'STATE BANK OF HYDERABAD', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'56','bank_name'=> 'STATE BANK OF TRAVANCORE', 'min_length' => '11', 'max_length' => '11'],
            ['id'=>'57','bank_name'=> 'SOUTH INDIAN BANK', 'min_length' => '16', 'max_length' => '16'],
            ['id'=>'58','bank_name'=> 'SYNDICATE BANK', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'59','bank_name'=> 'TAMILNADU MERCANTILE BANK', 'min_length' => '6', 'max_length' => '15'],
            ['id'=>'60','bank_name'=> 'UNION BANK OF INDIA', 'min_length' => '15', 'max_length' => '15'],
            ['id'=>'61','bank_name'=> 'UNITED BANK OF INDIA', 'min_length' => '13', 'max_length' => '13'],
            ['id'=>'62','bank_name'=> 'UCO BANK', 'min_length' => '14', 'max_length' => '14'],
            ['id'=>'63','bank_name'=> 'UTTAR BIHAR GRAMIN BANK', 'min_length' => '16', 'max_length' => '16'],
            ['id'=>'64','bank_name'=> 'UTKAL GRAMEEN BANK', 'min_length' => '12', 'max_length' => '12'],
            ['id'=>'65','bank_name'=> 'VIJAYA BANK(Now BoB)', 'min_length' => '15', 'max_length' => '15'],
            ['id'=>'66','bank_name'=> 'YES BANK', 'min_length' => '15', 'max_length' => '15'],
        ]);
    }
}
