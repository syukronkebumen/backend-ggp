<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Master\MasterAdjustmentCategoryController;
use App\Http\Controllers\API\Master\MasterCostCenterController;
use App\Http\Controllers\API\Master\MasterDepartementController;
use App\Http\Controllers\API\Master\MasterGoodRecipientController;
use App\Http\Controllers\API\Master\MasterMaterialController;
use App\Http\Controllers\API\Master\MasterMovementTypeController;
use App\Http\Controllers\API\Master\MasterSbinController;
use App\Http\Controllers\API\Master\MasterSlocController;
use App\Http\Controllers\API\Master\MasterUomController;
use App\Http\Controllers\API\MaterialList\MaterialListController;
use App\Http\Controllers\API\Outbound\OutboundController;
use App\Http\Controllers\API\Permissions\PermissionsController;
use App\Http\Controllers\API\Reference\ReferenceController;
use App\Http\Controllers\API\Roles\RolesController;
use App\Http\Controllers\API\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    // AUTH
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/get_user', [AuthController::class, 'get_user']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'uom' 
], function () {
    Route::resource('master_uom', MasterUomController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'material' 
], function () {
    Route::resource('master_material', MasterMaterialController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'departement' 
], function () {
    Route::resource('master_departement', MasterDepartementController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'cost_center' 
], function () {
    Route::resource('master_cost_center', MasterCostCenterController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'good_recipient' 
], function () {
    Route::resource('master_good_recipient', MasterGoodRecipientController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'mvt' 
], function () {
    Route::resource('master_movement_type', MasterMovementTypeController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'sloc' 
], function () {
    Route::resource('master_storage_location', MasterSlocController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'sbin' 
], function () {
    Route::resource('master_storage_bin', MasterSbinController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'adjustment_category' 
], function () {
    Route::resource('master_adjustment_category', MasterAdjustmentCategoryController::class);
});

Route::group([
    'middleware' => 'api'
], function () {
    Route::resource('roles', RolesController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'users' 
], function () {
    Route::resource('list_users', UserController::class);
});

Route::group([
    'middleware' => 'api',
], function () {
    Route::resource('permissions', PermissionsController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'material' 
], function () {
    Route::resource('material_loc_default', MaterialListController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'reference' 
], function () {
    Route::resource('index', ReferenceController::class);
});


Route::group([
    'middleware' => 'api',
], function () {
    Route::resource('outbound', OutboundController::class);
});
