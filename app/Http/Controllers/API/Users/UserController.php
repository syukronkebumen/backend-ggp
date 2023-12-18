<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = User::select(
                'users.*',
                'master_storage_location.s_loc as name_sloc',
                'master_departement.departement as name_departement'
            )->leftjoin('master_storage_location','master_storage_location.id','=','users.sloc_id')
            ->leftjoin('master_departement','master_departement.id','=','users.departement_id')
            ->latest()->paginate(10);
            foreach ($data as $item) {
                $data->roles = $item->getRoleNames();
            }
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Berhasil get data'
            ]); 
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'sloc_id' => 'required',
                'departement_id' => 'required',
                'roles' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }

            $setpassword = $request->name;
            $expPassword = explode(' ', $setpassword);
            $fiksPassword = $expPassword[0] . '123456';
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($fiksPassword),
                'pob' => $request->pob,
                'dob' => $request->dob,
                'no_telp' => $request->no_telp,
                'address' => $request->address,
                'sloc_id' => $request->sloc_id,
                'departement_id' => $request->departement_id
            ]);
            if ($request->roles) {
                $collectRoles = $request->roles;
                $expRoles = explode(',', $collectRoles);
                foreach ($expRoles as $item) {
                    $data->assignRole($item);
                }
                $data['roles'] = $data->getRoleNames();
            }

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Berhasil create data'
            ]); 
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'sloc_id' => 'required',
                'departement_id' => 'required',
                'roles' => ''
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }
            $where = ['id' => $id];
            $collection = User::where($where)->first();
            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'ID tidak ditemukan'
                ]);
            }

            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'pob' => $request->pob,
                'dob' => $request->dob,
                'no_telp' => $request->no_telp,
                'address' => $request->address,
                'sloc_id' => $request->sloc_id,
                'departement_id' => $request->departement_id
            ]);

            if ($request->roles) {
                $dataUpdate = User::where('id', $id)->first();
                $dataUpdate->roles()->detach(); //remove all roles
                $collectRoles = $request->roles;
                $expRoles = explode(',', $collectRoles);
                foreach ($expRoles as $item) {
                    $dataUpdate->assignRole($item);
                }
                $dataUpdate['roles'] = $dataUpdate->getRoleNames();
            }

            return response()->json([
                'success' => true,
                'data' => $dataUpdate,
                'message' => 'Berhasil update data'
            ]); 
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = User::find($id);
            $where = ['id' => $id];
            $collection = User::where($where)->first();
            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
            $data->delete();
            $data->roles()->detach();
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Berhasil delete data'
            ]); 
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
