<?php

use App\Http\Controllers\API\React\HomeSearchController;
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

Route::middleware(['cors'])->group(function () {
    Route::get('get_all_home_manufacturers_react', [HomeSearchController::class,"getAllManufacturers"])->name('get_all_home_manufacturers_react'); 
	Route::get('get_home_manufacturers_react', [HomeSearchController::class,"getManufacturers"])->name('get_home_manufacturers_react'); 
	Route::get('get_models_by_manufacturer_home_search_react', [HomeSearchController::class,"getModelsByManufacturer"])->name('get_models_by_manufacturer_home_search_react'); 
	Route::get('get_engines_by_model_home_search_react', [HomeSearchController::class,"getEnginesByModel"])->name('get_engines_by_model_home_search_react');
	Route::get('get_search_sections_by_engine_react', [HomeSearchController::class,"getSearchSectionByEngine"])->name('get_search_sections_by_engine_react');
	Route::get('get_search_sections_by_engine_load_more_react', 'HomeSearchController@getSearchSectionByEngineByLoadMore')->name('get_search_sections_by_engine_load_more_react'); 
	Route::get('get_data_of_engine_home_search_react', 'HomeSearchController@getEngineData')->name('get_data_of_engine_home_search_react'); 

	Route::post('articles_search_view_react', [HomeSearchController::class,'articleSearchView'])->name('articles_search_view_react');
	Route::get('articles_view_react', [HomeSearchController::class,'articleView'])->name('articles_view_react');


	Route::get('get_brands_react', [HomeSearchController::class,'getBrands'])->name('get_brands_react');
	Route::get('get_sub_sections_by_brand_react', [HomeSearchController::class,'searchManufacturers'])->name('get_sub_sections_by_brand_react');



	Route::get('get_all_home_manufacturers_react_search', [HomeSearchController::class,'getAutoCompleteManufacturers'])->name('get_all_home_manufacturers_react_search');
	Route::get('get_all_home_models_react_search', [HomeSearchController::class,'getAutoCompleteModels'])->name('get_all_home_models_react_search');
	Route::get('get_all_home_engines_react_search', [HomeSearchController::class,'getAutoCompleteEngines'])->name('get_all_home_engines_react_search');
	Route::get('get_all_home_brands_react_search', [HomeSearchController::class,'getAutoCompleteBrands'])->name('get_all_home_brands_react_search');
	Route::get('get_all_home_sections_by_brands_react_search', [HomeSearchController::class,'getAutoCompleteSectionsByBrand'])->name('get_all_home_sections_by_brands_react_search');
	// Route::get('get_article_by_sub_section', [HomeSearchController::class,'articleSearchViewBySection'])->name('get_article_by_sub_section'); 



	// Route::post('cart_data_email', [HomeSearchController::class,'sendEmail'])->name('cart_data_email');
	// Vin serach apis

	Route::get('get_chasis_number_react', [HomeSearchController::class,'getChasisNumber'])->name('chasis_number_react.get');
	Route::get('get_purchase_plate_engine_by_model_react', [HomeSearchController::class,'getPurchasePlateEngineByModel'])->name('get_purchase_plate_engine_by_model_react');


	Route::get('get_brands_react', [HomeSearchController::class,'getBrands'])->name('get_brands_react');
	Route::get('get_sub_sections__by_brands_react', [HomeSearchController::class,'getSubSectionsByBrand'])->name('get_sub_sections__by_brands_react');
	Route::get('get_articles_by_brand_section_react', [HomeSearchController::class,'articleSearchViewByBrandSection'])->name('get_articles_by_brand_section_react');


});
    

    




