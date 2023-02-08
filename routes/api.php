<?php

use App\Http\Controllers\API\HomeSearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get_all_home_manufacturers', [HomeSearchController::class,"getAllManufacturers"])->name('get_all_home_manufacturers'); 
	Route::get('get_home_manufacturers', [HomeSearchController::class,"getManufacturers"])->name('get_home_manufacturers'); 
	Route::get('get_models_by_manufacturer_home_search', [HomeSearchController::class,"getModelsByManufacturer"])->name('get_models_by_manufacturer_home_search'); 
	Route::get('get_engines_by_model_home_search', [HomeSearchController::class,"getEnginesByModel"])->name('get_engines_by_model_home_search');
	Route::get('get_search_sections_by_engine', [HomeSearchController::class,"getSearchSectionByEngine"])->name('get_search_sections_by_engine');
	Route::post('articles_search_view', [HomeSearchController::class,'articleSearchView'])->name('articles_search_view');
	Route::get('articles_view', [HomeSearchController::class,'articleView'])->name('articles_view');


	Route::get('get_brands', [HomeSearchController::class,'getBrands'])->name('get_brands');
	Route::get('get_sub_sections_by_brand', [HomeSearchController::class,'getSubSectionsByBrand'])->name('get_sub_sections_by_brand');
	Route::get('get_article_by_sub_section', [HomeSearchController::class,'articleSearchViewBySection'])->name('get_article_by_sub_section'); 



	Route::post('cart_data_email', [HomeSearchController::class,'sendEmail'])->name('cart_data_email');

	include 'API/react_apis.php';
