<?php

namespace App\Http\Controllers\API\MaterialList;

use App\Http\Controllers\Controller;
use App\Models\MaterialList;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialListController extends Controller
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
            $query = MaterialList::select(
                'location_material_default.id',
                'location_material_default.material_code as id_material_code',
                'master_material.material_code',
                'master_material.material_description',
                'master_material.uom',
                'master_uom.name as uom_name',
                'master_material.plant',
                'location_material_default.sbin_id as id_sbin',
                'master_storage_bin.s_bin',
                'master_storage_location.s_loc as sloc_name',
                'master_storage_location.description as sloc_description',
                'location_material_default.created_at'
            )->leftjoin('master_material','master_material.id','=','location_material_default.material_code')
            ->leftjoin('master_uom','master_uom.id','=','master_material.uom')
            ->leftjoin('master_storage_bin','master_storage_bin.id','=','location_material_default.sbin_id')
            ->leftjoin('master_storage_location','master_storage_location.id','=','master_storage_bin.s_loc');
            
            if ($request->has('search') && $request->input('search')) {
                $searchTerm = $request->input('search');
                $query->where('master_material.material_code', 'like', '%' . $searchTerm . '%');
            }

            if ($request->has('sortField') && $request->has('sortOrder')) {
                $sortField = $request->input('sortField');
                $sortOrder = $request->input('sortOrder');

                $allowedFields = ['material_code'];
                if (in_array($sortField, $allowedFields)) {
                    $sortDirection = $sortOrder == 1 ? 'asc' : 'desc';
                    $query->orderBy($sortField, $sortDirection);
                }
            } else {
                $query->latest();
            }

            $data = $query->paginate(20);
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
                'material_code' => 'required',
                'sbin_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }
            $data = MaterialList::create([
                'material_code' => $request->material_code,
                'sbin_id' => $request->sbin_id
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
                'material_code' => 'required',
                'sbin_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }
            $where = ['id' => $id];
            $collection = MaterialList::where($where)->first();
            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
            $data = MaterialList::where($where)->update([
                'material_code' => $request->material_code,
                'sbin_id' => $request->sbin_id
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
        {
            try {
                $where = ['id' => $id];
                $collection = MaterialList::where($where)->first();
                if (!$collection) {
                    return response()->json([
                        'success' => false,
                        'data' => '',
                        'message' => 'ID tidak ditemukan'
                    ]);
                }
                $data = MaterialList::find($id);
                $collection->delete();
    
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
}
