@extends('layout.main')
@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}
        </div>
    @endif
    <section>
        <style>
            .loader {
   width:50px;
   height:50px;
   display:inline-block;
   padding:0px;
   opacity:0.5;
   border:3px solid #293FCC;
   -webkit-animation: loader 1s ease-in-out infinite alternate;
   animation: loader 1s ease-in-out infinite alternate;
}

.loader:before {
  content: " ";
  position: absolute;
  z-index: -1;
  top: 5px;
  left: 5px;
  right: 5px;
  bottom: 5px;
  border: 3px solid #293FCC;
}

.loader:after {
  content: " ";
  position: absolute;
  z-index: -1;
  top: 15px;
  left: 15px;
  right: 15px;
  bottom: 15px;
  border: 3px solid #293FCC;
}

@keyframes loader {
   from {transform: rotate(0deg) scale(1,1);border-radius:0px;}
   to {transform: rotate(360deg) scale(0, 0);border-radius:50px;}
}
@-webkit-keyframes loader {
   from {-webkit-transform: rotate(0deg) scale(1, 1);border-radius:0px;}
   to {-webkit-transform: rotate(360deg) scale(0,0 );border-radius:50px;}
}


.loader4 {
   width:16px;
   height:16px;
   display:inline-block;
   padding:0px;
   border-radius:100%;
   border:5px solid;
   /* border-top-color:rgba(246, 36, 89, 1); */
   border-bottom-color:rgba(255,255,255, 0.3);
   /* border-left-color:rgba(246, 36, 89, 1); */
   border-right-color:rgba(255,255,255, 0.3);
   -webkit-animation: loader4 1s ease-in-out infinite;
   animation: loader4 1s ease-in-out infinite;
}
@keyframes loader4 {
   from {transform: rotate(0deg);}
   to {transform: rotate(360deg);}
}
@-webkit-keyframes loader4 {
   from {-webkit-transform: rotate(0deg);}
   to {-webkit-transform: rotate(360deg);}
}

        </style>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card p-0">
                        <div class="row m-0">
                            {{-- <div class="col-3" style="margin: 0px; padding:0px; ">
                                <div class="card" style="margin: 0px; padding:0px; height: 100%; box-shadow: none !important;">
                                    <div class="card-body" style="margin: 0px; padding:0px;">
                                        @include('home_search.sidepanel')
                                    </div>
                                </div>
                            </div> --}}
                            
                            @php
                                function getSubSection($sub_section, $engine, $html = "",$ul, $end_ul = "</ul>") {
                                    
                                    
                                    if(!is_array($sub_section) && isset($sub_section->assemblyGroupNodeId)) {
                                        if(count($sub_section->allSubSection) > 0) {
                                            $html .= '<li class="list-unstyled"> <a href="#getSubSection_'.$sub_section->assemblyGroupNodeId .'" class="" aria-expanded="false" data-toggle="collapse"><i class="fa fa-chevron-right"></i> ' . $sub_section->assemblyGroupName . '</a> </li>';
                                            return getSubSection($sub_section->allSubSection, $engine, $html,$ul);
                                        }else{
                                            $html .= '<li class=""> <a href="/articles_search_view/' . $engine->linkageTargetId . '/' .  $sub_section->assemblyGroupNodeId .  '/' .  $engine->linkageTargetType .  '">' . $sub_section->assemblyGroupName . '</a> </li>';
                                        }
                                    } else {
                                        $html .= $ul;
                                        foreach ($sub_section as $section) {  
                                            if(count($section->allSubSection) > 0) {
                                                
                                                $html .=  '<li class="list-unstyled"> <a href="#getSubSection_'.$section->assemblyGroupNodeId .'" class="list-unstyled" aria-expanded="false" data-toggle="collapse"><i class="fa fa-chevron-right"></i> ' . $section->assemblyGroupName . '</a> </li>';
                                                return getSubSection($section->allSubSection, $engine, $html, $ul);
                                            }else{
                                                $html .=  '<li class=""> <a href="/articles_search_view/' . $engine->linkageTargetId . '/' .  $sub_section->assemblyGroupNodeId .  '/' .  $engine->linkageTargetType . '">' . $section->assemblyGroupName . '</a> </li>';
                                            }
                                        }
                                
                                        $html .= $end_ul;
                                    }

                                    $data = $html;
                                    return $data;                    
                                }
                            @endphp
                            <div class="col-12" style="margin: 0px; padding:0px;">
                                <div class="card p-3" style="margin: 0px; height:100%;box-shadow: none !important;border-left:1px solid  rgb(240, 240, 240)">
                                    <div class="row" id="sections_data">
                                       
                                        @if(count($unique) > 0)
                                        @foreach ($unique as $key=>$section)
                                        
                                        <div class="col-md-6">
                                            <div class="card" style="box-shadow: none !important; border:1px solid rgb(240, 240, 240)">
                                                <div class="card-header article_view_tr_head">
                                                    <h6>{{ $section['gag']->masterDesignation }}</h6>
                                                </div>
                                                <div class="card-body">
                                                     @foreach($all_sections as $sub_sec)
                                                     @if($section['gag']->masterDesignation == $sub_sec['gag']->masterDesignation)
                                                    <li><a href="{{route('articles_search_view', [$engine->linkageTargetId, $sub_sec['section']->assemblyGroupNodeId,$engine->linkageTargetType,$sub_sec['ga']->articleId])}}">{{ $sub_sec['gag']->designation }}</a></li>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                        @else
                                        <div class="col-md-12">
                                            <p class="text-center" style="color: red">No Sections Available</p>
                                        </div>
                                        
                                        @endif
                                        
                                    </div>
                                    @if(count($unique) > 0)
                                    <!-- <div class="row">
                                        
                                            <div class="col-lg-6"></div> 
                                            <div class="col-lg-4"><button type="button" class="btn btn-primary" id="load_more">Load More <span style="display:none;"
                                                                    id="seperate_section_load_icon" class="loader4"></span></button></div> 
                                            
                                                   
                                    
                                    </div> -->
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
         $(document).ready(function() {
            // $('#search_home').on('click', function(e) {

            //     e.preventDefault();

                if ($(window).outerWidth() > 1199) {
                    $('nav.side-navbar').toggleClass('shrink');
                    $('.page').toggleClass('active');
                    // window.location.href = "/home_search";
                }
                
                var currentRequest = null;

                
                $("#load_more").click(function(){
                    document.getElementById('seperate_section_load_icon').style.display = "inherit";
                    if(currentRequest != null){
                        currentRequest.abort();
                    }
                    var engine_id = "{{ $engine->linkageTargetId }}";
                    var type = "{{ $type }}";
                    var sub_type = "{{ $sub_type}}";
                    var model_year = "{{ $model_year }}";
                    var fuel = "{{ $fuel }}";
                    var cc = "{{ $cc }}";

                    currentRequest = $.ajax({
                        url: "{{ url('get_search_sections_by_engine_load_more') }}",
                        method: "GET",
                        data: {
                            engine_id: engine_id,
                            type: type,
                            sub_type: sub_type,
                            model_year: model_year,
                            fuel: fuel,
                            cc: cc,
                        },
                        success: function(data){
                            var all_sections = data.all_sections;
                            var unique = data.unique;
                            var engine = data.engine;
                            var html = "";
                            document.getElementById('seperate_section_load_icon').style.display = "none";
                            if(unique.length > 0){
                                $.each(unique, function(key, value) {
                                var html_1 = `<div class="col-md-6">
                                            <div class="card" style="box-shadow: none !important; border:1px solid rgb(240, 240, 240)">
                                                <div class="card-header article_view_tr_head">
                                                    <h6>`+ value.gag.masterDesignation + `</h6>
                                                </div><div class="card-body">`;
                                    $.each(all_sections, function(key2, value2) {
                                        if(value.gag.masterDesignation == value2.gag.masterDesignation){
                                            html_1 += `<li><a href="/articles_search_view/`+ engine.linkageTargetId+`/`+ value2.section.assemblyGroupNodeId +`/`+ engine.linkageTargetType+`/`+ value2.ga.articleId+`">`+  value2.gag.designation +`</a></li>`;
                                        }
                                    });
                                    var new_html = html_1 + `</div></div></div>`;
                                    html+= new_html;
                                });
                            
                                $('#sections_data').append(html);
                            }else{
                                document.getElementById('load_more').style.display = "none";
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Oops...',
                                    text: 'No Section Found',
                                });
                                exit();
                            }
                                          
                                            
                        }
                    });

                });
            // });
        })
    </script>
@endsection
