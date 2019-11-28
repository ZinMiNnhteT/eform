<?php

use App\Setting\Township;
use Illuminate\Database\Seeder;

class TownshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new = new Township();
        $new->division_state_id = 1;
        $new->district_id = 1;
        $new->name = 'လယ်ဝေးမြို့နယ်';
        $new->eng = 'Lewe';
        $new->save();
        
        $new3 = new Township();
        $new3->division_state_id = 1;
        $new3->district_id = 1;
        $new3->name = 'ဇမ္ဗူသီရိမြို့နယ်';
        $new3->eng = 'Zabuthiri';
        $new3->save();
        
        $new4 = new Township();
        $new4->division_state_id = 1;
        $new4->district_id = 1;
        $new4->name = 'ဒက္ခိဏသီရိမြို့နယ်';
        $new4->eng = 'Dakhina';
        $new4->save();
        
        $new5 = new Township();
        $new5->division_state_id = 1;
        $new5->district_id = 1;
        $new5->name = 'ဇေယျာသီရိမြို့နယ်';
        $new5->eng = 'Zayarthiri';
        $new5->save();

        $new8 = new Township();
        $new8->division_state_id = 1;
        $new8->district_id = 1;
        $new8->name = 'ပျဥ်းမနားမြို့နယ်';
        $new8->eng = 'Pyinmanar';
        $new8->save();

        $new6 = new Township();
        $new6->division_state_id = 1;
        $new6->district_id = 2;
        $new6->name = 'ဥတ္တရသီရိမြို့နယ်';
        $new6->eng = 'Ottarathiri';
        $new6->save();

        $new7 = new Township();
        $new7->division_state_id = 1;
        $new7->district_id = 2;
        $new7->name = 'ပုပ္ဗသီရိမြို့နယ်';
        $new7->eng = 'Pobathiri';
        $new7->save();
        
        $new8 = new Township();
        $new8->division_state_id = 3;
        $new8->district_id = 7;
        $new8->name = 'အောင်မြေသာစံမြို့နယ်';
        $new8->eng = 'Aungmyaytharzan';
        $new8->save();
        
        $new9 = new Township();
        $new9->division_state_id = 3;
        $new9->district_id = 7;
        $new9->name = 'ချမ်းအေးသာစံမြို့နယ်';
        $new9->eng = 'Chanayetharzan';
        $new9->save();
        
        $new10 = new Township();
        $new10->division_state_id = 3;
        $new10->district_id = 7;
        $new10->name = 'မဟာအောင်မြေမြို့နယ်';
        $new10->eng = 'Maharaungmyay';
        $new10->save();
        
        $new11 = new Township();
        $new11->division_state_id = 3;
        $new11->district_id = 7;
        $new11->name = 'ချမ်းမြသာစည်မြို့နယ်';
        $new11->eng = 'Chanmyatharzi';
        $new11->save();
        
        $new12 = new Township();
        $new12->division_state_id = 3;
        $new12->district_id = 7;
        $new12->name = 'ပြည်ကြီးတံခွန်မြို့နယ်';
        $new12->eng = 'Pyigyidagwon';
        $new12->save();
        
        $new1 = new Township();
        $new1->division_state_id = 2;
        $new1->district_id = 3;
        $new1->name = 'လမ်းမတော်မြို့နယ်';
        $new1->eng = 'Lanmadaw';
        $new1->save();
        
        $new2 = new Township();
        $new2->division_state_id = 2;
        $new2->district_id = 3;
        $new2->name = 'လသာမြို့နယ်';
        $new2->eng = 'Latha';
        $new2->save();
    }
}
