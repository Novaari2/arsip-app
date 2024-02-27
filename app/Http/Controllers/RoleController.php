<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::all();

            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('role.edit', Crypt::encryptString($row->id)) . '" class="edit-role btn btn-gradient-warning btn-sm"><i class="mdi mdi-lead-pencil"></i></a>';
                    $btn .= '<button class="delete-role btn btn-gradient-danger btn-sm ml-1" data-id=' .  Crypt::encryptString($row->id) . ' data-name="' . $row->name . '"><i class="mdi mdi-delete"></i></button>';
                    return $btn;
                })

                ->rawColumns(['name', 'action'])

                ->make(true);
        }
        return view('content-dashboard.hak_akses.index');
    }

    public function add()
    {
        $permissions = Permission::get();
        return view('content-dashboard.hak_akses.add', compact('permissions'));
    }

    // public function store(Request $request)
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $role = Role::create(['name' => $request->input('name')]);

            $role->syncPermissions($request->input('permission'));

            DB::commit();

            return redirect()->route('role.index')->with('status', 'Role dan Hak Akses berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('role.add')->withErrors($th->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $decrypted = Crypt::decryptString($id);

            $role = Role::findOrFail($decrypted);

            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();

            $permissions = Permission::get();

            return view('content-dashboard.hak_akses.edit', compact('role', 'rolePermissions', 'permissions'));
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $decrypted = Crypt::decryptString($id);

            $role = Role::findOrFail($decrypted);

            $role->update([
                'name' => $request->name
            ]);

            $role->syncPermissions($request->input('permission'));

            return redirect()->route('role.index')->with('status', 'Data role berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->route('role.edit', ['id' => $id])->withErrors($th->getMessage())->withInput();
        }
    }

    public function delete(Request $request)
    {

        try {
            $decrypted = Crypt::decryptString($request->id);
            $roleIsExists = Role::find($decrypted);

            if (empty($roleIsExists)) {
                return response()->json([
                    'code' => 404,
                    'success' => false,
                    'message' => 'Data role tidak ditemukan'
                ], 404);
            }

            $roleIsExists->delete();

            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'Data gagal di hapus'
            ], 500);
        }
    }
}
