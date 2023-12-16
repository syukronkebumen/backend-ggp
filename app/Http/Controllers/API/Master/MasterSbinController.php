<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterSbin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterSbinController extends Controller
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
            $data = MasterSbin::select(
                'master_storage_bin.id',
                'master_storage_bin.s_bin',
                'master_storage_location.id as sloc_id',
                'master_storage_location.s_loc',
                'master_storage_location.description',
                'master_storage_location.plant',
                'master_storage_bin.created_at'
            )->leftjoin('master_storage_location','master_storage_location.id','=','master_storage_bin.s_loc')
            ->latest()->paginate(10);
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
                's_bin' => 'required',
                's_loc' => 'required',
                's_loc_description' => 'required',
                'plant' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }
            $data = MasterSbin::create([
                's_bin' => $request->s_bin,
                's_loc' => $request->s_loc,
                's_loc_description' => $request->s_loc_description,
                'plant' => $request->plant
            ]);

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
                's_bin' => 'required',
                's_loc' => 'required',
                's_loc_description' => 'required',
                'plant' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }
            $where = ['id' => $id];
            $collection = MasterSbin::where($where)->first();
            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
            $data = MasterSbin::where($where)->update([
                's_bin' => $request->s_bin,
                's_loc' => $request->s_loc,
                's_loc_description' => $request->s_loc_description,
                'plant' => $request->plant
            ]);

            return response()->json([
                'success' => true,
                'data' => $data,
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
            $where = ['id' => $id];
            $collection = MasterSbin::where($where)->first();
            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
            $data = MasterSbin::find($id);
            $data->delete();

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
