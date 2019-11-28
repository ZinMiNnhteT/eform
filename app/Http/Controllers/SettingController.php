<?php

namespace App\Http\Controllers;

use App\User;
use App\Admin\Admin;
use App\Admin\MailTbl;
use App\Setting\District;
use App\Setting\Township;
use Illuminate\Http\Request;
use App\User\ApplicationForm;
use App\Setting\DivisionState;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class SettingController extends Controller
{
    public function refresh_captcha() {
        return response()->json(['captcha' => captcha_src('flat')]);
    }

    public function reset_division_state(Request $request) {
        $divisions=DivisionState::all();
        $output = '<option value="">'.__("lang.division") .' '. __("lang.choose1").'</option>';
       
        foreach ($divisions as $division) {
            $output .= '<option value="div-'.$division->id.'">';
            if (checkMM() == 'mm') { 
                $output .= $division->name; 
            } else { 
                $output .= $division->eng; 
            }
            $output .= '</option>';
        }

        $data['output']=$output;
        return $data;
    }
    public function filter_division_state(Request $request) {
        $divisionId = $request->get('div_state');
        $division=DivisionState::find($divisionId);
        $districts = District::where('division_state_id', $divisionId)->get();
        $output = '<option value="'.$divisionId.'">';
            if (checkMM() == 'mm') { 
                $output .= $division->name; 
            } else { 
                $output .= $division->eng; 
            }
        $output .= '</option>';
        $output .= '<optgroup label="'.__("lang.district") .' '. __("lang.choose1").'">';
        foreach ($districts as $district) {
            $output .= '<option value="dis-'.$district->id.'">';
            if (checkMM() == 'mm') { 
                $output .= $district->name; 
            } else { 
                $output .= $district->eng; 
            }
            $output .= '</option>';
        }
        $output .= '</optgroup>';

        $data['output']=$output;
        return $data;
    }
    public function filter_district(Request $request) {
        $districtId = $request->get('district');
        $district=District::find($districtId);
        $divisionId=$district->division_state_id;
        $division=DivisionState::find($divisionId);
        $townships = Township::where('district_id', $districtId)->get();
        $output = '<option value="'.$districtId.'">';
            if (checkMM() == 'mm') { 
                $output .= $district->name; 
            } else { 
                $output .= $district->eng; 
            }
        $output .= '</option>';
        $output .= '<option value="'.$divisionId.'" disabled>';
            if (checkMM() == 'mm') { 
                $output .= $division->name; 
            } else { 
                $output .= $division->eng; 
            }
        $output .= '</option>';
        $output .= '<optgroup label="'.__("lang.township") .' '. __("lang.choose1").'">';
        foreach ($townships as $township) {
            $output .= '<option value="town-'.$township->id.'">';
            if (checkMM() == 'mm') { 
                $output .= $township->name; 
            } else { 
                $output .= $township->eng; 
            }
            $output .= '</option>';
        }
        $output .= '</optgroup>';
        $data['hidden']='<input type="hidden" name="div_state_id" value="'.$divisionId.'">';
        $data['output']=$output;
        return $data;
    }
    public function filter_township(Request $request) {
        $townshipId = $request->get('township');
        $township=Township::find($townshipId);
        $divisionId=$township->division_state_id;
        $districtId=$township->district_id;

        $district=District::find($districtId);
        $division=DivisionState::find($divisionId);
        $townships = Township::where('district_id', $districtId)->get();

        $output = '<option value="'.$townshipId.'">';
            if (checkMM() == 'mm') { 
                $output .= $township->name; 
            } else { 
                $output .= $township->eng; 
            }
        $output .= '</option>';
        $output .= '<option value="'.$districtId.'" disabled>';
            if (checkMM() == 'mm') { 
                $output .= $district->name; 
            } else { 
                $output .= $district->eng; 
            }
        $output .= '</option>';
        $output .= '<option value="'.$divisionId.'" disabled>';
            if (checkMM() == 'mm') { 
                $output .= $division->name; 
            } else { 
                $output .= $division->eng; 
            }
        $output .= '</option>';
        $output .= '<optgroup label="'.__("lang.township") .' '. __("lang.choose1").'">';
        foreach ($townships as $township) {
            $output .= '<option value="town-'.$township->id.'">';
            if (checkMM() == 'mm') { 
                $output .= $township->name; 
            } else { 
                $output .= $township->eng; 
            }
            $output .= '</option>';
        }
        $output .= '</optgroup>';
       
        $data['hidden']='<input type="hidden" name="div_state_id" value="'.$divisionId.'">';
        $data['hidden'].='<input type="hidden" name="district_id" value="'.$districtId.'">';
        $data['output']=$output;
        return $data;
    }


    public function choose_region(Request $request) {
        $region_id = $request->get('id');
        
        $districts = District::where('division_state_id', $region_id)->get();
        $townships = Township::where('division_state_id', $region_id)->get();
        // district
        $output1 = '<option value="" selected disabled>';
        $output1 .= __("lang.choose1");
        $output1 .= '</option>';
        foreach ($districts as $district) {
            $output1 .= '<option value="'.$district->id.'">';
            if (checkMM() == 'mm') {
                $output1 .= $district->name;
            } else {
                $output1 .= $district->eng;
            }
            $output1 .= '</option>';
        }
        // township
        $output2 = '<option value="" selected disabled>';
        $output2 .= __("lang.choose1");
        $output2 .= '</option>';
        foreach ($townships as $township) {
            $output2 .= '<option value="'.$township->id.'">';
            if (checkMM() == 'mm') {
                $output2 .= $township->name;
            } else {
                $output2 .= $township->eng;
            }
            $output2 .= '</option>';
        }
        return ['district' => $output1, 'township' => $output2];
    }

    public function choose_district(Request $request) {
        $district_id = $request->get('id');
        $townships = Township::where('district_id', $district_id)->get();
        $output = '<option value="">';
        $output .= __("lang.choose1");
        $output .= '</option>';
        foreach ($townships as $township) {
            $output .= '<option value="'.$township->id.'">';
            if (checkMM() == 'mm') { 
                $output .= $township->name; 
            } else { 
                $output .= $township->eng; 
            }
            $output .= '</option>';
        }
        return $output;
    }

    public function choose_township(Request $request) {
        $township_id = $request->get('id');
        $township = Township::find($township_id);
        $ts_region = DivisionState::find($township->division_state_id);
        $ts_district = District::find($township->district_id);
        if (checkMM() == 'mm') {
            $rname = $ts_region->name;
            $dname =  $ts_district->name;
        } else {
            $rname = $ts_region->eng;
            $dname =  $ts_district->eng;
        }

        return ['r_name' => $rname, 'r_id' => $township->division_state_id, 'd_name' => $dname, 'd_id' => $township->district_id];
    }

    // delete form10 back photo
    public function delete_old_back(Request $request) {
        $form_id = $request->id;
        $old_back = $request->data;
        
        $form = ApplicationForm::find($form_id);
        $folder_name = $form->id.'_'.$form->serial_code;
        $path = public_path('/storage/user_attachments/'.$folder_name);

        if (file_exists($path.'/'.$old_back)) {
            unlink($path.'/'.$old_back);
        }

        $new = $form->application_files()->first();
        $new->form_10_back = null;
        $form->application_files()->save($new);
    }

    /* Auto ation for Role in Admin */
    public function role_chk_action(Request $request) {
        $name = $request->get('name');
        $role = $request->get('role');
        $read_perm = $request->get('read_perm');
        $write_perm = $request->get('write_perm');
        $edit_perm = $request->get('edit_perm');
        $delete_perm = $request->get('delete_perm');
        $detailRead_perm = $request->get('detailRead_perm');
        $confirm_perm = null;
        if ($request->get('confirm_perm') !== null) {
            $confirm_perm = $request->get('confirm_perm');
        }

        /* current */
        $has_role = Role::find($role);

        $has_read = Permission::find($read_perm);
        $has_write = Permission::find($write_perm);
        $has_edit = Permission::find($edit_perm);
        $has_delete = Permission::find($delete_perm);
        $has_detailRead = Permission::find($detailRead_perm);
        $has_confirm = $confirm_perm !== null ? Permission::find($confirm_perm) : null;

        $chk_read_data = DB::table("role_has_permissions")
            ->where([["role_has_permissions.role_id", $role], ["role_has_permissions.permission_id", $read_perm]])
            ->exists();
        $chk_read = $chk_read_data ? true : false;

        $chk_write_data = DB::table("role_has_permissions")
            ->where([["role_has_permissions.role_id", $role], ["role_has_permissions.permission_id", $write_perm]])
            ->exists();
        $chk_write = $chk_write_data ? true : false;

        $chk_edit_data = DB::table("role_has_permissions")
            ->where([["role_has_permissions.role_id", $role], ["role_has_permissions.permission_id", $edit_perm]])
            ->exists();
        $chk_edit = $chk_edit_data ? true : false;

        $chk_delete_data = DB::table("role_has_permissions")
            ->where([["role_has_permissions.role_id", $role], ["role_has_permissions.permission_id", $delete_perm]])
            ->exists();
        $chk_delete = $chk_delete_data ? true : false;

        $chk_detailRead_data = DB::table("role_has_permissions")
            ->where([["role_has_permissions.role_id", $role], ["role_has_permissions.permission_id", $detailRead_perm]])
            ->exists();
        $chk_detailRead = $chk_detailRead_data ? true : false;

        if ($confirm_perm !== null) {
            $chk_confirm_data = DB::table("role_has_permissions")
                ->where([["role_has_permissions.role_id", $role], ["role_has_permissions.permission_id", $confirm_perm]])
                ->exists();
            $chk_confirm = $chk_confirm_data ? true : false;
        } else {
            $chk_confirm = false;
        }

        if ($name == 'read') {
            if ($chk_read_data) {
                $has_role->revokePermissionTo($has_read->name);
                $has_role->revokePermissionTo($has_write->name);
                $has_role->revokePermissionTo($has_edit->name);
                $has_role->revokePermissionTo($has_delete->name);
                $has_role->revokePermissionTo($has_detailRead->name);
                if ($has_confirm !== null) {
                    $has_role->revokePermissionTo($has_confirm->name);
                }
                if ($this->chk_per($has_read->id)[0]) {
                    $has_role->revokePermissionTo($this->chk_per($has_read->id)[1].'-view');
                    // $has_role->revokePermissionTo($this->chk_per($has_read->id)[1].'-create');
                    // $has_role->revokePermissionTo($this->chk_per($has_read->id)[1].'-edit');
                    // $has_role->revokePermissionTo($this->chk_per($has_read->id)[1].'-delete');
                    // $has_role->revokePermissionTo($this->chk_per($has_read->id)[1].'-show');
                }
                $chk_read = false;
                $chk_write = false;
                $chk_edit = false;
                $chk_delete = false;
                $chk_detailRead = false;
                $chk_confirm = false;
            } else {
                $has_role->givePermissionTo($has_read->name);
                if ($this->chk_per($has_read->id)[0]) {
                    $has_role->givePermissionTo($this->chk_per($has_read->id)[1].'-view');
                }
                $chk_read = true;
            }
        } elseif ($name == 'write') {
            if ($chk_write_data) {
                $has_role->revokePermissionTo($has_write->name);
                // if ($this->chk_per($has_write->id)[0]) {
                //     $has_role->revokePermissionTo($this->chk_per($has_write->id)[1].'-create');
                // }
                $chk_write = false;
            } else {
                $has_role->givePermissionTo($has_write->name);
                // if ($this->chk_per($has_write->id)[0]) {
                //     $has_role->givePermissionTo($this->chk_per($has_write->id)[1].'-create');
                // }

                if (!$chk_read) {
                    $has_role->givePermissionTo($has_read->name);
                    if ($this->chk_per($has_read->id)[0]) {
                        $has_role->givePermissionTo($this->chk_per($has_read->id)[1].'-view');
                    }
                    $chk_read = true;
                }
                $chk_write = true;
            }
        } elseif ($name == 'edit') {
            if ($chk_edit_data) {
                $has_role->revokePermissionTo($has_edit->name);
                // if ($this->chk_per($has_edit->id)[0]) {
                //     $has_role->revokePermissionTo($this->chk_per($has_edit->id)[1].'-edit');
                // }
                $chk_edit = false;
            } else {
                $has_role->givePermissionTo($has_edit->name);
                // if ($this->chk_per($has_edit->id)[0]) {
                //     $has_role->givePermissionTo($this->chk_per($has_edit->id)[1].'-edit');
                // }
                if (!$chk_read) {
                    $has_role->givePermissionTo($has_read->name);
                    if ($this->chk_per($has_read->id)[0]) {
                        $has_role->givePermissionTo($this->chk_per($has_read->id)[1].'-view');
                    }
                    $chk_read = true;
                }
                $chk_edit = true;
            }
        } elseif ($name == 'delete') {
            if ($chk_delete_data) {
                $has_role->revokePermissionTo($has_delete->name);
                // if ($this->chk_per($has_delete->id)[0]) {
                //     $has_role->revokePermissionTo($this->chk_per($has_delete->id)[1].'-delete');
                // }
                $chk_delete = false;
            } else {
                $has_role->givePermissionTo($has_delete->name);
                // if ($this->chk_per($has_delete->id)[0]) {
                //     $has_role->givePermissionTo($this->chk_per($has_delete->id)[1].'-delete');
                // }
                if (!$chk_read) {
                    $has_role->givePermissionTo($has_read->name);
                    if ($this->chk_per($has_read->id)[0]) {
                        $has_role->givePermissionTo($this->chk_per($has_read->id)[1].'-view');
                    }
                    $chk_read = true;
                }
                $chk_delete = true;
            }
        } elseif ($name == 'detailRead') {
            if ($chk_detailRead_data) {
                $has_role->revokePermissionTo($has_detailRead->name);
                // if ($this->chk_per($has_detailRead->id)[0]) {
                //     $has_role->revokePermissionTo($this->chk_per($has_detailRead->id)[1].'-show');
                // }
                $chk_detailRead = false;
            } else {
                $has_role->givePermissionTo($has_detailRead->name);
                // if ($this->chk_per($has_detailRead->id)[0]) {
                //     $has_role->givePermissionTo($this->chk_per($has_detailRead->id)[1].'-show');
                // }
                if (!$chk_read) {
                    $has_role->givePermissionTo($has_read->name);
                    if ($this->chk_per($has_read->id)[0]) {
                        $has_role->givePermissionTo($this->chk_per($has_read->id)[1].'-view');
                    }
                    $chk_read = true;
                }
                $chk_detailRead = true;
            }
        } elseif ($name == 'confirm') {
            if ($chk_confirm_data) {
                $has_role->revokePermissionTo($has_confirm->name);
                if ($this->chk_per($has_confirm->id)[0]) {
                    $has_role->revokePermissionTo($this->chk_per($has_detailRead->id)[1].'-show');
                }
                $chk_confirm = false;
            } else {
                $has_role->givePermissionTo($has_confirm->name);
                if ($this->chk_per($has_confirm->id)[0]) {
                    $has_role->givePermissionTo($this->chk_per($has_confirm->id)[1].'-show');
                }
                if (!$chk_read) {
                    $has_role->givePermissionTo($has_read->name);
                    if ($this->chk_per($has_read->id)[0]) {
                        $has_role->givePermissionTo($this->chk_per($has_read->id)[1].'-view');
                    }
                    $chk_read = true;
                }
                $chk_confirm = true;
            }
        }
        return ['read' => $chk_read, 'write' => $chk_write, 'edit' => $chk_edit, 'delete' => $chk_delete, 'detail' => $chk_detailRead, 'confirm' => $chk_confirm];
    }

    public function chk_per($id) {
        $setting = [16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30];

        $residentApplication = [36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69,70,71, 72, 73, 74, 75,76,77, 78,79, 80];

        $residentPower = [86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129,130,131, 132, 133, 134, 135];

        $commercial = [141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189,190];

        $contractorApplication = [196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222, 223, 224, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246, 247, 248, 249,250,251, 252, 253, 254, 255];

        $transformer = [261, 262, 263, 264, 265, 266, 267, 268, 269, 270, 271, 272, 273, 274, 275, 276, 277, 278, 279, 280, 281, 282, 283, 284, 285, 286, 287, 288, 289, 290, 291, 292, 293, 294, 295, 296, 297, 298, 299, 300, 301, 302, 303, 304, 305, 306, 307, 308, 309, 310, 311, 312, 313, 314, 315, 316, 317, 318, 319, 320, 321, 322, 323, 324, 325];

        $res = "";
        foreach ($setting as $find) {
            if ($id == $find) {
                return [TRUE, 'setting'];
            }
        }
        foreach ($residentApplication as $find) {
            if ($id == $find) {
                return [TRUE, 'residential'];
            }
        }
        foreach ($residentPower as $find) {
            if ($id == $find) {
                return [TRUE, 'residentialPower'];
            }
        }
        foreach ($commercial as $find) {
            if ($id == $find) {
                return [TRUE, 'commercialPower'];
            }
        }
        foreach ($contractorApplication as $find) {
            if ($id == $find) {
                return [TRUE, 'contractor'];
            }
        }
        foreach ($transformer as $find) {
            if ($id == $find) {
                return [TRUE, 'transformer'];
            }
        }
    }

    public function mail_detail_show(Request $request) {
        $mail_id = $request->id;
        $data = MailTbl::find($mail_id);
        $user = User::find($data->user_id);
        $form = ApplicationForm::find($data->application_form_id);
        // if ($data->sender_id) {
            // $admin = Admin::find($data->sender_id);
            // $sender_mail = $admin->email;
            // $sender_name = $admin->name;
        // } else {
            $sender_mail = 'noreply@moee.gov.mm';
            $sender_name = 'MOEE ADMIN';
        // }

        if ($data->mail_read == false) {
            $data->mail_read = true;
            $data->mail_seen = true;
            $data->save();
        }
        return [
            'user_name' => $form->fullname,
            'sender_name' => $sender_name,
            'send_type' => mail_type($data->send_type),
            'from' => $sender_mail,
            'to' => $user->email,
            'date' => date('d-m-Y', strtotime($data->mail_send_date)),
            'time' => date('H i a', strtotime($data->mail_send_date)),
            'mail_body' => $data->mail_body,
        ];
    }

    public function disabled_mail_alert() {
        $user_id = Auth::user()->id;
        $mail = MailTbl::where('user_id', $user_id)->get();
        foreach ($mail as $item) {
            $item->mail_seen = true;
            $item->save();
        }
    }

    public function chart_data() {
        $users = User::all();
        $forms = ApplicationForm::all();
        return response()->json([
            'users' => $users,
            'forms' => $forms,
        ]);
    }

    public function lock_account(Request $request) {
        $id = $request->get('id');
        $status = $request->get('status');
        $data = User::find($id);
        if ($status == 1) {
            $data->active = false;
        } else {
            $data->active = true;
        }
        $data->save();
    }
}
