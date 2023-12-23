<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterSloc;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterSlocController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = MasterSloc::select(
                'master_storage_location.id',
                'master_storage_location.s_loc',
                'master_storage_location.description',
                'master_storage_location.plant',
                'master_storage_location.inbound',
                'master_storage_location.outbound',
                'master_storage_location.batch',
                'master_departement.id as departement_id',
                'master_departement.departement',
                'master_storage_location.created_at'
            )->leftjoin('master_departement','master_departement.id','=','master_storage_location.departement');
            
            if ($request->has('search') && $request->input('search')) {
                $searchTerm = $request->input('search');
                $query->where('s_loc', 'like', '%' . $searchTerm . '%');
            }

            if ($request->has('sortField') && $request->has('sortOrder')) {
                $sortField = $request->input('sortField');
                $sortOrder = $request->input('sortOrder');

                $allowedFields = ['s_loc','departement'];
                if (in_array($sortField, $allowedFields)) {
                    $sortDirection = $sortOrder == 1 ? 'asc' : 'desc';
                    $query->orderBy($sortField, $sortDirection);
                }
            } else {
                $query->latest();
            }
            $data = $query->paginate(10);
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
                's_loc' => 'required',
                'description' => 'required',
                'plant' => 'required',
                'inbound' => 'required',
                'outbound' => 'required',
                'batch' => 'required',
                'departement' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }
            $data = MasterSloc::create([
                's_loc' => $request->s_loc,
                'description' => $request->description,
                'plant' => $request->plant,
                'inbound' => $request->inbound,
                'outbound' => $request->outbound,
                'batch' => $request->batch,
                'departement' => $request->departement
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
                's_loc' => 'required',
                'description' => 'required',
                'plant' => 'required',
                'inbound' => 'required',
                'outbound' => 'required',
                'batch' => 'required',
                'departement' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }
            $where = ['id' => $id];
            $collection = MasterSloc::where($where)->first();
            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
            $data = MasterSloc::where($where)->update([
                's_loc' => $request->s_loc,
                'description' => $request->description,
                'plant' => $request->plant,
                'inbound' => $request->inbound,
                'outbound' => $request->outbound,
                'batch' => $request->batch,
                'departement' => $request->departement
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
            $collection = MasterSloc::where($where)->first();
            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
            $data = MasterSloc::find($id);
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
