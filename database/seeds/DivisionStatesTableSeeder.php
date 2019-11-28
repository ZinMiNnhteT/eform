<?php

use App\Setting\DivisionState;
use Illuminate\Database\Seeder;

class DivisionStatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = [
            'နေပြည်တော်ကောင်စီနယ်မြေ', 'ရန်ကုန်တိုင်းဒေသကြီး', 'မန္တလေးတိုင်းဒေသကြီး', 'မကွေးတိုင်းဒေသကြီး', 'ရှမ်းပြည်နယ်', 'ဧရာဝတီတိုင်းဒေသကြီး', 'ကရင်ပြည်နယ်', 'ချင်းပြည်နယ်', 'မွန်ပြည်နယ်', 'တနင်္သာရီတိုင်းဒေသကြီး', 'ပဲခူးတိုင်းဒေသကြီး', 'ကချင်ပြည်နယ်', 'စစ်ကိုင်းတိုင်းဒေသကြီး', 'ကယားပြည်နယ်', 'ရခိုင်ပြည်နယ်'
        ];
        $eng = [
            'Nay Pyi Taw', 'Yangon', 'Mandalay', 'Magway', 'Shan', 'Ayeyarwady', 'Kayin', 'Chin', 'Mon', 'Tanintharyi', 'Bago', 'Kachin', 'Sagaing', 'Kayah', 'Rakhine'
        ];
        for ($i = 0; $i < 15; $i++) {
            $new = new DivisionState();
            $new->name = $name[$i];
            $new->eng = $eng[$i];
            $new->save();
        }
    }
}
