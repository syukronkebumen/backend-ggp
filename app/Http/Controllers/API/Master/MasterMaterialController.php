<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterMaterial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterMaterialController extends Controller
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
            $query = MasterMaterial::select(
                'master_material.id',
                'master_material.material_code',
                'master_material.material_description',
                'master_material.batch',
                'master_material.plant',
                'master_material.departement_id',
                'master_departement.departement as departement_name',
                'master_uom.id as uom_id',
                'master_uom.name',
                'master_material.created_at'
            )->leftjoin('master_uom', 'master_uom.id','=','master_material.uom')
            ->leftjoin('master_departement', 'master_departement.id','=','master_material.departement_id');

            if ($request->has('search') && $request->input('search')) {
                $searchTerm = $request->input('search');
                $query->where('material_code', 'like', '%' . $searchTerm . '%');
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

            $data = $query->paginate(10);
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Berhasil get data material'
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
                'material_code' => 'required|unique:master_material',
                'material_description' => 'required',
                'uom' => 'required',
                'batch' => 'required',
                'plant' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }
            $data = MasterMaterial::create([
                'material_code' => $request->material_code,
                'material_description' => $request->material_description,
                'uom' => $request->uom,
                'batch' => $request->batch,
                'plant' => $request->plant,
                'departement_id' => auth()->user()->departement_id
            ]);



            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Berhasil create data material'
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
                'material_description' => 'required',
                'uom' => 'required',
                'batch' => 'required',
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
            $collection = MasterMaterial::where($where)->first();
            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
            $data = MasterMaterial::where($where)->update([
                'material_code' => $request->material_code,
                'material_description' => $request->material_description,
                'uom' => $request->uom,
                'batch' => $request->batch,
                'plant' => $request->plant
            ]);

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Berhasil update data material'
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
            $collection = MasterMaterial::where($where)->first();
            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
            $data = MasterMaterial::find($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Berhasil delete data material'
            ]); 
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
