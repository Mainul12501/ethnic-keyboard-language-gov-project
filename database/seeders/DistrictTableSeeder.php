<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* DB::table('districts')->insert([
            ['name'=>'Bandarban', 'created_at'=>date("Y-m-d H:i:s")],
            ['name'=>'Natore', 'created_at'=>date("Y-m-d H:i:s")],
        ]);*/

        $districts = [
            ['id' => '1',  'bn_name'=>'কুমিল্লা', 'name' => 'Comilla'],
            ['id' => '2',  'bn_name'=>'ফেনী', 'name' => 'Feni'],
            ['id' => '3',  'bn_name'=>'ব্রাহ্মণবাড়িয়া', 'name' => 'Brahmanbaria'],
            ['id' => '4',  'bn_name'=>'রাঙ্গামাটি ', 'name' => 'Rangamati'],
            ['id' => '5',  'bn_name'=>'নোয়াখালী', 'name' => 'Noakhali'],
            ['id' => '6',  'bn_name'=>'চাঁদপুর', 'name' => 'Chandpur'],
            ['id' => '7',  'bn_name'=>'লক্ষ্মীপুর', 'name' => 'Lakshmipur'],
            ['id' => '8',  'bn_name'=>'চট্টগ্রাম', 'name' => 'Chattogram'],
            ['id' => '9',  'bn_name'=>'কক্সবাজার', 'name' => 'Coxsbazar'],
            ['id' => '10', 'bn_name'=>'খাগড়াছড়ি',  'name' => 'Khagrachhari'],
            ['id' => '11', 'bn_name'=>'বান্দরবান',  'name' => 'Bandarban'],
            ['id' => '12', 'bn_name'=>'সিরাজগঞ্জ',  'name' => 'Sirajganj'],
            ['id' => '13', 'bn_name'=>'পাবনা',  'name' => 'Pabna'],
            ['id' => '14', 'bn_name'=>'বগুড়া',  'name' => 'Bogura'],
            ['id' => '15', 'bn_name'=>'রাজশাহী',  'name' => 'Rajshahi'],
            ['id' => '16', 'bn_name'=>'নাটোর',  'name' => 'Natore'],
            ['id' => '17', 'bn_name'=>'জয়পুরহাট',  'name' => 'Joypurhat'],
            ['id' => '18', 'bn_name'=>'চাঁপাইনবাবগঞ্জ',  'name' => 'Chapainawabganj'],
            ['id' => '19', 'bn_name'=>'নওগাঁ',  'name' => 'Naogaon'],
            ['id' => '20', 'bn_name'=>'যশোর',  'name' => 'Jashore'],
            ['id' => '21', 'bn_name'=>'সাতক্ষীরা',  'name' => 'Satkhira'],
            ['id' => '22', 'bn_name'=>'মেহেরপুর',  'name' => 'Meherpur'],
            ['id' => '23', 'bn_name'=>'নড়াইল',  'name' => 'Narail'],
            ['id' => '24', 'bn_name'=>'চুয়াডাঙ্গা',  'name' => 'Chuadanga'],
            ['id' => '25', 'bn_name'=>'কুষ্টিয়া',  'name' => 'Kushtia'],
            ['id' => '26', 'bn_name'=>'মাগুরা',  'name' => 'Magura'],
            ['id' => '27', 'bn_name'=>'খুলনা',  'name' => 'Khulna'],
            ['id' => '28', 'bn_name'=>'বাগেরহাট',  'name' => 'Bagerhat'],
            ['id' => '29', 'bn_name'=>'ঝিনাইদহ',  'name' => 'Jhenaidah'],
            ['id' => '30', 'bn_name'=>'ঝালকাঠি',  'name' => 'Jhalakathi'],
            ['id' => '31', 'bn_name'=>'পটুয়াখালী',  'name' => 'Patuakhali'],
            ['id' => '32', 'bn_name'=>'পিরোজপুর',  'name' => 'Pirojpur'],
            ['id' => '33', 'bn_name'=>'বরিশাল',  'name' => 'Barisal'],
            ['id' => '34', 'bn_name'=>'ভোলা',  'name' => 'Bhola'],
            ['id' => '35', 'bn_name'=>'বরগুনা',  'name' => 'Barguna'],
            ['id' => '36', 'bn_name'=>'সিলেট',  'name' => 'Sylhet'],
            ['id' => '37', 'bn_name'=>'মৌলভীবাজার',  'name' => 'Moulvibazar'],
            ['id' => '38', 'bn_name'=>'হবিগঞ্জ',  'name' => 'Habiganj'],
            ['id' => '39', 'bn_name'=>'সুনামগঞ্জ',  'name' => 'Sunamganj'],
            ['id' => '40', 'bn_name'=>'নরসিংদী',  'name' => 'Narsingdi'],
            ['id' => '41', 'bn_name'=>'গাজীপুর',  'name' => 'Gazipur'],
            ['id' => '42', 'bn_name'=>'শরীয়তপুর',  'name' => 'Shariatpur'],
            ['id' => '43', 'bn_name'=>'নারায়ণগঞ্জ',  'name' => 'Narayanganj'],
            ['id' => '44', 'bn_name'=>'টাঙ্গাইল',  'name' => 'Tangail'],
            ['id' => '45', 'bn_name'=>'কিশোরগঞ্জ',  'name' => 'Kishoreganj'],
            ['id' => '46', 'bn_name'=>'মানিকগঞ্জ',  'name' => 'Manikganj'],
            ['id' => '47', 'bn_name'=>'ঢাকা',  'name' => 'Dhaka'],
            ['id' => '48', 'bn_name'=>'মুন্সিগঞ্জ',  'name' => 'Munshiganj'],
            ['id' => '49', 'bn_name'=>'রাজবাড়ী',  'name' => 'Rajbari'],
            ['id' => '50', 'bn_name'=>'মাদারীপুর',  'name' => 'Madaripur'],
            ['id' => '51', 'bn_name'=>'গোপালগঞ্জ',  'name' => 'Gopalganj'],
            ['id' => '52', 'bn_name'=>'ফরিদপুর',  'name' => 'Faridpur'],
            ['id' => '53', 'bn_name'=>'পঞ্চগড়',  'name' => 'Panchagarh'],
            ['id' => '54', 'bn_name'=>'দিনাজপুর',  'name' => 'Dinajpur'],
            ['id' => '55', 'bn_name'=>'লালমনিরহাট',  'name' => 'Lalmonirhat'],
            ['id' => '56', 'bn_name'=>'নীলফামারী',  'name' => 'Nilphamari'],
            ['id' => '57', 'bn_name'=>'গাইবান্ধা',  'name' => 'Gaibandha'],
            ['id' => '58', 'bn_name'=>'ঠাকুরগাঁও',  'name' => 'Thakurgaon',],
            ['id' => '59', 'bn_name'=>'রংপুর',  'name' => 'Rangpur'],
            ['id' => '60', 'bn_name'=>'কুড়িগ্রাম',  'name' => 'Kurigram'],
            ['id' => '61', 'bn_name'=>'শেরপুর',  'name' => 'Sherpur'],
            ['id' => '62', 'bn_name'=>'ময়মনসিংহ',  'name' => 'Mymensingh'],
            ['id' => '63', 'bn_name'=>'জামালপুর',  'name' => 'Jamalpur'],
            ['id' => '64', 'bn_name'=>'নেত্রকোণা',  'name' => 'Netrokona'],
        ];

        DB::table('districts')->insert($districts);

    }
}
