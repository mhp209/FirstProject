<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            [ "name" => "Andaman & Nicobar Islands"],
            [ "name" => "Andhra Pradesh"],
            [ "name" => "Arunachal Pradesh"],
            [ "name" => "Assam"],
            [ "name" => "Bihar"],
            [ "name" => "Chandigarh"],
            [ "name" => "Chattisgarh"],
            [ "name" => "Dadra & Nagar Haveli"],
            [ "name" => "Daman & Diu"],
            [ "name" => "Delhi"],
            [ "name" => "Goa"],
            [ "name" => "Gujarat"],
            [ "name" => "Haryana"],
            [ "name" => "Himachal Pradesh"],
            [ "name" => "Jammu & Kashmir"],
            [ "name" => "Jharkhand"],
            [ "name" => "Karnataka"],
            [ "name" => "Kerala"],
            [ "name" => "Lakshadweep"],
            [ "name" => "Madhya Pradesh"],
            [ "name" => "Maharashtra"],
            [ "name" => "Manipur"],
            [ "name" => "Meghalaya"],
            [ "name" => "Mizoram"],
            [ "name" => "Nagaland"],
            [ "name" => "Odisha"],
            [ "name" => "Pondicherry"],
            [ "name" => "Punjab"],
            [ "name" => "Rajasthan"],
            [ "name" => "Sikkim"],
            [ "name" => "Tamil Nadu"],
            [ "name" => "Telangana"],
            [ "name" => "Tripura"],
            [ "name" => "Uttar Pradesh"],
            [ "name" => "Uttarakhand"],
            [ "name" => "West Bengal"]
        ];

        foreach ($states as $key => $data) {
            State::create($data);
        }
    }
}
