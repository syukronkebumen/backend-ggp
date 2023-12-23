<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterGoodRecipient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterGoodRecipientController extends Controller
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
            $query = MasterGoodRecipient::select(
                'master_good_recipient.id',
                'master_good_recipient.code',
                'master_good_recipient.description',
                'master_departement.id as departement_id',
                'master_departement.departement',
                'master_good_recipient.created_at',
            )->leftjoin('master_departement','master_departement.id','=','master_good_recipient.departement');

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
                'code' => 'required',
                'description' => 'required',
                'departement' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }
            $data = MasterGoodRecipient::create([
                'code' => $request->code,
                'description' => $request->description,
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
                'code' => 'required',
                'description' => 'required',
                'departement' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => $validator->errors()
                ]);
            }
            $where = ['id' => $id];
            $collection = MasterGoodRecipient::where($where)->first();
            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
            $data = MasterGoodRecipient::where($where)->update([
                'code' => $request->code,
                'description' => $request->description,
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
            $collection = MasterGoodRecipient::where($where)->first();
            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
            $data = MasterGoodRecipient::select(
                'master_good_recipient.code',
                'master_good_recipient.description',
                'master_departement.departement',
                'master_good_recipient.created_at',
            )->leftjoin('master_departement','master_departement.id','=','master_good_recipient.departement')
            ->find($id);
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
