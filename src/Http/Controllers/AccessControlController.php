<?php

namespace ArcdevPackages\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use ArcdevPackages\Core\Helpers;
use ArcdevPackages\Core\Traits\UtilsTrait;

class AccessControlController extends Controller
{
    use UtilsTrait;

    public function index(){
        return Inertia::render('AccessControl/Index');
    }

    public function getUserRole($user_id){
        $user_id = decodeId($user_id);
        $role_ids = DB::table('model_has_roles')->where('model_type', 'App\Models\User')->where('model_id', $user_id)->pluck('role_id');

    	return response()->json($role_ids);
    }

    public function updateUserRole(Request $request){
        $user_id = decodeId($request->user_id);
        $roles = Role::whereIn('id', $request->role_ids)->pluck('name');

        $user_found = User::find($user_id);
        if(!empty($user_found)){
            $user_found->syncRoles($roles);
        }

        return "success";
    }

    public function show($id){
    	$user = User::find($id);

    	return response()->json($user);
    }
}