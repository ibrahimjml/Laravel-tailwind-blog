<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
  public function __construct()
{
    $this->middleware('permission:role.view')->only('index');
    $this->middleware('permission:role.create')->only('store');
    $this->middleware('permission:role.update')->only('update');
    $this->middleware('permission:role.delete')->only('destroy');
}
  
    public function index()
    {
        return view('admin.roles',[
          'roles'=> Role::with('permissions')->paginate(6),
          'permissions' => Permission::all()
        ]);
    }

  
    public function store(Request $request)
    {
        $fields = $request->validate([
         'name' =>'required|string',
         'permissions' => 'nullable|array',
         'permissions.*' => 'exists:permissions,id',
         ]);
       $role = Role::create($fields);
        if (!empty($fields['permissions'])) {
        $role->permissions()->sync($fields['permissions']);
    }
  return response()->json([
    'added'=>true,
    'hashtag' => $role->name
  ]);
    }

  public function update(Request $request, string $id)
{
    $data = $request->json()->all(); 

    $validator = Validator::make($data, [
        'name' => 'required|string|max:255',
        'permissions' => 'array|nullable',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'edited' => false,
            'errors' => $validator->errors()
        ], 422);
    }

        $role = Role::find($id);
        $role->update(['name' => $data['name']]);

  
      $role->permissions()->sync($data['permissions'] ?? []);

        return response()->json([
          'edited' => true,
           'message' => 'Role updated successfully'
          ]);
  
}



    public function destroy(string $id)
    {
      $role = Role::find( $id );
      $role->permissions()->detach();
      $role->delete();
    return response()->json([
      'deleted' => true,
      'message' => "role {$role->name} deleted"
  ]);
  }
    
}
