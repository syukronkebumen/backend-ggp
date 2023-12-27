<?php

namespace App\Http\Controllers\API\Outbound;

use App\Http\Controllers\Controller;
use App\Models\Outbound;
use App\Models\Reference;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OutboundController extends Controller
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
            $query = Outbound::select(
                'outbound.id',
                'outbound.code',
                'outbound.reference_doc',
                'outbound.type',
                'master_storage_location.s_loc',
                'outbound.mvt_id',
                'master_movement_type.mvt_code',
                'master_good_recipient.description',
                'outbound.receiving_sloc',
                'outbound.status',
                'reference.name',
                'outbound.departement_id',
                'master_departement.departement as departement_name',
                'outbound.created_at'

            )->leftjoin('master_departement','master_departement.id','=','outbound.departement_id')
            ->leftjoin('master_movement_type','master_movement_type.id','=','outbound.mvt_id')
            ->leftjoin('reference','reference.id','=','outbound.reference_doc')
            ->leftjoin('master_storage_location','master_storage_location.id','=','reference.sloc_id')
            ->leftjoin('master_good_recipient','master_good_recipient.id','=','reference.good_recipient_id');
            
            if ($request->has('search') && $request->input('search')) {
                $searchTerm = $request->input('search');
                $query->where('code', 'like', '%' . $searchTerm . '%');
            }

            if ($request->has('sortField') && $request->has('sortOrder')) {
                $sortField = $request->input('sortField');
                $sortOrder = $request->input('sortOrder');

                $allowedFields = ['code'];
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
                'mvt_id' => 'required',
                'mvt_id' => 'required',
                'mvt_id' => 'required',
                'mvt_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }
            $data = Permissions::create([
                'name' => $request->name,
                'guard_name' => 'api'
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
        try {
            $data = Outbound::select(
                'outbound.id',
                'outbound.code',
                'outbound.reference_doc',
                'outbound.type',
                'master_storage_location.s_loc',
                'outbound.mvt_id',
                'master_movement_type.mvt_code',
                'master_good_recipient.description',
                'outbound.receiving_sloc',
                'outbound.status',
                'reference.name',
                'outbound.created_at'
            )->leftjoin('master_movement_type','master_movement_type.id','=','outbound.mvt_id')
            ->leftjoin('reference','reference.id','=','outbound.reference_doc')
            ->leftjoin('master_storage_location','master_storage_location.id','=','reference.sloc_id')
            ->leftjoin('master_good_recipient','master_good_recipient.id','=','reference.good_recipient_id')
            
            ->find($id);
            $dataRef = Reference::select(
                'reference.name as reference_name',
                'master_storage_location.s_loc as sloc_name',
                'master_material.material_description',
                'master_material.plant',
                'master_material.uom',
                'master_uom.name as uom_name',
                'master_material.batch'
            )->leftjoin('master_material','master_material.id','=','reference.material_id')
            ->leftjoin('master_storage_location','master_storage_location.id','=','reference.sloc_id')
            ->leftjoin('master_uom','master_uom.id','=','master_material.uom')
            ->find($data->reference_doc);
            $data['data_material'] = $dataRef;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
