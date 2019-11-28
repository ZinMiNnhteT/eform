<?php

use App\Admin\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ============================== Reset cached roles and permissions ============================== //
        // app('cache')->forget('spatie.permission.cache');
        /* artisan command */
        // php artisan permission:cache-reset


        $data = [
            'dashboard-view', 'dashboard-create', 'dashboard-edit', 'dashboard-delete', 'dashboard-show',

            'inbox-view', 'inbox-create', 'inbox-edit', 'inbox-delete', 'inbox-show',

            'setting-view', 'setting-create', 'setting-edit', 'setting-delete', 'setting-show', /* main link */
            'accountSetting-view', 'accountSetting-create', 'accountSetting-edit', 'accountSetting-delete', 'accountSetting-show',
            'roleSetting-view', 'roleSetting-create', 'roleSetting-edit', 'roleSetting-delete', 'roleSetting-show',
            'userAccount-view', 'userAccount-create', 'userAccount-edit', 'userAccount-delete', 'userAccount-show',

            'residential-view', 'residential-create', 'residential-edit', 'residential-delete', 'residential-show', /* main link */
            'residentApplication-view', 'residentApplication-create', 'residentApplication-edit', 'residentApplication-delete', 'residentApplication-show',
            'residentialGrdChk-view', 'residentialGrdChk-create', 'residentialGrdChk-edit', 'residentialGrdChk-delete', 'residentialGrdChk-show',
            'residentialChkGrdTownship-view', 'residentialChkGrdTownship-create', 'residentialChkGrdTownship-edit', 'residentialChkGrdTownship-delete', 'residentialChkGrdTownship-show',
            'residentPending-view', 'residentPending-create', 'residentPending-edit', 'residentPending-delete', 'residentPending-show',
            'residentReject-view', 'residentReject-create', 'residentReject-edit', 'residentReject-delete', 'residentReject-show',
            'residentialAnnounce-view', 'residentialAnnounce-create', 'residentialAnnounce-edit', 'residentialAnnounce-delete', 'residentialAnnounce-show',
            'residentialConfirmPayment-view', 'residentialConfirmPayment-create', 'residentialConfirmPayment-edit', 'residentialConfirmPayment-delete', 'residentialConfirmPayment-show',
            // 'residentialContract-view', 'residentialContract-create', 'residentialContract-edit', 'residentialContract-delete', 'residentialContract-show',
            'residentialChkInstall-view', 'residentialChkInstall-create', 'residentialChkInstall-edit', 'residentialChkInstall-delete', 'residentialChkInstall-show',
            // 'residentialInstallDone-view', 'residentialInstallDone-create', 'residentialInstallDone-edit', 'residentialInstallDone-delete', 'residentialInstallDone-show',
            'residentialRegisteredMeter-view', 'residentialRegisteredMeter-create', 'residentialRegisteredMeter-edit', 'residentialRegisteredMeter-delete', 'residentialRegisteredMeter-show',
            
            'residentialPower-view', 'residentialPower-create', 'residentialPower-edit', 'residentialPower-delete', 'residentialPower-show', /* main link */
            'residentPowerApplication-view', 'residentPowerApplication-create', 'residentPowerApplication-edit', 'residentPowerApplication-delete', 'residentPowerApplication-show',
            'residentialPowerGrdChk-view', 'residentialPowerGrdChk-create', 'residentialPowerGrdChk-edit', 'residentialPowerGrdChk-delete', 'residentialPowerGrdChk-show',
            'residentialPowerTownshipChkGrd-view', 'residentialPowerTownshipChkGrd-create', 'residentialPowerTownshipChkGrd-edit', 'residentialPowerTownshipChkGrd-delete', 'residentialPowerTownshipChkGrd-show',
            'residentialPowerDistrictChkGrd-view', 'residentialPowerDistrictChkGrd-create', 'residentialPowerDistrictChkGrd-edit', 'residentialPowerDistrictChkGrd-delete', 'residentialPowerDistrictChkGrd-show',
            'residentPowerPending-view', 'residentPowerPending-create', 'residentPowerPending-edit', 'residentPowerPending-delete', 'residentPowerPending-show',
            'residentPowerReject-view', 'residentPowerReject-create', 'residentPowerReject-edit', 'residentPowerReject-delete', 'residentPowerReject-show',
            'residentialPowerAnnounce-view', 'residentialPowerAnnounce-create', 'residentialPowerAnnounce-edit', 'residentialPowerAnnounce-delete', 'residentialPowerAnnounce-show',
            'residentialPowerConfirmPayment-view', 'residentialPowerConfirmPayment-create', 'residentialPowerConfirmPayment-edit', 'residentialPowerConfirmPayment-delete', 'residentialPowerConfirmPayment-show',
            // 'residentialPowerContract-view', 'residentialPowerContract-create', 'residentialPowerContract-edit', 'residentialPowerContract-delete', 'residentialPowerContract-show',
            'residentialPowerChkInstall-view', 'residentialPowerChkInstall-create', 'residentialPowerChkInstall-edit', 'residentialPowerChkInstall-delete', 'residentialPowerChkInstall-show',
            // 'residentialPowerInstallDone-view', 'residentialPowerInstallDone-create', 'residentialPowerInstallDone-edit', 'residentialPowerInstallDone-delete', 'residentialPowerInstallDone-show',
            'residentialPowerRegisteredMeter-view', 'residentialPowerRegisteredMeter-create', 'residentialPowerRegisteredMeter-edit', 'residentialPowerRegisteredMeter-delete', 'residentialPowerRegisteredMeter-show',

            'commercialPower-view', 'commercialPower-create', 'commercialPower-edit', 'commercialPower-delete', 'commercialPower-show', /* main link */
            'commercialPowerApplication-view', 'commercialPowerApplication-create', 'commercialPowerApplication-edit', 'commercialPowerApplication-delete', 'commercialPowerApplication-show',
            'commercialPowerGrdChk-view', 'commercialPowerGrdChk-create', 'commercialPowerGrdChk-edit', 'commercialPowerGrdChk-delete', 'commercialPowerGrdChk-show',
            'commercialPowerTownshipChkGrd-view', 'commercialPowerTownshipChkGrd-create', 'commercialPowerTownshipChkGrd-edit', 'commercialPowerTownshipChkGrd-delete', 'commercialPowerTownshipChkGrd-show',
            'commercialPowerDistrictChkGrd-view', 'commercialPowerDistrictChkGrd-create', 'commercialPowerDistrictChkGrd-edit', 'commercialPowerDistrictChkGrd-delete', 'commercialPowerDistrictChkGrd-show',
            'commercialPowerPending-view', 'commercialPowerPending-create', 'commercialPowerPending-edit', 'commercialPowerPending-delete', 'commercialPowerPending-show',
            'commercialPowerReject-view', 'commercialPowerReject-create', 'commercialPowerReject-edit', 'commercialPowerReject-delete', 'commercialPowerReject-show',
            'commercialPowerAnnounce-view', 'commercialPowerAnnounce-create', 'commercialPowerAnnounce-edit', 'commercialPowerAnnounce-delete', 'commercialPowerAnnounce-show',
            'commercialPowerConfirmPayment-view', 'commercialPowerConfirmPayment-create', 'commercialPowerConfirmPayment-edit', 'commercialPowerConfirmPayment-delete', 'commercialPowerConfirmPayment-show',
            // 'commercialPowerContract-view', 'commercialPowerContract-create', 'commercialPowerContract-edit', 'commercialPowerContract-delete', 'commercialPowerContract-show',
            'commercialPowerChkInstall-view', 'commercialPowerChkInstall-create', 'commercialPowerChkInstall-edit', 'commercialPowerChkInstall-delete', 'commercialPowerChkInstall-show',
            // 'commercialPowerInstallDone-view', 'commercialPowerInstallDone-create', 'commercialPowerInstallDone-edit', 'commercialPowerInstallDone-delete', 'commercialPowerInstallDone-show',
            'commercialPowerRegisteredMeter-view', 'commercialPowerRegisteredMeter-create', 'commercialPowerRegisteredMeter-edit', 'commercialPowerRegisteredMeter-delete', 'commercialPowerRegisteredMeter-show',

            'contractor-view', 'contractor-create', 'contractor-edit', 'contractor-delete', 'contractor-show', /* main link */
            'contractorApplication-view', 'contractorApplication-create', 'contractorApplication-edit', 'contractorApplication-delete', 'contractorApplication-show',
            'contractorGrdChk-view', 'contractorGrdChk-create', 'contractorGrdChk-edit', 'contractorGrdChk-delete', 'contractorGrdChk-show',
            'contractorTownshipChkGrd-view', 'contractorTownshipChkGrd-create', 'contractorTownshipChkGrd-edit', 'contractorTownshipChkGrd-delete', 'contractorTownshipChkGrd-show',
            'contractorDistrictChkGrd-view', 'contractorDistrictChkGrd-create', 'contractorDistrictChkGrd-edit', 'contractorDistrictChkGrd-delete', 'contractorDistrictChkGrd-show',
            'contractorDivStateChkGrd-view', 'contractorDivStateChkGrd-create', 'contractorDivStateChkGrd-edit', 'contractorDivStateChkGrd-delete', 'contractorDivStateChkGrd-show',
            'contractorPending-view', 'contractorPending-create', 'contractorPending-edit', 'contractorPending-delete', 'contractorPending-show',
            'contractorReject-view', 'contractorReject-create', 'contractorReject-edit', 'contractorReject-delete', 'contractorReject-show',
            'contractorAnnounce-view', 'contractorAnnounce-create', 'contractorAnnounce-edit', 'contractorAnnounce-delete', 'contractorAnnounce-show',
            'contractorConfirmPayment-view', 'contractorConfirmPayment-create', 'contractorConfirmPayment-edit', 'contractorConfirmPayment-delete', 'contractorConfirmPayment-show',
            // 'contractorContract-view', 'contractorContract-create', 'contractorContract-edit', 'contractorContract-delete', 'contractorContract-show',
            'contractorChkInstall-view', 'contractorChkInstall-create', 'contractorChkInstall-edit', 'contractorChkInstall-delete', 'contractorChkInstall-show',
            'contractorInstallDone-view', 'contractorInstallDone-create', 'contractorInstallDone-edit', 'contractorInstallDone-delete', 'contractorInstallDone-show',
            'contractorRegisteredMeter-view', 'contractorRegisteredMeter-create', 'contractorRegisteredMeter-edit', 'contractorRegisteredMeter-delete', 'contractorRegisteredMeter-show',

            'transformer-view', 'transformer-create', 'transformer-edit', 'transformer-delete', 'transformer-show',
            'transformerApplication-view', 'transformerApplication-create', 'transformerApplication-edit', 'transformerApplication-delete', 'transformerApplication-show',
            'transformerGrdChk-view', 'transformerGrdChk-create', 'transformerGrdChk-edit', 'transformerGrdChk-delete', 'transformerGrdChk-show',
            'transformerTownshipChkGrd-view', 'transformerTownshipChkGrd-create', 'transformerTownshipChkGrd-edit', 'transformerTownshipChkGrd-delete', 'transformerTownshipChkGrd-show',
            'transformerDistrictChkGrd-view', 'transformerDistrictChkGrd-create', 'transformerDistrictChkGrd-edit', 'transformerDistrictChkGrd-delete', 'transformerDistrictChkGrd-show',
            'transformerDivStateChkGrd-view', 'transformerDivStateChkGrd-create', 'transformerDivStateChkGrd-edit', 'transformerDivStateChkGrd-delete', 'transformerDivStateChkGrd-show',
            'transformerHeadChkGrd-view', 'transformerHeadChkGrd-create', 'transformerHeadChkGrd-edit', 'transformerHeadChkGrd-delete', 'transformerHeadChkGrd-show',
            'transformerPending-view', 'transformerPending-create', 'transformerPending-edit', 'transformerPending-delete', 'transformerPending-show',
            'transformerReject-view', 'transformerReject-create', 'transformerReject-edit', 'transformerReject-delete', 'transformerReject-show',
            'transformerAnnounce-view', 'transformerAnnounce-create', 'transformerAnnounce-edit', 'transformerAnnounce-delete', 'transformerAnnounce-show',
            'transformerConfirmPayment-view', 'transformerConfirmPayment-create', 'transformerConfirmPayment-edit', 'transformerConfirmPayment-delete', 'transformerConfirmPayment-show',
            'transformerChkInstall-view', 'transformerChkInstall-create', 'transformerChkInstall-edit', 'transformerChkInstall-delete', 'transformerChkInstall-show',
            'transformerInstallDone-view', 'transformerInstallDone-create', 'transformerInstallDone-edit', 'transformerInstallDone-delete', 'transformerInstallDone-show',
            'transformerRegisteredMeter-view', 'transformerRegisteredMeter-create', 'transformerRegisteredMeter-edit', 'transformerRegisteredMeter-delete', 'transformerRegisteredMeter-show',

            'applyingForm-view', 'applyingForm-create', 'applyingForm-edit', 'applyingForm-delete', 'applyingForm-show',

            'performingForm-view', 'performingForm-create', 'performingForm-edit', 'performingForm-delete', 'performingForm-show',

            'rejectForm-view', 'rejectForm-create', 'rejectForm-edit', 'rejectForm-delete', 'rejectForm-show',

            'pendingForm-view', 'pendingForm-create', 'pendingForm-edit', 'pendingForm-delete', 'pendingForm-show',
            
            'registeredForm-view', 'registeredForm-create', 'registeredForm-edit', 'registeredForm-delete', 'registeredForm-show',
        ];
        $super_permission = [
            'dashboard-view', 'dashboard-create', 'dashboard-edit', 'dashboard-delete', 'dashboard-show',

            'inbox-view', 'inbox-create', 'inbox-edit', 'inbox-delete', 'inbox-show',

            'residential-view', 'residential-create', 'residential-edit', 'residential-delete', 'residential-show', /* main link */
            'residentApplication-view', 'residentApplication-create', 'residentApplication-edit', 'residentApplication-delete', 'residentApplication-show',
            'residentialGrdChk-view', 'residentialGrdChk-create', 'residentialGrdChk-edit', 'residentialGrdChk-delete', 'residentialGrdChk-show',
            'residentialChkGrdTownship-view', 'residentialChkGrdTownship-create', 'residentialChkGrdTownship-edit', 'residentialChkGrdTownship-delete', 'residentialChkGrdTownship-show',
            'residentPending-view', 'residentPending-create', 'residentPending-edit', 'residentPending-delete', 'residentPending-show',
            'residentReject-view', 'residentReject-create', 'residentReject-edit', 'residentReject-delete', 'residentReject-show',
            'residentialAnnounce-view', 'residentialAnnounce-create', 'residentialAnnounce-edit', 'residentialAnnounce-delete', 'residentialAnnounce-show',
            'residentialConfirmPayment-view', 'residentialConfirmPayment-create', 'residentialConfirmPayment-edit', 'residentialConfirmPayment-delete', 'residentialConfirmPayment-show',
            // 'residentialContract-view', 'residentialContract-create', 'residentialContract-edit', 'residentialContract-delete', 'residentialContract-show',
            'residentialChkInstall-view', 'residentialChkInstall-create', 'residentialChkInstall-edit', 'residentialChkInstall-delete', 'residentialChkInstall-show',
            // 'residentialInstallDone-view', 'residentialInstallDone-create', 'residentialInstallDone-edit', 'residentialInstallDone-delete', 'residentialInstallDone-show',
            'residentialRegisteredMeter-view', 'residentialRegisteredMeter-create', 'residentialRegisteredMeter-edit', 'residentialRegisteredMeter-delete', 'residentialRegisteredMeter-show',
            
            'residentialPower-view', 'residentialPower-create', 'residentialPower-edit', 'residentialPower-delete', 'residentialPower-show', /* main link */
            'residentPowerApplication-view', 'residentPowerApplication-create', 'residentPowerApplication-edit', 'residentPowerApplication-delete', 'residentPowerApplication-show',
            'residentialPowerGrdChk-view', 'residentialPowerGrdChk-create', 'residentialPowerGrdChk-edit', 'residentialPowerGrdChk-delete', 'residentialPowerGrdChk-show',
            'residentialPowerTownshipChkGrd-view', 'residentialPowerTownshipChkGrd-create', 'residentialPowerTownshipChkGrd-edit', 'residentialPowerTownshipChkGrd-delete', 'residentialPowerTownshipChkGrd-show',
            'residentialPowerDistrictChkGrd-view', 'residentialPowerDistrictChkGrd-create', 'residentialPowerDistrictChkGrd-edit', 'residentialPowerDistrictChkGrd-delete', 'residentialPowerDistrictChkGrd-show',
            'residentPowerPending-view', 'residentPowerPending-create', 'residentPowerPending-edit', 'residentPowerPending-delete', 'residentPowerPending-show',
            'residentPowerReject-view', 'residentPowerReject-create', 'residentPowerReject-edit', 'residentPowerReject-delete', 'residentPowerReject-show',
            'residentialPowerAnnounce-view', 'residentialPowerAnnounce-create', 'residentialPowerAnnounce-edit', 'residentialPowerAnnounce-delete', 'residentialPowerAnnounce-show',
            'residentialPowerConfirmPayment-view', 'residentialPowerConfirmPayment-create', 'residentialPowerConfirmPayment-edit', 'residentialPowerConfirmPayment-delete', 'residentialPowerConfirmPayment-show',
            // 'residentialPowerContract-view', 'residentialPowerContract-create', 'residentialPowerContract-edit', 'residentialPowerContract-delete', 'residentialPowerContract-show',
            'residentialPowerChkInstall-view', 'residentialPowerChkInstall-create', 'residentialPowerChkInstall-edit', 'residentialPowerChkInstall-delete', 'residentialPowerChkInstall-show',
            // 'residentialPowerInstallDone-view', 'residentialPowerInstallDone-create', 'residentialPowerInstallDone-edit', 'residentialPowerInstallDone-delete', 'residentialPowerInstallDone-show',
            'residentialPowerRegisteredMeter-view', 'residentialPowerRegisteredMeter-create', 'residentialPowerRegisteredMeter-edit', 'residentialPowerRegisteredMeter-delete', 'residentialPowerRegisteredMeter-show',

            'commercialPower-view', 'commercialPower-create', 'commercialPower-edit', 'commercialPower-delete', 'commercialPower-show', /* main link */
            'commercialPowerApplication-view', 'commercialPowerApplication-create', 'commercialPowerApplication-edit', 'commercialPowerApplication-delete', 'commercialPowerApplication-show',
            'commercialPowerGrdChk-view', 'commercialPowerGrdChk-create', 'commercialPowerGrdChk-edit', 'commercialPowerGrdChk-delete', 'commercialPowerGrdChk-show',
            'commercialPowerTownshipChkGrd-view', 'commercialPowerTownshipChkGrd-create', 'commercialPowerTownshipChkGrd-edit', 'commercialPowerTownshipChkGrd-delete', 'commercialPowerTownshipChkGrd-show',
            'commercialPowerDistrictChkGrd-view', 'commercialPowerDistrictChkGrd-create', 'commercialPowerDistrictChkGrd-edit', 'commercialPowerDistrictChkGrd-delete', 'commercialPowerDistrictChkGrd-show',
            'commercialPowerPending-view', 'commercialPowerPending-create', 'commercialPowerPending-edit', 'commercialPowerPending-delete', 'commercialPowerPending-show',
            'commercialPowerReject-view', 'commercialPowerReject-create', 'commercialPowerReject-edit', 'commercialPowerReject-delete', 'commercialPowerReject-show',
            'commercialPowerAnnounce-view', 'commercialPowerAnnounce-create', 'commercialPowerAnnounce-edit', 'commercialPowerAnnounce-delete', 'commercialPowerAnnounce-show',
            'commercialPowerConfirmPayment-view', 'commercialPowerConfirmPayment-create', 'commercialPowerConfirmPayment-edit', 'commercialPowerConfirmPayment-delete', 'commercialPowerConfirmPayment-show',
            // 'commercialPowerContract-view', 'commercialPowerContract-create', 'commercialPowerContract-edit', 'commercialPowerContract-delete', 'commercialPowerContract-show',
            'commercialPowerChkInstall-view', 'commercialPowerChkInstall-create', 'commercialPowerChkInstall-edit', 'commercialPowerChkInstall-delete', 'commercialPowerChkInstall-show',
            // 'commercialPowerInstallDone-view', 'commercialPowerInstallDone-create', 'commercialPowerInstallDone-edit', 'commercialPowerInstallDone-delete', 'commercialPowerInstallDone-show',
            'commercialPowerRegisteredMeter-view', 'commercialPowerRegisteredMeter-create', 'commercialPowerRegisteredMeter-edit', 'commercialPowerRegisteredMeter-delete', 'commercialPowerRegisteredMeter-show',

            'contractor-view', 'contractor-create', 'contractor-edit', 'contractor-delete', 'contractor-show', /* main link */
            'contractorApplication-view', 'contractorApplication-create', 'contractorApplication-edit', 'contractorApplication-delete', 'contractorApplication-show',
            'contractorGrdChk-view', 'contractorGrdChk-create', 'contractorGrdChk-edit', 'contractorGrdChk-delete', 'contractorGrdChk-show',
            'contractorTownshipChkGrd-view', 'contractorTownshipChkGrd-create', 'contractorTownshipChkGrd-edit', 'contractorTownshipChkGrd-delete', 'contractorTownshipChkGrd-show',
            'contractorDistrictChkGrd-view', 'contractorDistrictChkGrd-create', 'contractorDistrictChkGrd-edit', 'contractorDistrictChkGrd-delete', 'contractorDistrictChkGrd-show',
            'contractorDivStateChkGrd-view', 'contractorDivStateChkGrd-create', 'contractorDivStateChkGrd-edit', 'contractorDivStateChkGrd-delete', 'contractorDivStateChkGrd-show',
            'contractorPending-view', 'contractorPending-create', 'contractorPending-edit', 'contractorPending-delete', 'contractorPending-show',
            'contractorReject-view', 'contractorReject-create', 'contractorReject-edit', 'contractorReject-delete', 'contractorReject-show',
            'contractorAnnounce-view', 'contractorAnnounce-create', 'contractorAnnounce-edit', 'contractorAnnounce-delete', 'contractorAnnounce-show',
            'contractorConfirmPayment-view', 'contractorConfirmPayment-create', 'contractorConfirmPayment-edit', 'contractorConfirmPayment-delete', 'contractorConfirmPayment-show',
            // 'contractorContract-view', 'contractorContract-create', 'contractorContract-edit', 'contractorContract-delete', 'contractorContract-show',
            'contractorChkInstall-view', 'contractorChkInstall-create', 'contractorChkInstall-edit', 'contractorChkInstall-delete', 'contractorChkInstall-show',
            'contractorInstallDone-view', 'contractorInstallDone-create', 'contractorInstallDone-edit', 'contractorInstallDone-delete', 'contractorInstallDone-show',
            'contractorRegisteredMeter-view', 'contractorRegisteredMeter-create', 'contractorRegisteredMeter-edit', 'contractorRegisteredMeter-delete', 'contractorRegisteredMeter-show',

            'transformer-view', 'transformer-create', 'transformer-edit', 'transformer-delete', 'transformer-show',
            'transformerApplication-view', 'transformerApplication-create', 'transformerApplication-edit', 'transformerApplication-delete', 'transformerApplication-show',
            'transformerGrdChk-view', 'transformerGrdChk-create', 'transformerGrdChk-edit', 'transformerGrdChk-delete', 'transformerGrdChk-show',
            'transformerTownshipChkGrd-view', 'transformerTownshipChkGrd-create', 'transformerTownshipChkGrd-edit', 'transformerTownshipChkGrd-delete', 'transformerTownshipChkGrd-show',
            'transformerDistrictChkGrd-view', 'transformerDistrictChkGrd-create', 'transformerDistrictChkGrd-edit', 'transformerDistrictChkGrd-delete', 'transformerDistrictChkGrd-show',
            'transformerDivStateChkGrd-view', 'transformerDivStateChkGrd-create', 'transformerDivStateChkGrd-edit', 'transformerDivStateChkGrd-delete', 'transformerDivStateChkGrd-show',
            'transformerHeadChkGrd-view', 'transformerHeadChkGrd-create', 'transformerHeadChkGrd-edit', 'transformerHeadChkGrd-delete', 'transformerHeadChkGrd-show',
            'transformerPending-view', 'transformerPending-create', 'transformerPending-edit', 'transformerPending-delete', 'transformerPending-show',
            'transformerReject-view', 'transformerReject-create', 'transformerReject-edit', 'transformerReject-delete', 'transformerReject-show',
            'transformerAnnounce-view', 'transformerAnnounce-create', 'transformerAnnounce-edit', 'transformerAnnounce-delete', 'transformerAnnounce-show',
            'transformerConfirmPayment-view', 'transformerConfirmPayment-create', 'transformerConfirmPayment-edit', 'transformerConfirmPayment-delete', 'transformerConfirmPayment-show',
            'transformerChkInstall-view', 'transformerChkInstall-create', 'transformerChkInstall-edit', 'transformerChkInstall-delete', 'transformerChkInstall-show',
            'transformerInstallDone-view', 'transformerInstallDone-create', 'transformerInstallDone-edit', 'transformerInstallDone-delete', 'transformerInstallDone-show',
            'transformerRegisteredMeter-view', 'transformerRegisteredMeter-create', 'transformerRegisteredMeter-edit', 'transformerRegisteredMeter-delete', 'transformerRegisteredMeter-show',

            'applyingForm-view', 'applyingForm-create', 'applyingForm-edit', 'applyingForm-delete', 'applyingForm-show',

            'performingForm-view', 'performingForm-create', 'performingForm-edit', 'performingForm-delete', 'performingForm-show',

            'rejectForm-view', 'rejectForm-create', 'rejectForm-edit', 'rejectForm-delete', 'rejectForm-show',

            'pendingForm-view', 'pendingForm-create', 'pendingForm-edit', 'pendingForm-delete', 'pendingForm-show',
            
            'registeredForm-view', 'registeredForm-create', 'registeredForm-edit', 'registeredForm-delete', 'registeredForm-show',
        ];

        foreach ($data as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        $system_role = Role::create(['name' => 'system', 'guard_name' => 'admin']);
        $system_role->givePermissionTo(Permission::all());
        $super_role = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        $super_role->givePermissionTo($super_permission);
        Admin::find(1)->assignRole('system'); /* system */
        Admin::find(2)->assignRole('superadmin'); /* MOEE Admin */
        
        // Role::find(1)->givePermissionTo($data); /* manual permission given */
        
    }
}
