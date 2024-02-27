<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return ucwords($row->name);
                })
                ->addColumn('email', function ($row) {
                    return $row->email;
                })
                ->addColumn('role', function ($row) {
                    return ucwords($row->getRoleNames()[0]);
                    // return $row->role == 1 ? '<span class="badge btn-danger-material">Super Admin</span>' : '<span class="badge btn-blue-material">Admin</span>';
                })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('user.edit', Crypt::encryptString($row->id)) . '" class="edit-user btn btn-warning-material btn-sm"><i class="mdi mdi-lead-pencil"></i></a>';
                    Auth::user()->id == $row->id ?  $btn .= '<button class="reset-user btn btn-blue-material btn-sm ml-1 d-none" data-id=' .  Crypt::encryptString($row->id) . ' data-name=' . $row->name . ' disabled><i class="mdi mdi-lock"></i></button>'  :  $btn .= '<button class="reset-user btn btn-blue-material btn-sm ml-1" data-id=' .  Crypt::encryptString($row->id) . ' data-name=' . $row->name . '><i class="mdi mdi-lock"></i></button>';
                    Auth::user()->id == $row->id ?  $btn .= '<button class="delete-user btn btn-danger-material btn-sm ml-1 disabled" data-id=' .  Crypt::encryptString($row->id) . ' data-name=' . $row->name . '><i class="mdi mdi-delete"></i></button>' : $btn .= '<button class="delete-user btn btn-danger-material btn-sm ml-1" data-id=' .  Crypt::encryptString($row->id) . ' data-name=' . $row->name . '><i class="mdi mdi-delete"></i></button>';
                    return $btn;
                })


                ->rawColumns(['name', 'email', 'role', 'action'])

                ->make(true);
        }

        return view('content-dashboard.users.index');
    }

    public function add(){
        $roles = Role::all();
        return view('content-dashboard.users.add', compact('roles'));
    }

    public function store(Request $request){
        $checkUsername = User::where('username',$request->username)->first();

        try {
            DB::beginTransaction();

            if($checkUsername){
                return redirect()->route('user.add')->withErrors("Username Sudah Digunakan")->withInput();
            }

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt($request->username . "2024*"),
                'role' => $request->role,
            ]);

            $user->assignRole($request->role);

            DB::commit();

            return redirect()->route('user.index')->with('status', 'Data user berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('user.add')->withErrors($th->getMessage())->withInput();
        }
    }

    public function edit($id){
        try {
            $decrypted = Crypt::decryptString($id);

            $user = User::findOrFail($decrypted);

            $roles = Role::all();

            return view('content-dashboard.users.edit', compact('user', 'roles'));
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function update(Request $request, $id){
        try {
            $decrypted = Crypt::decryptString($id);

            $user = User::findOrFail($decrypted);

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'role' => $request->role
            ]);


            return redirect()->route('user.index')->with('status', 'Data user berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->route('user.index', ['id' => $id])->withErrors($th->getMessage())->withInput();
        }
    }

    public function delete(Request $request){
        try {
            $decrypted = Crypt::decryptString($request->id);
            $userExistOrNot = User::find($decrypted);

            if (empty($userExistOrNot)) {
                return response()->json([
                    'code' => 404,
                    'success' => false,
                    'message' => 'Data user tidak ditemukan'
                ], 404);
            }

            $userExistOrNot->delete();

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
