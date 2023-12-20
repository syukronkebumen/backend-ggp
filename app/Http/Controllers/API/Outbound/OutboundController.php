<?php

namespace App\Http\Controllers\API\Outbound;

use App\Http\Controllers\Controller;
use App\Models\Outbound;
use Exception;
use Illuminate\Http\Request;

class OutboundController extends Controller
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
            $data = Outbound::select(
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
            ->latest()->paginate(20);
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
        //
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
