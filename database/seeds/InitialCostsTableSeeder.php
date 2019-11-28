<?php

use App\Setting\InitialCost;
use Illuminate\Database\Seeder;

class InitialCostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new = new InitialCost();
        $new->type = 1;
        $new->sub_type = 1;
        $new->name = 'Type One';
        $new->slug = 'type_one';
        $new->assign_fee = 35000;
        $new->deposit_fee = 4000;
        $new->string_fee = 2000;
        $new->service_fee = 2000;
        $new->incheck_fee = 1000;
        $new->registration_fee = 1000;
        $new->save();

        $new1 = new InitialCost();
        $new1->type = 1;
        $new1->sub_type = 2;
        $new1->name = 'Type Two';
        $new1->slug = 'type_two';
        $new1->assign_fee = 65000;
        $new1->deposit_fee = 4000;
        $new1->string_fee = 2000;
        $new1->service_fee = 2000;
        $new1->incheck_fee = 1000;
        $new1->registration_fee = 1000;
        $new1->save();

        $new2 = new InitialCost();
        $new2->type = 1;
        $new2->sub_type = 3;
        $new2->name = 'Type Three';
        $new2->slug = 'type_three';
        $new2->assign_fee = 80000;
        $new2->deposit_fee = 4000;
        $new2->string_fee = 2000;
        $new2->service_fee = 2000;
        $new2->incheck_fee = 1000;
        $new2->registration_fee = 1000;
        $new2->save();

        $new3 = new InitialCost();
        $new3->type = 2;
        $new3->sub_type = 1;
        $new3->name = '10';
        $new3->slug = '10kw';
        $new3->assign_fee = 800000;
        $new3->deposit_fee = 4000;
        $new3->string_fee = 6000;
        $new3->service_fee = 0;
        $new3->incheck_fee = 0;
        $new3->registration_fee = 2000;
        $new3->composit_box = 34000;
        $new3->save();

        $new4 = new InitialCost();
        $new4->type = 2;
        $new4->sub_type = 2;
        $new4->name = '20';
        $new4->slug = '20kw';
        $new4->assign_fee = 1000000;
        $new4->deposit_fee = 4000;
        $new4->string_fee = 6000;
        $new4->service_fee = 0;
        $new4->incheck_fee = 0;
        $new4->registration_fee = 2000;
        $new4->composit_box = 34000;
        $new4->save();

        $new5 = new InitialCost();
        $new5->type = 2;
        $new5->sub_type = 3;
        $new5->name = '30';
        $new5->slug = '30kw';
        $new5->assign_fee = 1200000;
        $new5->deposit_fee = 4000;
        $new5->string_fee = 6000;
        $new5->service_fee = 0;
        $new5->incheck_fee = 0;
        $new5->registration_fee = 2000;
        $new5->composit_box = 34000;
        $new5->save();

        $new6 = new InitialCost();
        $new6->type = 3;
        $new6->sub_type = 1;
        $new6->name = '10';
        $new6->slug = '10kw';
        $new6->assign_fee = 800000;
        $new6->deposit_fee = 82500;
        $new6->string_fee = 8000;
        $new6->service_fee = 0;
        $new6->incheck_fee = 0;
        $new6->registration_fee = 20000;
        $new6->composit_box = 34000;
        $new6->save();

        $new7 = new InitialCost();
        $new7->type = 3;
        $new7->sub_type = 2;
        $new7->name = '20';
        $new7->slug = '20kw';
        $new7->assign_fee = 1000000;
        $new7->deposit_fee = 157500;
        $new7->string_fee = 8000;
        $new7->service_fee = 0;
        $new7->incheck_fee = 0;
        $new7->registration_fee = 20000;
        $new7->composit_box = 34000;
        $new7->save();

        $new8 = new InitialCost();
        $new8->type = 3;
        $new8->sub_type = 3;
        $new8->name = '30';
        $new8->slug = '30kw';
        $new8->assign_fee = 1200000;
        $new8->deposit_fee = 232500;
        $new8->string_fee = 8000;
        $new8->service_fee = 0;
        $new8->incheck_fee = 0;
        $new8->registration_fee = 20000;
        $new8->composit_box = 34000;
        $new8->save();

        $new9 = new InitialCost();
        $new9->type = 4;
        $new9->sub_type = 1;
        $new9->name = '50';
        $new9->slug = '50kva';
        $new9->assign_fee = 1800000;
        $new9->deposit_fee = 307500;
        $new9->string_fee = 6000;
        $new9->service_fee = 2000;
        $new9->incheck_fee = 0;
        $new9->registration_fee = 20000;
        $new9->composit_box = 0;
        $new9->save();

        $new10 = new InitialCost();
        $new10->type = 4;
        $new10->sub_type = 2;
        $new10->name = '100';
        $new10->slug = '100kva';
        $new10->assign_fee = 2100000;
        $new10->deposit_fee = 607500;
        $new10->string_fee = 6000;
        $new10->service_fee = 2000;
        $new10->incheck_fee = 0;
        $new10->registration_fee = 20000;
        $new10->composit_box = 0;
        $new10->save();

        $new11 = new InitialCost();
        $new11->type = 4;
        $new11->sub_type = 4;
        $new11->name = '160';
        $new11->slug = '160kva';
        $new11->assign_fee = 2400000;
        $new11->deposit_fee = 967500;
        $new11->string_fee = 6000;
        $new11->service_fee = 2000;
        $new11->incheck_fee = 0;
        $new11->registration_fee = 20000;
        $new11->composit_box = 0;
        $new11->save();

        $new12 = new InitialCost();
        $new12->type = 4;
        $new12->sub_type = 4;
        $new12->name = '200';
        $new12->slug = '200kva';
        $new12->assign_fee = 2700000;
        $new12->deposit_fee = 1207500;
        $new12->string_fee = 6000;
        $new12->service_fee = 2000;
        $new12->incheck_fee = 0;
        $new12->registration_fee = 20000;
        $new12->composit_box = 0;
        $new12->save();

        $new13 = new InitialCost();
        $new13->type = 4;
        $new13->sub_type = 5;
        $new13->name = '315';
        $new13->slug = '315kva';
        $new13->assign_fee = 3300000;
        $new13->deposit_fee = 1897500;
        $new13->string_fee = 6000;
        $new13->service_fee = 2000;
        $new13->incheck_fee = 0;
        $new13->registration_fee = 20000;
        $new13->composit_box = 0;
        $new13->save();

        $new14 = new InitialCost();
        $new14->type = 4;
        $new14->sub_type = 6;
        $new14->name = '500';
        $new14->slug = '500kva';
        $new14->assign_fee = 4500000;
        $new14->deposit_fee = 3007500;
        $new14->string_fee = 6000;
        $new14->service_fee = 2000;
        $new14->incheck_fee = 0;
        $new14->registration_fee = 20000;
        $new14->composit_box = 0;
        $new14->save();

        $new15 = new InitialCost();
        $new15->type = 4;
        $new15->sub_type = 7;
        $new15->name = '1000';
        $new15->slug = '1000kva';
        $new15->assign_fee = 7800000;
        $new15->deposit_fee = 6007500;
        $new15->string_fee = 6000;
        $new15->service_fee = 2000;
        $new15->incheck_fee = 0;
        $new15->registration_fee = 20000;
        $new15->composit_box = 0;
        $new15->save();

        $new16 = new InitialCost();
        $new16->type = 4;
        $new16->sub_type = 8;
        $new16->name = '1250';
        $new16->slug = '1250kva';
        $new16->assign_fee = 9300000;
        $new16->deposit_fee = 7507500;
        $new16->string_fee = 6000;
        $new16->service_fee = 2000;
        $new16->incheck_fee = 0;
        $new16->registration_fee = 20000;
        $new16->composit_box = 0;
        $new16->save();

        $new17 = new InitialCost();
        $new17->type = 4;
        $new17->sub_type = 9;
        $new17->name = '20000';
        $new17->slug = '20000kva';
        $new17->assign_fee = 200000000;
        $new17->deposit_fee = 120007500;
        $new17->string_fee = 6000;
        $new17->service_fee = 2000;
        $new17->incheck_fee = 0;
        $new17->registration_fee = 20000;
        $new17->composit_box = 0;
        $new17->save();

        $new18 = new InitialCost();
        $new18->type = 4;
        $new18->sub_type = 10;
        $new18->name = '25000';
        $new18->slug = '25000kva';
        $new18->assign_fee = 250000000;
        $new18->deposit_fee = 150007500;
        $new18->string_fee = 6000;
        $new18->service_fee = 2000;
        $new18->incheck_fee = 0;
        $new18->registration_fee = 20000;
        $new18->composit_box = 0;
        $new18->save();

        $new19 = new InitialCost();
        $new19->type = 4;
        $new19->sub_type = 11;
        $new19->name = '30000';
        $new19->slug = '30000kva';
        $new19->assign_fee = 300000000;
        $new19->deposit_fee = 180007500;
        $new19->string_fee = 6000;
        $new19->service_fee = 2000;
        $new19->incheck_fee = 0;
        $new19->registration_fee = 20000;
        $new19->composit_box = 0;
        $new19->save();
    }
}
