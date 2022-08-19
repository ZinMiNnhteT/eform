<?php

use App\Admin\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system = new Admin();
        $system->name = 'SYSTEM';
        $system->username = 'system';
        $system->email = 'system@mail.com';
        $system->password = crypt('123123123', '');
        $system->phone = '0912312312';
        $system->group_lvl = 1;
        $system->active = TRUE;
        $system->save();

        $superAdmin = new Admin();
        $superAdmin->name = 'MOEE Admin';
        $superAdmin->username = 'moeeadmin';
        $superAdmin->email = 'admin.emeter@moee.gov.mm';
        $superAdmin->password = crypt('moee@dmin', '');
        $superAdmin->phone = '09000000000';
        $superAdmin->group_lvl = 2;
        $superAdmin->active = TRUE;
        $superAdmin->save();
    }
}
