<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
      public function __construct()
{
    $this->middleware('permission:permission.view')->only('index');
    $this->middleware('permission:permission.create')->only('store');
    $this->middleware('permission:permission.update')->only('update');
    $this->middleware('permission:permission.delete')->only('destroy');
}
    public function index()
    {
      return view('admin.permissions', [
               'permissions' => Permission::orderBy('module')
                          ->orderBy('slug')
                          ->get()
                          ->groupBy('module'), 
               ]);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
          'name' =>'required|string',
          'module' => 'required|string',
          'description' => 'sometimes|nullable|string'
             ]);
        $permission = Permission::create($fields);
        return response()->json([
           'added'=>true,
            'Permission' => $permission->name
           ]);
       }

  
    public function update(Request $request, string $id)
    {
      $permission = Permission::find($id);
      $fields = $request->validate([
           'name' =>'required|string',
           'module' => 'required|string',
           'description' => 'sometimes|nullable|string'
    ]);
    $permission->update($fields);
    $permission->save();
    return response()->json([
      'edited'=>true,
      'message' => "Permission {$permission->name} updated",
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $permission = Permission::find( $id );
      $permission->roles()->detach();
      $permission->delete();
    return response()->json([
      'deleted' => true,
      'message' => "permission {$permission->name} deleted"
  ]);
    }
}
