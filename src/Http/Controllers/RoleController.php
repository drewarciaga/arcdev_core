<?php

namespace ArcdevPackages\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use ArcdevPackages\Core\Traits\UtilsTrait;

class RoleController extends Controller
{
    use UtilsTrait;

    public function getAll(Request $request){
        $search = "";
        if(!empty($request->search)){
            $search = $request->search;
        }

        $roles = Role::when(!empty($search), function ($query) use ($search){
                                return $query->where('name', 'like', '%'.$search.'%');
                            })->get();
        $total = sizeof($roles);

        return response()->json([
            'status'    => 200,
            'data'      => $roles,
            'total'     => $total,
        ]);
    }

    public function show($id){
    	$role = Role::find($id);
        
    	return response()->json($role);
    }

    public function store(Request $request){

        $input = $request->all();

        Role::create(['name' => $input['name']]);

        return response()->json('success');
    }
    
    public function update(Request $request, $id){
        $input = $request->all();

        $role = Role::findOrFail($id);

        if(!empty($role)){
            $role->name = $input['name'];
            $role->update();
        }

        return response()->json($role);
    }
    
    public function getRoleList(){
        $roles = Role::select('id as value', 'name as label')->orderBy('name')->get();
        
        return response()->json($roles);
    }

    public function destroy($id){
        $role = Role::find($id);
        $role->delete();

        return response()->json('Delete Role Successful!');
    }
}