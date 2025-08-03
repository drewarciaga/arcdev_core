<?php

namespace ArcdevPackages\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use ArcdevPackages\Core\Helpers\Encrypt;
use ArcdevPackages\Core\Traits\UtilsTrait;
use ArcdevPackages\Core\Models\Organizer;
use ArcdevPackages\Core\Models\OrganizerSetting;
use App\Models\User;

class OrganizerSettingController extends Controller
{
    use UtilsTrait;
    use ValidatesRequests;

    public function organizerSettings(){
        if(Auth::user() == null){
            Auth::logout();
            return redirect('/login');
        }

        $user = User::find(Auth::user()->id);


        if(!empty($user->super_admin) || $user->hasRole('super_admin')){
            return Inertia::render('Settings/OrganizerSettings');
        }else{
            return Inertia::render('Unauthorized');
        } 
    }

    public function getOrganizerSettings(){
        $user = User::find(Auth::user()->id);
        if(!empty($user->super_admin) || $user->hasRole('super_admin')){
            $organizer_settings = OrganizerSetting::first();
        }

    	return response()->json(Encrypt::encryptData($organizer_settings));
    }
   
    public function mapModel($organizer_settings, $input){
        $organizer_settings->subscription_start   = isset($input['subscription_start'])? Carbon::create($input['subscription_start']) :null;
        $organizer_settings->subscription_end     = isset($input['subscription_end'])? Carbon::create($input['subscription_end']) :null;
        $organizer_settings->subscription_length  = isset($input['subscription_length'])?$input['subscription_length']:0;
        $organizer_settings->subscription_type    = isset($input['subscription_type'])?$input['subscription_type']:0;
        $organizer_settings->subscription_amount  = isset($input['subscription_amount'])?$input['subscription_amount']:0;
        $organizer_settings->modules              = isset($input['modules'])?$input['modules']:null;
        $organizer_settings->remarks              = isset($input['remarks'])?$input['remarks']:null;

        return $organizer_settings;
    }

    public function saveOrganizerSettings(Request $request){
        $input = $request->all();
        $organizer_settings = OrganizerSetting::first();

        if(empty($organizer_settings)){
            $organizer_settings = new OrganizerSetting();
            $this->validate($request, $organizer_settings->rules, $organizer_settings->messages);

            $organizer_settings->save();
        }else{
            $this->validate($request, $organizer_settings->rules, $organizer_settings->messages);
        }

        $organizer_settings = $this->mapModel($organizer_settings, $input);
        $organizer_settings->update();

        return response()->json($organizer_settings);
    }
}