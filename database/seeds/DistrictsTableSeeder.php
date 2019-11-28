<?php

use App\Setting\District;
use Illuminate\Database\Seeder;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new = new District();
        $new->division_state_id = 1;
        $new->name = 'ဒက္ခိဏခရိုင်';
        $new->eng = 'Datkhina';
        $new->save();

        $new1 = new District();
        $new1->division_state_id = 1;
        $new1->name = 'ဥတ္တရခရိုင်';
        $new1->eng = 'Ottara';
        $new1->save();

        $new2 = new District();
        $new2->division_state_id = 2;
        $new2->name = 'ရန်ကုန်အရှေ့ပိုင်းခရိုင်';
        $new2->eng = 'Eastern Yangon';
        $new2->save();

        $new3 = new District();
        $new3->division_state_id = 2;
        $new3->name = 'ရန်ကုန်အနောက်ပိုင်းခရိုင်';
        $new3->eng = 'Western Yangon';
        $new3->save();

        $new4 = new District();
        $new4->division_state_id = 2;
        $new4->name = 'ရန်ကုန်တောင်ပိုင်းခရိုင်';
        $new4->eng = 'Southern Yangon';
        $new4->save();

        $new5 = new District();
        $new5->division_state_id = 2;
        $new5->name = 'ရန်ကုန်မြောက်ပိုင်းခရိုင်';
        $new5->eng = 'Northern Yangon';
        $new5->save();

        $new6 = new District();
        $new6->division_state_id = 3;
        $new6->name = 'မန္တလေးခရိုင်';
        $new6->eng = 'Mandalay';
        $new6->save();
    }
}
