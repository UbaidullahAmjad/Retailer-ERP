<?php

namespace App\Http\Controllers\API\React;

use App\Http\Controllers\Controller;
use App\Models\Ambrand;
use App\Models\Article;
use App\Models\AssemblyGroupNode;
use App\Models\ArticleVehicleTree;
use App\Models\LinkageTarget;
use App\Models\Manufacturer;
use App\Models\ModelSeries;
use App\Models\GenericArticle;
use App\Models\ChassisNumber;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeSearchController extends Controller
{
    public function getAllManufacturers(Request $request){
        $type = ["V","L","B","P"];
        $manufacturers = [];
        $count = Manufacturer::whereIn('linkingTargetType', $type)->count();
        $manufacturerss = Manufacturer::whereIn('linkingTargetType', $type)->get();
        foreach ($manufacturerss as $key => $manufacturer) {
            array_push($manufacturers,$manufacturer);
        }
        $page = $request->page;
        $manufacturers_per_page = 10;
        // $products = SupplierProduct::IsActive()->where('supplier_id', $id)->skip(4)->take(4)->get();
        $page_count = (int)ceil($count / $manufacturers_per_page);
        $manufacturer_visit = $page * $manufacturers_per_page;
        $manufacturers = array_slice($manufacturers, $manufacturer_visit - (int)10, $manufacturers_per_page);
        
        $response = [
            
            'success' => true,
            'message' => "good",
            'manufacturers' => $manufacturers,
            "pagination" =>  [
                "total_pages" => $page_count,
                "current_page" => $page,
                "previous_page" => $page - (int)1,
                "next_page" => $page + (int)1,
                "has_next" => ($count > $manufacturer_visit) ? true : false,
                "has_previous" => false
            ],
        ];
        return response()->json($response);
    }

    public function getManufacturers(Request $request){
        



        $type = ["V","L","B","P"];
        $type2 = ["O", "C","T","M","A","K"];
        if($request->type == "P" && $request->sub_type == "home"){
            $manufacturers = [];
            $count = Manufacturer::whereIn('linkingTargetType', $type)->count();
            $manufacturerss = Manufacturer::whereIn('linkingTargetType', $type)->get();
            foreach ($manufacturerss as $key => $manufacturer) {
                array_push($manufacturers,$manufacturer);
            }
            $page = $request->page;
            $manufacturers_per_page = 10;
            // $products = SupplierProduct::IsActive()->where('supplier_id', $id)->skip(4)->take(4)->get();
            $page_count = (int)ceil($count / $manufacturers_per_page);
            $manufacturer_visit = $page * $manufacturers_per_page;
            $manufacturers = array_slice($manufacturers, $manufacturer_visit - (int)10, $manufacturers_per_page);
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'manufacturers' => $manufacturers,
                "pagination" =>  [
                    "total_pages" => $page_count,
                    "current_page" => $page,
                    "previous_page" => $page - (int)1,
                    "next_page" => $page + (int)1,
                    "has_next" => ($count > $manufacturer_visit) ? true : false,
                    "has_previous" => false
                ],
            ];
            return response()->json($response);
        }else if($request->type == "O" && $request->sub_type == "home"){
            $manufacturers = [];
            $count = Manufacturer::whereIn('linkingTargetType', $type2)->count();
            $manufacturerss = Manufacturer::whereIn('linkingTargetType', $type2)->get();
            foreach ($manufacturerss as $key => $manufacturer) {
                array_push($manufacturers,$manufacturer);
            }
            $page = $request->page;
            $manufacturers_per_page = 10;
            // $products = SupplierProduct::IsActive()->where('supplier_id', $id)->skip(4)->take(4)->get();
            $page_count = (int)ceil($count / $manufacturers_per_page);
            $manufacturer_visit = $page * $manufacturers_per_page;
            $manufacturers = array_slice($manufacturers, $manufacturer_visit - (int)10, $manufacturers_per_page);
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'manufacturers' => $manufacturers,
                "pagination" =>  [
                    "total_pages" => $page_count,
                    "current_page" => $page,
                    "previous_page" => $page - (int)1,
                    "next_page" => $page + (int)1,
                    "has_next" => ($count > $manufacturer_visit) ? true : false,
                    "has_previous" => false
                ],
            ];
            return response()->json($response);
        }else{
            $manufacturers = [];
            $count = Manufacturer::where('linkingTargetType', $request->sub_type)->count();
            $manufacturerss = Manufacturer::where('linkingTargetType', $request->sub_type)->get();
            foreach ($manufacturerss as $key => $manufacturer) {
                array_push($manufacturers,$manufacturer);
            }
            $page = $request->page;
            $manufacturers_per_page = 10;
            // $products = SupplierProduct::IsActive()->where('supplier_id', $id)->skip(4)->take(4)->get();
            $page_count = (int)ceil($count / $manufacturers_per_page);
            $manufacturer_visit = $page * $manufacturers_per_page;
            $manufacturers = array_slice($manufacturers, $manufacturer_visit - (int)10, $manufacturers_per_page);
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'manufacturers' => $manufacturers,
                "pagination" =>  [
                    "total_pages" => $page_count,
                    "current_page" => $page,
                    "previous_page" => $page - (int)1,
                    "next_page" => $page + (int)1,
                    "has_next" => ($count > $manufacturer_visit) ? true : false,
                    "has_previous" => false
                ],
            ];
            return response()->json($response);
        }
    }


    public function getModelsByManufacturer(Request $request){
        $type = ["V","L","B","P"];
        $type2 = ["O", "C","T","M","A","K"];
        if($request->type == "P" && $request->sub_type == "home"){
            $models = [];
            $count = ModelSeries::select('modelId', 'modelname')->where('manuId', $request->manufacturer_id)
            ->whereIn('linkingTargetType', $type)->count();
            $modelss = ModelSeries::select('modelId', 'modelname')->where('manuId', $request->manufacturer_id)
                    ->whereIn('linkingTargetType', $type)->get();
            foreach ($modelss as $key => $model) {
                array_push($models,$model);
            }
            $page = $request->page;
            $models_per_page = 10;
            $page_count = (int)ceil($count / $models_per_page);
            $model_visit = $page * $models_per_page;
            $models = array_slice($models, $model_visit - (int)10, $models_per_page);
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'models' => $models,
                "pagination" =>  [
                    "total_pages" => $page_count,
                    "current_page" => $page,
                    "previous_page" => $page - (int)1,
                    "next_page" => $page + (int)1,
                    "has_next" => ($count > $model_visit) ? true : false,
                    "has_previous" => false
                ],
            ];
            return response()->json($response);
        }else if($request->type == "O" && $request->sub_type == "home"){
            $models = [];
            $count = ModelSeries::select('modelId', 'modelname')->where('manuId', $request->manufacturer_id)
            ->whereIn('linkingTargetType', $type2)->count();
            $modelss = ModelSeries::select('modelId', 'modelname')->where('manuId', $request->manufacturer_id)
                    ->whereIn('linkingTargetType', $type2)->get();
            foreach ($modelss as $key => $model) {
                array_push($models,$model);
            }
            $page = $request->page;
            $models_per_page = 10;
            $page_count = (int)ceil($count / $models_per_page);
            $model_visit = $page * $models_per_page;
            $models = array_slice($models, $model_visit - (int)10, $models_per_page);
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'models' => $models,
                "pagination" =>  [
                    "total_pages" => $page_count,
                    "current_page" => $page,
                    "previous_page" => $page - (int)1,
                    "next_page" => $page + (int)1,
                    "has_next" => ($count > $model_visit) ? true : false,
                    "has_previous" => false
                ],
            ];
            return response()->json($response);
        }else{
            $models = [];
            $count = ModelSeries::select('modelId', 'modelname')->where('manuId', $request->manufacturer_id)
            ->where('linkingTargetType', $request->sub_type)->count();
            $modelss = ModelSeries::select('modelId', 'modelname')->where('manuId', $request->manufacturer_id)
                    ->where('linkingTargetType', $request->sub_type)->get();
            foreach ($modelss as $key => $model) {
                array_push($models,$model);
            }
            $page = $request->page;
            $models_per_page = 10;
            $page_count = (int)ceil($count / $models_per_page);
            $model_visit = $page * $models_per_page;
            $models = array_slice($models, $model_visit - (int)10, $models_per_page);
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'models' => $models,
                "pagination" =>  [
                    "total_pages" => $page_count,
                    "current_page" => $page,
                    "previous_page" => $page - (int)1,
                    "next_page" => $page + (int)1,
                    "has_next" => ($count > $model_visit) ? true : false,
                    "has_previous" => false
                ],
            ];
            return response()->json($response);
        }
    }

    public function getEnginesByModel(Request $request){
        ini_set('memory_limit', '666666666666666666666666666666664M');
        $type = ["V","L","B","P"];
        $type2 = ["O", "C","T","M","A","K"];

        if($request->type == "P" && $request->sub_type == "home"){
            $engines = [];
            $count = LinkageTarget::select('linkageTargetId', 'description', 'beginYearMonth', 'endYearMonth')
            ->where('vehicleModelSeriesId', $request->model_id)
            ->whereIn('subLinkageTargetType',$type)->count();
            $enginess = LinkageTarget::select('linkageTargetId', 'description', 'beginYearMonth', 'endYearMonth')
            ->where('vehicleModelSeriesId', $request->model_id)
            ->whereIn('subLinkageTargetType',$type)->get();
            foreach ($enginess as $key => $engine) {
                array_push($engines,$engine);
            }
            $page = $request->page;
            $engines_per_page = 10;
            $page_count = (int)ceil($count / $engines_per_page);
            $engine_visit = $page * $engines_per_page;
            $engines = array_slice($engines, $engine_visit - (int)10, $engines_per_page);
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'engines' => $engines,
                "pagination" =>  [
                    "total_pages" => $page_count,
                    "current_page" => $page,
                    "previous_page" => $page - (int)1,
                    "next_page" => $page + (int)1,
                    "has_next" => ($count > $engine_visit) ? true : false,
                    "has_previous" => false
                ],
            ];
            return response()->json($response);
        }else if($request->type == "O" && $request->sub_type == "home"){
            $engines = [];
            $count = LinkageTarget::select('linkageTargetId', 'description', 'beginYearMonth', 'endYearMonth')
            ->where('vehicleModelSeriesId', $request->model_id)
            ->whereIn('subLinkageTargetType',$type2)->count();
            $enginess = LinkageTarget::select('linkageTargetId', 'description', 'beginYearMonth', 'endYearMonth')
            ->where('vehicleModelSeriesId', $request->model_id)
            ->whereIn('subLinkageTargetType',$type2)->get();
            foreach ($enginess as $key => $engine) {
                array_push($engines,$engine);
            }
            $page = $request->page;
            $engines_per_page = 10;
            $page_count = (int)ceil($count / $engines_per_page);
            $engine_visit = $page * $engines_per_page;
            $engines = array_slice($engines, $engine_visit - (int)10, $engines_per_page);
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'engines' => $engines,
                "pagination" =>  [
                    "total_pages" => $page_count,
                    "current_page" => $page,
                    "previous_page" => $page - (int)1,
                    "next_page" => $page + (int)1,
                    "has_next" => ($count > $engine_visit) ? true : false,
                    "has_previous" => false
                ],
            ];
            return response()->json($response);
        }else{
            $engines = [];
            $count = LinkageTarget::select('linkageTargetId', 'description', 'beginYearMonth', 'endYearMonth')
            ->where('vehicleModelSeriesId', $request->model_id)
            ->where('subLinkageTargetType',$request->sub_type)->count();
            $enginess = LinkageTarget::select('linkageTargetId', 'description', 'beginYearMonth', 'endYearMonth')
            ->where('vehicleModelSeriesId', $request->model_id)
            ->where('subLinkageTargetType',$request->sub_type)->get();
            foreach ($enginess as $key => $engine) {
                array_push($engines,$engine);
            }
            $page = $request->page;
            $engines_per_page = 10;
            $page_count = (int)ceil($count / $engines_per_page);
            $engine_visit = $page * $engines_per_page;
            $engines = array_slice($engines, $engine_visit - (int)10, $engines_per_page);
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'engines' => $engines,
                "pagination" =>  [
                    "total_pages" => $page_count,
                    "current_page" => $page,
                    "previous_page" => $page - (int)1,
                    "next_page" => $page + (int)1,
                    "has_next" => ($count > $engine_visit) ? true : false,
                    "has_previous" => false
                ],
            ];
            return response()->json($response);
        }
    }


    public function getEngineData(Request $request)
    {
        try {
            $engine = LinkageTarget::where('linkageTargetId',$request->engine_id)->where('lang','en')
            ->first();
            // dd($engine);
            return response()->json([
                'data' => $engine
            ], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getSearchSectionByEngine(Request $request){
        
        ini_set('memory_limit', '666666666666666666666666666666664M');
        ini_set('max_execution_time', '66666666666666666666666666666666666666666666666666666'); 
        // dd($engine_id,$type,$sub_type,$model_year,$fuel,$cc);
        $typee = ["P", "V","L","B"];
        $typee2 = ["O", "C","T","M","A","K"];
        $typee3 = ["P",$request->sub_type];
        $typee4 = ["O",$request->sub_type];
        $engine_id = $request->engine_id;
        $type = $request->type;
        $sub_type = $request->sub_type;

        $engine = LinkageTarget::where('linkageTargetId', $engine_id)->where(function($query) use ($sub_type, $type, $typee, $typee2,$typee3,$typee4) {
            if($sub_type != 'home') {
                
                if ($type == "P") {
                    $query->whereIn('linkageTargetType', $typee3);
                } elseif ($type == "O") {
                    $query->whereIn('linkageTargetType', $typee4);
                }
            } else {
                if ($type == "P") {
                    $query->whereIn('linkageTargetType', $typee);
                } elseif ($type == "O") {
                    $query->whereIn('linkageTargetType', $typee2);
                }
            }
        })->where('lang', 'en')
                ->first();
        if(empty($engine)) {
            return response()->json([
                'message' => 'engine not found',
                'error' => true   
            ],500);
        }

        // dd($engine);
                   
        if($type == "P" && $sub_type == "home"){
            $sections = AssemblyGroupNode::groupBy('assemblyGroupNodeId')
            ->whereHas('vehicleTree', function($query) use ($typee , $engine){
                $query->where('carId', $engine->linkageTargetId)
                ->whereIn('linkingTargetType', $typee);

                })
                // ->with('allSubSection', function($data){
                //     $data->limit(3);
                // })
            // ->groupBy('assemblyGroupNodeId')
            ->limit(4)
            ->get();
        } else if ($type == "O" && $sub_type == "home") {
            // dd($request->all());
            $sections = AssemblyGroupNode::groupBy('assemblyGroupNodeId')
            ->whereHas('vehicleTree', function($query) use ($typee2 , $engine){
                        $query->where('carId', $engine->linkageTargetId)
                        ->whereIn('linkingTargetType', $typee2);
                        })
                        // ->with('allSubSection', function($data){
                        //     $data->limit(3);
                        // })
                //    ->groupBy('assemblyGroupNodeId')
                   ->limit(4)
                    ->get();
        } else {
            if($type == "P"){
                $sections = AssemblyGroupNode::groupBy('assemblyGroupNodeId')
                ->whereHas('vehicleTree', function($query) use ($typee3 , $engine){
                    $query->where('carId', $engine->linkageTargetId)
                    ->whereIn('linkingTargetType', $typee3);
                    })
                    // ->with('allSubSection', function($data){
                    //     $data->limit(3);
                    // })
            //    ->groupBy('assemblyGroupNodeId')
               ->limit(4)
                ->get();
            }else if($type == "O"){
                $sections = AssemblyGroupNode::groupBy('assemblyGroupNodeId')
                ->whereHas('vehicleTree', function($query) use ($typee4 , $engine){
                    $query->where('carId', $engine->linkageTargetId)
                    ->whereIn('linkingTargetType', $typee4);
                    })
                    // ->with('allSubSection', function($data){
                    //     $data->limit(3);
                    // })
            //    ->groupBy('assemblyGroupNodeId')
               ->limit(4)
                ->get();
            }
            
        }
        
        $vt = null;
        $avt = null;
        $ga = null;
        $gag = null;
        $all_sections = [];
        foreach ($sections as $key => $sec) {
            $vt = $sec->vehicleTree->first();
            // dd($vt);
            if($vt){
                $avt = DB::table('articlesVehicleTrees2')->where('assemblyGroupNodeId',$vt->assemblyGroupNodeId)->first();
                if($avt){
                    $ga = DB::table('genericarticles')->where('articleId',$avt->legacyArticleId)->first();
                    if($ga){
                        $gag = DB::table('genericarticlesgroups')->where('genericArticleId',$ga->genericArticleId)->first();

                        $res = [
                            'section' => $sec,
                            'vt' => $vt,
                            'avt' => $avt,
                            'ga' => $ga,
                            'gag' => $gag,
                            'master' => $gag->masterDesignation,
                        ];

                        array_push($all_sections,$res);
                    }
                }
            }
            

            
        }
        $c = collect($all_sections);
        $sorted = $c->sortBy('master');
        $arr = [];
        $arr2 = [];
        foreach ($sorted as $key => $value) {
            array_push($arr,$value);
        }
        $collection = collect($arr);
        $unique = $collection->unique('master');
        $unique_arr = $collection->unique('gag');
        foreach ($unique_arr as $key => $value) {
            array_push($arr2,$value);
        }
       $all_sections = $arr2;
       session()->put('seperate_section_load_more',4);
        return response()->json([
            'unique' => $unique,
            'all_sections' => $all_sections,
            'engine' => $engine
        ]);
    }

    public function getSearchSectionByEngineByLoadMore(Request $request){
        
        $seperate_section_load_more = session()->get('seperate_section_load_more');
        ini_set('memory_limit', '666666666666666666666666666666664M');
        ini_set('max_execution_time', '66666666666666666666666666666666666666666666666666666'); 
        // dd($engine_id,$type,$sub_type,$model_year,$fuel,$cc);
        $typee = ["P", "V","L","B"];
        $typee2 = ["O", "C","T","M","A","K"];
        $typee3 = ["P",$request->sub_type];
        $typee4 = ["O",$request->sub_type];
        
        $type = $request->type;
        $sub_type = $request->sub_type;
        $engine_id = $request->engine_id;
        $engine = LinkageTarget::where('linkageTargetId', $engine_id)->where(function($query) use ($sub_type, $type, $typee, $typee2,$typee3,$typee4) {
            if($sub_type != 'home') {
                if ($type == "P") {
                    $query->whereIn('linkageTargetType', $typee3);
                } elseif ($type == "O") {
                    $query->whereIn('linkageTargetType', $typee4);
                }
            } else {
                if ($type == "P") {
                    $query->whereIn('linkageTargetType', $typee);
                } elseif ($type == "O") {
                    $query->whereIn('linkageTargetType', $typee2);
                }
            }
        })->where('lang', 'en')
                ->first();
        if(empty($engine)) {
            return response()->json([
                'message' => 0
            ]);
        }

        // dd($engine);
                   
        if($type == "P" && $sub_type == "home"){
            $sections = AssemblyGroupNode::groupBy('assemblyGroupNodeId')
            ->whereHas('vehicleTree', function($query) use ($typee , $engine){
                $query->where('carId', $engine->linkageTargetId)
                ->whereIn('linkingTargetType', $typee);
                    // $query->whereHas('articleVehicleTree',function($avt_query){
                    //     $avt_query->whereHas('genericArticle',function($ga_query){
                    //         $ga_query->whereHas('genericArticleGroup')->limit(3);
                    //     })->limit(3);
                    // })->limit(3);
                
                })
                // ->with('allSubSection', function($data){
                //     $data->limit(3);
                // })
            ->groupBy('assemblyGroupNodeId')
            ->skip($seperate_section_load_more)->take(4)
            ->get();
        } else if ($type == "O" && $sub_type == "home") {
            // dd($request->all());
            $sections = AssemblyGroupNode::groupBy('assemblyGroupNodeId')
            ->whereHas('vehicleTree', function($query) use ($typee2 , $engine){
                        $query->where('carId', $engine->linkageTargetId)
                        ->whereIn('linkingTargetType', $typee2);
                        })
                        // ->with('allSubSection', function($data){
                        //     $data->limit(3);
                        // })
                   ->groupBy('assemblyGroupNodeId')
                   ->skip($seperate_section_load_more)->take(4)
                    ->get();
        } else {
            
            if($type == "P"){
                $sections = AssemblyGroupNode::groupBy('assemblyGroupNodeId')
                    ->whereHas('vehicleTree', function($query) use ($typee3 , $engine){
                        $query->where('carId', $engine->linkageTargetId)
                        ->whereIn('linkingTargetType', $typee3);
                        })
                        // ->with('allSubSection', function($data){
                        //     $data->limit(3);
                        // })
                ->groupBy('assemblyGroupNodeId')
                ->skip($seperate_section_load_more)->take(4)
                    ->get();
            }else if($type == "O"){
                $sections = AssemblyGroupNode::groupBy('assemblyGroupNodeId')
                    ->whereHas('vehicleTree', function($query) use ($typee4 , $engine){
                        $query->where('carId', $engine->linkageTargetId)
                        ->whereIn('linkingTargetType', $typee4);
                        })
                        // ->with('allSubSection', function($data){
                        //     $data->limit(3);
                        // })
                ->groupBy('assemblyGroupNodeId')
                ->skip($seperate_section_load_more)->take(4)
                    ->get();
            }
        }
        
        $vt = null;
        $avt = null;
        $ga = null;
        $gag = null;
        $all_sections = [];
        foreach ($sections as $key => $sec) {
            $vt = $sec->vehicleTree->first();
            // dd($vt);
            if($vt){
                $avt = DB::table('articlesVehicleTrees2')->where('assemblyGroupNodeId',$vt->assemblyGroupNodeId)->first();
                if($avt){
                    $ga = DB::table('genericarticles')->where('articleId',$avt->legacyArticleId)->first();
                    if($ga){
                        $gag = DB::table('genericarticlesgroups')->where('genericArticleId',$ga->genericArticleId)->first();

                        $res = [
                            'section' => $sec,
                            'vt' => $vt,
                            'avt' => $avt,
                            'ga' => $ga,
                            'gag' => $gag,
                            'master' => $gag->masterDesignation,
                        ];

                        array_push($all_sections,$res);
                    }
                }
            }
            

            
        }
        $c = collect($all_sections);
        $sorted = $c->sortBy('master');
        $arr = [];
        $arr2 = [];
        foreach ($sorted as $key => $value) {
            array_push($arr,$value);
        }
        $collection = collect($arr);
        $unique = $collection->unique('master');
        $unique_arr = $collection->unique('gag');
        foreach ($unique_arr as $key => $value) {
            array_push($arr2,$value);
        }
       $all_sections = $arr2;

        session()->put('seperate_section_load_more', (int)$seperate_section_load_more + (int)4);

        return response()->json([
            'all_sections' => $all_sections,
            'unique' => $unique,
            'engine' => $engine
        ]);


    }


    public function articleSearchView(Request $request){

        // ini_set('memory_limit', '3152M');

        $id = $request->engine_id;
        $section_id = $request->section_id;
        $article_id = $request->article_id;
        $type = $request->type;
        ini_set('memory_limit', '666666666666666666666666666666664M');
        ini_set('max_execution_time', '66666666666666666666666666666666666666666666666666666'); 
        $engine = LinkageTarget::where('linkageTargetId', $id)->where('lang', 'en')->where('linkageTargetType',$type)
                ->first();
        
        $ga = GenericArticle::where('articleId',$article_id)->first();
        
        $gag = $ga->genericArticleGroup;
        
        $avt = DB::table('articlesVehicleTrees2')->where('legacyArticleId',$article_id)->first();
        // dd($avt);
        $avts = DB::table('articlesVehicleTrees2')->where('assemblyGroupNodeId',$avt->assemblyGroupNodeId)->limit(1000)->get();
        $section_parts = [];
        foreach ($avts as $key => $value) {
            $section_part = Article::where('legacyArticleId',$value->legacyArticleId)->where('genericArticleDescription',$gag->designation)->first();
            if($section_part){
                array_push($section_parts,$section_part);
            }
        }
        
        // dd($section_parts);
            // if(count($section_parts) <= 0 || empty($engine)){
            //     toastr()->error("Data not found against your request");
            //         return redirect()->back();
            // }
            $type = $engine->linkageTargetType;
            $sub_type = $engine->subLinkageTargetType;
            $model_year = $engine->model_year;
            $fuel = $engine->fuelType;
            $cc = $engine->capacityCC;
            $car = Car::where('carId',$engine->linkageTargetId)->first();
            
            return response()->json([
                'section_parts' => $section_parts,
                'section_id' => $section_id,
                'type' => $type,
                'sub_type' => $sub_type,
                'model_year' => $model_year,
                'fuel' => $fuel,
                'cc' => $cc,
                'car' => $car,
                'gag' => $gag,
                'ga' => $ga
            ]);
            
        // return view('home_search.article_search_view',compact('article_id','section_parts','section_id','engine','type','sub_type','model_year','fuel','cc','car'));
    }


    public function articleView(Request $request){

        ini_set('memory_limit', '666666666666666666666666666666664M');
        ini_set('max_execution_time', '66666666666666666666666666666666666666666666666666666'); 
        $id = $request->article_id;
        $engine_id = $request->engine_id;
        $sub_section_id = $request->section_id;
        $article = Article::where('legacyArticleId',$id)->first();
        $ga = GenericArticle::where('articleId',$id)->first();
        $gag = $ga->genericArticleGroup;
        // dd($gag);
        $section = $article->section;
        $sub_section = AssemblyGroupNode::where('assemblyGroupNodeId',$sub_section_id)->first();
        $brand = $article->brand;
        $engine = LinkageTarget::where('linkageTargetId',$engine_id)->where('lang','en')->first();
        $manufacturer = null;
        if($engine){
            $manufacturer = Manufacturer::where('manuId',$engine->mfrId)->where('linkingTargetType',$engine->linkageTargetType)->first();
        }
        
        $ean = null;
        $articleEAN = $article->articleEAN;
        if($articleEAN){
            $ean = $articleEAN->eancode;
        }
        $oem_numbers = [];
        if($manufacturer){
            $oem_numbers = $manufacturer->oemNumbers->take(4);
        }

        return response()->json([
            'ga' => $ga,
            'gag' => $gag,
            'article_ean' => $ean,
            'article' => $article,
            'section' => $section,'engine' => $engine,
            'brand' => $brand,
            'sub_section' => $sub_section,
            'manufacturer' => $manufacturer,
            'oem_numbers' => $oem_numbers 
        ]);
        // return view('home_search.article_view',compact('ga','gag','article','section','engine','brand','sub_section','manufacturer','oem_numbers'));
    }
    // ==================================== Search By Brand Start =======================================================

    public function getBrands(Request $request){
        ini_set('memory_limit', '666666666666666666666666666666664M');
        $count = Ambrand::count();
        $ambrandss = Ambrand::all();
        $ambrands= [];
        foreach ($ambrandss as $key => $ambrand) {
            array_push($ambrands,$ambrand);
        }
            $page = $request->page;
            $ambrands_per_page = 10;
            $page_count = (int)ceil($count / $ambrands_per_page);
            $ambrand_visit = $page * $ambrands_per_page;
            $ambrands = array_slice($ambrands, $ambrand_visit - (int)10, $ambrands_per_page);

          
            $response = [
                
                'success' => true,
                'message' => "good",
                'brands' => $ambrands,
                "pagination" =>  [
                    "total_pages" => $page_count,
                    "current_page" => $page,
                    "previous_page" => $page - (int)1,
                    "next_page" => $page + (int)1,
                    "has_next" => ($count > $ambrand_visit) ? true : false,
                    "has_previous" => false
                ],
            ];
            return response()->json($response);
    }


    public function getSubSectionsByBrand(Request $request) {
        

        ini_set('memory_limit', '666666666666666666666666666666664M');
        ini_set('max_execution_time', '66666666666666666666666666666666666666666666666666666');
        
        $section_count  = $request->section_count;
        // dd($section_count);
        
        $sections = [];
        $sectionss = DB::table('AssemblyGroupNodes')
        ->select('AssemblyGroupNodes.assemblyGroupNodeId','AssemblyGroupNodes.assemblyGroupName','Articles.articleNumber','AssemblyGroupNodes.lang')
        ->join('articlesVehicleTrees2','articlesVehicleTrees2.assemblyGroupNodeId','=','AssemblyGroupNodes.assemblyGroupNodeId')
        ->join('Articles','Articles.legacyArticleId','=','articlesVehicleTrees2.legacyArticleId')
        ->where('Articles.dataSupplierId',$request->brand_id)
        ->skip($section_count)->take(10)->get();
        

        // $count = DB::table('AssemblyGroupNodes')
        // ->select('AssemblyGroupNodes.assemblyGroupNodeId','AssemblyGroupNodes.assemblyGroupName','Articles.articleNumber','AssemblyGroupNodes.lang')
        // ->join('articlesVehicleTrees2','articlesVehicleTrees2.assemblyGroupNodeId','=','AssemblyGroupNodes.assemblyGroupNodeId')
        // ->join('Articles','Articles.legacyArticleId','=','articlesVehicleTrees2.legacyArticleId')
        // ->where('Articles.dataSupplierId',$request->brand_id)
        // ->count();

        foreach ($sectionss as $key => $section) {
            // $article = Article::where('legacyArticleId',$section->legacyArticleId)->whereHas('articleVehicleTree')->first();
            
            if($section->lang == "EN"){
                array_push($sections,$section);
            }
            
        }

        // dd($sections);
        
        
       
            $response = [
                // 'count' => $count,
                'sections' => $sections,
                'section_count' =>  (int)$section_count + (int)10
            ];
            return response()->json($response);
    }



    // ------------------------- VIN Search --------------------------------------------------

    public function getChasisNumber(Request $request)
    {
        ini_set('memory_limit', '666666666666666666666666666666664M');
        ini_set('max_execution_time', '66666666666666666666666666666666666666666666666666666'); 
        try {
            $plate_number = explode("-", $request->plate_number);
            if (sizeof($plate_number) != 3 ) {
                return response()->json([
                    'data' => 1,
                    'message' => "Invalid Plate Number"
                ]);
            }
            
            $chasis_number = ChassisNumber::Select('CHASSIS')->where('GAUCHE', $plate_number[0])->where('CD_SERIE', $plate_number[1])->where('DROIT_MIL', $plate_number[2])->first();
            
            if (empty($chasis_number)) {
                return response()->json([
                    'data' => 2,
                    'message' => "Plate number not found"
                ]);
            } else {
                $response = Http::get('https://partsapi.ru/api.php?method=VINdecode&key=f1af8ee7f280a19d3bec7b44a8c64310&vin='.$chasis_number->CHASSIS.'&lang=en');
                // dd($response->body());
                if($response->body() != "null"){                
                    $data = json_decode($response->body());
                    if(isset($data->result)){
                        $d = (array)$data->result;
                        $model = ModelSeries::where('modelname',$d[0]->modelName)->first();
                        return response()->json([
                            'message' => 'found',
                            'data' => $model,
                            'type' => $d[0]->linkageTargetType,
                            'sub_type' => $d[0]->subLinkageTargetType,
                        ]);
                    }else{
                        
                        $d = (array)$data;
                        return response()->json([
                            'data' => 3,
                            'message' => $d['message']                            
                        ]);
                    }                    
                }else{
                    return response()->json([
                        'data' => 4,
                                                 
                    ]);
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getPurchasePlateEngineByModel(Request $request)
    {
        ini_set('memory_limit', '666666666666666666666666666666664M');
        ini_set('max_execution_time', '66666666666666666666666666666666666666666666666666666'); 
        try {

            if($request->model_id == -1){
                return response()->json([
                    'data' => "no"
                ], 200);
            }
            $engines = [];
            // $value = session()->get('plate_engine_count_value');
            $enginess = LinkageTarget::select('linkageTargetId', 'description', 'beginYearMonth', 'endYearMonth')
                ->where('vehicleModelSeriesId', $request->model_id)
                ->get();
            $count = count($enginess);
            foreach ($enginess as $key => $engine) {
                array_push($engines,$engine);
            }

            $page = $request->page;
            $engines_per_page = 10;
            $page_count = (int)ceil($count / $engines_per_page);
            $engine_visit = $page * $engines_per_page;
            $engines = array_slice($engines, $engine_visit - (int)10, $engines_per_page);
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'engines' => $engines,
                "pagination" =>  [
                    "total_pages" => $page_count,
                    "current_page" => $page,
                    "previous_page" => $page - (int)1,
                    "next_page" => $page + (int)1,
                    "has_next" => ($count > $engine_visit) ? true : false,
                    "has_previous" => false
                ],
            ];
            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function getAutoCompleteManufacturers(Request $request){
        $type = ["V","L","B","P"];
        $type2 = ["O", "C","T","M","A","K"];
        if($request->type == "P" && $request->sub_type == "home"){
            
            $manufacturers = Manufacturer::whereIn('linkingTargetType', $type)->where('manuName','like','%'. $request->name. '%')->get();
            
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'manufacturers' => $manufacturers,
                
            ];
            return response()->json($response);
        }else if($request->type == "O" && $request->sub_type == "home"){
            $manufacturers = [];
           
            $manufacturers = Manufacturer::whereIn('linkingTargetType', $type2)->where('manuName','like','%'. $request->name. '%')->get();
            
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'manufacturers' => $manufacturers,
                
            ];
            return response()->json($response);
        }else{
            $manufacturers = [];
            
            $manufacturers = Manufacturer::where('linkingTargetType', $request->sub_type)->where('manuName','like','%'. $request->name. '%')->get();
            
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'manufacturers' => $manufacturers,
                
            ];
            return response()->json($response);
        }

        
    }


    public function getAutoCompleteModels(Request $request){
        $type = ["V","L","B","P"];
        $type2 = ["O", "C","T","M","A","K"];
        if($request->type == "P" && $request->sub_type == "home"){
           
            
            $models = ModelSeries::select('modelId', 'modelname')->where('manuId', $request->manufacturer_id)
                    ->where('modelname','like','%' . $request->name . '%')
                    ->whereIn('linkingTargetType', $type)->get();
            
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'models' => $models,
                
            ];
            return response()->json($response);
        }else if($request->type == "O" && $request->sub_type == "home"){
            
            $models = ModelSeries::select('modelId', 'modelname')->where('manuId', $request->manufacturer_id)
                    ->where('modelname','like','%' . $request->name . '%')
                    ->whereIn('linkingTargetType', $type2)->get();
            
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'models' => $models,
                
            ];
            return response()->json($response);
        }else{
           
           
            $models = ModelSeries::select('modelId', 'modelname')->where('manuId', $request->manufacturer_id)
                    ->where('modelname','like','%' . $request->name . '%')
                    ->where('linkingTargetType', $request->sub_type)->get();
            
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'models' => $models,
            ];
            return response()->json($response);
        }
    }



    public function getAutoCompleteEngines(Request $request){
        ini_set('memory_limit', '666666666666666666666666666666664M');
        $type = ["V","L","B","P"];
        $type2 = ["O", "C","T","M","A","K"];

        if($request->type == "P" && $request->sub_type == "home"){
            
            $engines = LinkageTarget::select('linkageTargetId', 'description', 'beginYearMonth', 'endYearMonth')
            ->where('vehicleModelSeriesId', $request->model_id)
            ->where('description','like','%'. $request->name . '%')
            ->whereIn('subLinkageTargetType',$type)->get();
            
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'engines' => $engines,
                
            ];
            return response()->json($response);
        }else if($request->type == "O" && $request->sub_type == "home"){
            
            
            $engines = LinkageTarget::select('linkageTargetId', 'description', 'beginYearMonth', 'endYearMonth')
            ->where('vehicleModelSeriesId', $request->model_id)
            ->where('description','like','%'. $request->name . '%')
            ->whereIn('subLinkageTargetType',$type2)->get();
            
            
            $response = [
                
                'success' => true,
                'message' => "good",
                'engines' => $engines,
                
            ];
            return response()->json($response);
        }else{
            
            $engines = LinkageTarget::select('linkageTargetId', 'description', 'beginYearMonth', 'endYearMonth')
            ->where('vehicleModelSeriesId', $request->model_id)
            ->where('subLinkageTargetType',$request->sub_type)
            ->where('description','like','%'. $request->name . '%')
            ->get();            
            
            $response = [                
                'success' => true,
                'message' => "good",
                'engines' => $engines,                
            ];
            return response()->json($response);
        }
    }


    
    public function getAutoCompleteBrands(Request $request){
        // $this->sessionData();
            $brands = [];
            $brands = Ambrand::where('brandName','like', '%'. $request->name . '%')->where('lang','EN')->get();
            $response = [
                'brands' => $brands,
                'autocomplete' => 1
            ];
            return response()->json($response);
        
        
    }

    public function getAutoCompleteSectionsByBrand(Request $request){
        ini_set('memory_limit', '666666666666666666666666666666664M');
        ini_set('max_execution_time', '66666666666666666666666666666666666666666666666666666');
        
        // dd($section_count);
        
        $sections = [];
        $sectionss = DB::table('AssemblyGroupNodes')
        ->select('AssemblyGroupNodes.assemblyGroupNodeId','AssemblyGroupNodes.assemblyGroupName','Articles.articleNumber','AssemblyGroupNodes.lang')
        ->join('articlesVehicleTrees2','articlesVehicleTrees2.assemblyGroupNodeId','=','AssemblyGroupNodes.assemblyGroupNodeId')
        ->join('Articles','Articles.legacyArticleId','=','articlesVehicleTrees2.legacyArticleId')
        ->where('Articles.dataSupplierId',$request->brand_id)
        ->where('Articles.articleNumber','like','%'.$request->name . '%')
        ->get();
        

        // $count = DB::table('AssemblyGroupNodes')
        // ->select('AssemblyGroupNodes.assemblyGroupNodeId','AssemblyGroupNodes.assemblyGroupName','Articles.articleNumber','AssemblyGroupNodes.lang')
        // ->join('articlesVehicleTrees2','articlesVehicleTrees2.assemblyGroupNodeId','=','AssemblyGroupNodes.assemblyGroupNodeId')
        // ->join('Articles','Articles.legacyArticleId','=','articlesVehicleTrees2.legacyArticleId')
        // ->where('Articles.dataSupplierId',$request->brand_id)
        // ->count();

        foreach ($sectionss as $key => $section) {
            // $article = Article::where('legacyArticleId',$section->legacyArticleId)->whereHas('articleVehicleTree')->first();
            
            if($section->lang == "EN"){
                array_push($sections,$section);
            }
            
        }

        // dd($sections);
        
        
       
            $response = [
                // 'count' => $count,
                'sections' => $sections,
            ];
            return response()->json($response);
        
    }



    public function articleSearchViewByBrandSection(Request $request){
        // dd($request->all());
        if(empty($request->sub_section_id)){
            return response()->json([
                'error' => true,
                'message' => 'Please Select a Section'
            ],500);
        }
        $section = AssemblyGroupNode::where('assemblyGroupNodeId',$request->sub_section_id)->first();
        // dd($section->vehicleTree->take(10));
        if(!empty($section)){
            $engine = LinkageTarget::where('linkageTargetId',$section->request__linkingTargetId)->first();
            if(empty($engine)){
                return response()->json([
                    'error' => true,
                    'message' => 'Engine not available'
                ],500);
            }


            $ga = [];
            $gag = [];
            $avt = [];
            $vt = $section->vehicleTree->first();
            if($vt){
                $avt = DB::table('articlesVehicleTrees2')->where('assemblyGroupNodeId',$vt->assemblyGroupNodeId)->first();
                if($avt){
                    $ga = DB::table('genericarticles')->where('articleId',$avt->legacyArticleId)->first();
                    if($ga){
                        $gag = DB::table('genericarticlesgroups')->where('genericArticleId',$ga->genericArticleId)->first();
                    }
                }
            }
       
            $avt = DB::table('articlesVehicleTrees2')->where('legacyArticleId',$ga->articleId)->first();
            
            $avts = DB::table('articlesVehicleTrees2')->where('assemblyGroupNodeId',$avt->assemblyGroupNodeId)->limit(1000)->get();
            $section_parts = [];
            foreach ($avts as $key => $value) {
                $section_part = Article::where('legacyArticleId',$value->legacyArticleId)->first();
                if($section_part){
                    array_push($section_parts,$section_part);
                }
            }
           
            $type = $engine->linkageTargetType;
            $sub_type = $engine->subLinkageTargetType;
            $model_year = $engine->model_year;
            $fuel = $engine->fuelType;
            $cc = $engine->capacityCC;


            return response()->json([
                'section_parts' => $section_parts,
                'section_id' => $request->sub_section_id,
                'type' => $type,
                'sub_type' => $sub_type,
                'model_year' => $model_year,
                'fuel' => $fuel,
                'cc' => $cc,
                'car' => $engine,
                'gag' => $gag,
                'ga' => $ga
            ]);
            
        }else{
            return response()->json([
                'error' => true,
                'message' => 'Section not available'
            ],500);
        }
       
       
        
            
            
        // return view('home_search.article_search_view',compact('ga','gag','section_parts','section_id','engine','type','sub_type','model_year','fuel','cc','dual'));
    }

    
}
