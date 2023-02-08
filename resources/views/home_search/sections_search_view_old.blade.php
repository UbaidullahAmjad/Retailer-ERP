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
                                            $html .= '<li class=""> <a href="/articles_search_vieww/' . $engine->linkageTargetId . '/' .  $sub_section->assemblyGroupNodeId .  '/' .  $engine->linkageTargetType .  '">' . $sub_section->assemblyGroupName . '</a> </li>';
                                        }
                                    } else {
                                        $html .= $ul;
                                        foreach ($sub_section as $section) {  
                                            if(count($section->allSubSection) > 0) {
                                                
                                                $html .=  '<li class="list-unstyled"> <a href="#getSubSection_'.$section->assemblyGroupNodeId .'" class="list-unstyled" aria-expanded="false" data-toggle="collapse"><i class="fa fa-chevron-right"></i> ' . $section->assemblyGroupName . '</a> </li>';
                                                return getSubSection($section->allSubSection, $engine, $html, $ul);
                                            }else{
                                                $html .=  '<li class=""> <a href="/articles_search_vieww/' . $engine->linkageTargetId . '/' .  $sub_section->assemblyGroupNodeId .  '/' .  $engine->linkageTargetType . '">' . $section->assemblyGroupName . '</a> </li>';
                                            }
                                        }
                                
                                        $html .= $end_ul;
                                    }

                                    $data = $html;
                                    return $data;                    
                                }
                            @endphp
                            <div class="col-12" style="margin: 0px; padding:0px;overflow-y: auto;
                            height: 600px">
                                <div class="card p-3" style="margin: 0px; height:100%;box-shadow: none !important;border-left:1px solid  rgb(240, 240, 240)">
                                    <div class="row">
                                        {{-- {{dd($sections) }} --}}
                                        @if(count($sections))
                                        @foreach ($sections as $section)
                                        @if(count($section->allSubSection) > 0)
                                        <div class="col-md-6">
                                            <div class="card" style="box-shadow: none !important; border:1px solid rgb(240, 240, 240)">
                                                <div class="card-header article_view_tr_head">
                                                    <h6>{{ $section->assemblyGroupName }}</h6>
                                                </div>
                                                <div class="card-body">
                                                    
                                                    {{-- <ul class=""> --}}
                                                    @foreach ($section->allSubSection as $sub_section)
                                                        <li><a href="{{route('articles_search_vieww', [$engine->linkageTargetId, $sub_section->assemblyGroupNodeId,$engine->linkageTargetType])}}">{{ $sub_section->assemblyGroupName }}</a></li>
                                                    @endforeach
                                                    
                                                        
                                                        
                                                    {{-- </ul> --}}
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-6">
                                            <div class="card" style="box-shadow: none !important; border:1px solid rgb(240, 240, 240)">
                                                <div class="card-header article_view_tr_head">
                                                    <h6>{{ $section->assemblyGroupName }}</h6>
                                                </div>
                                                <div class="card-body">
                                                        <li><a href="{{route('articles_search_vieww', [$engine->linkageTargetId, $section->assemblyGroupNodeId,$engine->linkageTargetType])}}">{{ $section->assemblyGroupName }}</a></li>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                        @else
                                        <p class="text-center" style="color: red">No Sections Available</p>
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
         $(document).ready(function() {
            // $('#search_home').on('click', function(e) {

            //     e.preventDefault();

                if ($(window).outerWidth() > 1199) {
                    $('nav.side-navbar').toggleClass('shrink');
                    $('.page').toggleClass('active');
                    // window.location.href = "/home_search";
                }
            // });
        })
    </script>
@endsection
