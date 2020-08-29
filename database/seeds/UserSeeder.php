<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            ['username'=>'eddy','password'=>bcrypt('eddy'),'name'=>'eddy suryajana','email'=>'surya.eddy@gmail.com','posisi'=>'owner','phone_number'=>'081255156399'],
            ['username'=>'dana','password'=>bcrypt('dana'),'name'=>'atmaja dana','email'=>'dana.atmaja@gmail.com','posisi'=>'administrator','phone_number'=>'081666953421'],
            ['username'=>'sujatmiko','password'=>bcrypt('sujatmiko'),'name'=>'sujatmiko wirawan','email'=>'wirawan.sujatmiko@gmail.com','posisi'=>'administrator','phone_number'=>'081222138309']
        ];
        DB::table('admins')->insert($admins);
    }
}
