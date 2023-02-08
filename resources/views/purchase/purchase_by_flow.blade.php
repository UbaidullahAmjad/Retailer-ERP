<div class="row">
    <div class="col-md-12">
        <div id="other_data"></div>
        <div class="row">
            {{-- <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('file.Date') }}</label>
                    <input type="text" id="product_purchase_date" name="created_at" class="form-control date"
                        placeholder="Choose date" />
                </div>
            </div> --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label>Engine Type</label>
                    <select name="linkageTargetType" id="linkageTarget" class="selectpicker form-control"
                        data-live-search="true" data-live-search-style="begins">
                        <option>Select Type</option>
                        <option value="P">Passenger</option>
                        <option value="O">Commercial Vehicle and Tractor</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Engine Sub-Type</label>
                    <select name="subLinkageTargetType" data-href="{{ route('get_manufacturers_by_engine_type') }}"
                        id="subLinkageTarget" class="selectpicker form-control" data-live-search="true"
                        data-live-search-style="begins">
                        <option value="-2">Select One</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('file.Manufacturers') }}</label>
                    {{-- <select name="manufacture_id" id="manufacturer_id" class="selectpicker form-control"
                        data-live-search="true" data-live-search-style="begins" title="Select Manufacturer..."
                        data-href="{{ route('get_models_by_manufacturer') }}">
                    </select> --}}
                    <input type="hidden" name="manufacturer_id" id="manufacturer_id">
                    <div class="dropdown">
                        <div class="dropdown-header manufacturer form-control">{{ __('Select Manufacturer') }}
                        </div>
                        <div class="dropdown-content manufacturer_content form-control">
                            <input type="text" placeholder="" id="manufacturer_input_search"
                                onkeyup="filterPurchaseManufacturer()">
                            <div class="normal-option">

                            </div>
                            <div class="more manufacturer_more" style="display: none;" id="manufacturer_more"><span>Load
                                    More
                                    &nbsp;&nbsp;<span> <span style="display:none;" id="manufacturer_load_icon"
                                            class="loader4"></span></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="model_id">{{ __('Select Model') }}</label>
                    {{-- <select name="model_id" id="model_id" data-href="{{ route('get_engines_by_model') }}"
                        class="selectpicker form-control" data-live-search="true" data-live-search-style="begins"
                        required>
                    </select> --}}
                    <input type="hidden" id="model_id" name="model_id">
                    <div class="dropdown">
                        <div class="dropdown-header model form-control">
                            {{ __('Select Model') }}</div>
                        <div class="dropdown-content model_content form-control">
                            <input type="text" placeholder="" id="model_input_search" onkeyup="filterModel()">
                            <div class="model_normal_option">

                            </div>
                            <div class="more model_more" id="model_more"> <span>Load More
                                    &nbsp;&nbsp;<span> <span style="display:none;" id="model_load_icon"
                                            class="loader4"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="engine_id">{{ __('Select Engine') }}</label>
                    {{-- <select name="engine_id" id="engine_id" data-href="{{ route('get_sections_by_engine') }}"
                        class="selectpicker form-control" data-live-search="true" data-live-search-style="begins"
                        required>
                    </select> --}}
                    <input type="hidden" id="engine_id" name="engine_id">
                    <div class="dropdown">
                        <div class="dropdown-header engine form-control">
                            {{ __('Select Engine') }}</div>
                        <div class="dropdown-content engine_content form-control">
                            <input type="text" placeholder="" id="engine_input_search" onkeyup="filterEngine()">
                            <div class="engine_normal_option">

                            </div>
                            <div class="more engine_more" id="engine_more"> <span>Load More
                                    &nbsp;&nbsp;<span> <span style="display:none;" id="engine_load_icon"
                                            class="loader4"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="section_id">{{ __('Select Section') }}</label>
                    {{-- <select name="section_id" id="section_id" data-href="{{ route('get_section_parts') }}"
                        class="selectpicker form-control" data-live-search="true" data-live-search-style="begins"
                        required>
                    </select> --}}
                    <input type="hidden" id="section_id" name="section_id">
                    <div class="dropdown">
                        <div class="dropdown-header section form-control">
                            {{ __('Select Section') }}</div>
                        <div class="dropdown-content section_content form-control">
                            <input type="text" placeholder="" id="section_input_search" onkeyup="filterSection()">
                            <div class="section_normal_option">

                            </div>
                            <div class="more section_more" id="section_more"> <span>Load More
                                    &nbsp;&nbsp;<span> <span style="display:none;" id="section_load_icon"
                                            class="loader4"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="section_part_id">{{ __('Select Section Part') }}</label>
                    {{-- <select name="section_part_id" id="section_part_id"
                        data-href="{{ route('get_brands_by_section_part') }}" data-live-search="true"
                        data-live-search-style="begins" class="selectpicker form-control" required>
                    </select> --}}
                    <input type="hidden" id="section_part_id" name="section_part_id">
                    <div class="dropdown">
                        <div class="dropdown-header section_part form-control">
                            {{ __('Select Section Part') }}</div>
                        <div class="dropdown-content section_part form-control">
                            <input type="text" placeholder="" id="section_part_input_search" onkeyup="filterSectionPart()">
                            <div class="section_part_normal_option">

                            </div>
                            <div class="more section_part_more" id="section_part_more"> <span>Load More
                                    &nbsp;&nbsp;<span> <span style="display:none;" id="section_part_load_icon"
                                            class="loader4"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="brand">{{ __('Select Supplier') }} (Brand)</label>
                    {{-- <select name="brand_id" id="brand_id" class="selectpicker form-control" data-live-search="true"
                        data-live-search-style="begins" required>
                    </select> --}}
                    <input type="hidden" id="brand_id" name="brand_id">
                    <div class="dropdown">
                        <div class="dropdown-header brand form-control">
                            {{ __('Select Supplier') }} (Brand)</div>
                        <div class="dropdown-content brand form-control">
                            <input type="text" placeholder="" id="brand_input_search" onkeyup="filterBrands()">
                            <div class="brand_normal_option">

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <div class="form-group">
                    <button type="button" class="btn btn-info purchase-save-btn"
                        id="save-btn">{{ trans('file.Save') }}</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>
    // ALL FILTER FUNCTIONS ========================
    function filterPurchaseManufacturer() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("manufacturer_input_search");
        filter = input.value.toUpperCase();
        if (input.value) {
            document.getElementById('manufacturer_more').style.display = "none";
        } else {
            document.getElementById('manufacturer_more').style.display = "block";
        }
        div = document.getElementsByClassName("normal-option");
        a = document.getElementsByClassName("option");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }

    }

    function filterModel() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("model_input_search");
        filter = input.value.toUpperCase();
        if (input.value) {
            document.getElementById('model_more').style.display = "none";
        } else {
            document.getElementById('model_more').style.display = "block";
        }
        div = document.getElementsByClassName("model_normal_option");
        a = document.getElementsByClassName("model_option");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }

    }

    function filterEngine() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("engine_input_search");
        filter = input.value.toUpperCase();
        if (input.value) {
            document.getElementById('engine_more').style.display = "none";
        } else {
            document.getElementById('engine_more').style.display = "block";
        }
        div = document.getElementsByClassName("engine_normal_option");
        a = document.getElementsByClassName("engine_option");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }

    }

    function filterSection() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("section_input_search");
        filter = input.value.toUpperCase();
        if (input.value) {
            document.getElementById('section_more').style.display = "none";
        } else {
            document.getElementById('section_more').style.display = "block";
        }
        div = document.getElementsByClassName("section_normal_option");
        a = document.getElementsByClassName("section_option");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }

    }

    function filterSectionPart() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("section_part_input_search");
        filter = input.value.toUpperCase();
        if (input.value) {
            document.getElementById('section_part_more').style.display = "none";
        } else {
            document.getElementById('section_part_more').style.display = "block";
        }
        div = document.getElementsByClassName("section_part_normal_option");
        a = document.getElementsByClassName("section_part_option");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }

    }

    function filterBrands() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("brand_input_search");
        filter = input.value.toUpperCase();
        // if (input.value) {
        //     document.getElementById('brands_more').style.display = "none";
        // } else {
        //     document.getElementById('section_part_more').style.display = "block";
        // }
        div = document.getElementsByClassName("brand_normal_option");
        a = document.getElementsByClassName("brand_option");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }

    }
    // ALL Filter fucntion end =================== 
    $('#linkageTarget').on('change', function() {
        var val = this.value;
        if (val == "P") {
            $('#subLinkageTarget').empty();
            $('#subLinkageTarget').append(`<option value="V">
                        Passenger Car
                          </option><option value="L">
                               LCV
                          </option><option value="B">
                                Motorcycle
                          </option>`);
            $('.selectpicker').selectpicker('refresh');
        } else if (val == "O") {
            $('#subLinkageTarget').empty();
            $('#subLinkageTarget').append(`<option value="C">
                    Commercial Vehicle
                          </option><option value="T">
                               Tractor
                          </option><option value="M">
                               Engine
                          </option><option value="A">
                               Axle
                          </option><option value="K">
                               CV Body Type
                          </option>`);
            $('.selectpicker').selectpicker('refresh');
        } else {
            $('#subLinkageTarget').empty();
            $('.selectpicker').selectpicker('refresh');
        }
        $('#manufacturer_id').html('<option value="">Select One</option>');
        $('#manufacturer_id').selectpicker("refresh");
        $('#section_id').html('<option value="">Select One</option>');
        $('#section_id').selectpicker("refresh");
        $('#section_part_id').html('<option value="">Select One</option>');
        $('#section_part_id').selectpicker("refresh");
        $('#engine_id').html('<option value="">Select One</option>');
        $('#engine_id').selectpicker("refresh");
    });

    // get manufacturers dropdown code
    var manufacturer_id_check_array = [];
    $('.dropdown-header.manufacturer').click(function(event) {
        $('.dropdown-content.manufacturer_content').toggle();
        event.stopPropagation();
    })
    $(document).on('change', '#subLinkageTarget', function() {
        let engine_sub_type = $(this).val();
        let url = $(this).attr('data-href');
        $.get(url + '?engine_sub_type=' + engine_sub_type, function(data) {

            let response = data.data;
            if (data.manu_more_value > data.total_count) {
                document.getElementById('manufacturer_more').style.display = "none";
            } else {
                document.getElementById('manufacturer_more').style.display = "block";
            }
            console.log(data.total_count, data.manu_more_value);
            if (response.length > 0) {
                $.each(response, function(key, value) {
                    manufacturer_id_check_array.push(value.manuId);
                    $('.normal-option').append($(
                        '<div class="option" id="manu_id" data-manufacturer_id="' +
                        value.manuId + '">').html(value.manuName));
                });
            } else {
                console.log(data)
                $('.normal-option').append(
                    "<span style='color:red;text-align:center;font-size:13px'>No Record Found</span>"
                );
            }


        })
    });
    $('.more.manufacturer_more').click(function(event) {
        let engine_sub_type = $('#subLinkageTarget :selected').val();
        let url = "{{ route('get_manufacturers_by_engine_type') }}";
        document.getElementById('manufacturer_load_icon').style.display = "block";
        $.get(url + '?engine_sub_type=' + engine_sub_type, function(data) {

            let response = data.data;
            document.getElementById('manufacturer_load_icon').style.display = "none";

            if (data.manu_more_value > data.total_count) {
                document.getElementById('manufacturer_more').style.display = "none";
            } else {
                document.getElementById('manufacturer_more').style.display = "block";
            }
            console.log(data.total_count, data.manu_more_value);
            if (response.length > 0) {
                $.each(response, function(key, value) {
                    manufacturer_id_check_array.push(value.manuId);
                    $('.normal-option').append($(
                        '<div class="option" id="manu_id" data-manufacturer_id="' +
                        value.manuId + '">').html(value.manuName));
                });
            } else {
                console.log(data)
                $('.normal-option').append(
                    "<span style='color:red;text-align:center;font-size:13px'>No Record Found</span>"
                );
            }


        })
    });


    //get models==================     --------------------------------
    var manufacturer_id_set = 0;
    $(document.body).on('click', '.option:not(.manufacturer_more)', function(
        event) { // click on brand to get sections
        model_id_check_array = [];
        $('.dropdown-header.model').html("Select Model");
        $('.dropdown-header.engine').html("Select Engine");
        $('.model_normal_option').empty();
        $('.engine_normal_option').empty();
        // document.getElementById('engine_more').style.display = "none";
        $('.dropdown-content.manufacturer_content').toggle();
        var manufacturer_id = $(this).data('manufacturer_id');
        document.getElementById('manufacturer_id').value = manufacturer_id;
        manufacturer_id_set = manufacturer_id;

        let engine_sub_type = $('#subLinkageTarget :selected').val();
        let url = "{{ route('get_models_by_manufacturer') }}";
        $('.dropdown-header.manufacturer').html($(this).html());
        $.get(url + '?manufacturer_id=' + manufacturer_id + '&engine_sub_type=' + engine_sub_type + "&main=1", function(
            data) {

            let response = data.data;
            if (data.load_more_model_value > data.total_count) {
                document.getElementById('model_more').style.display = "none";
            } else {
                document.getElementById('model_more').style.display = "block";
            }

            if (response.length > 0) {
                $.each(response, function(key, value) {

                    model_id_check_array.push(value.modelId);
                    $('.model_normal_option').append($(
                        '<div class="model_option" data-model_id="' +
                        value.modelId + '">').html(value.modelname));
                });
            } else {
                $('.model_normal_option').append(
                    "<span style='color:red;text-align:center;font-size:13px;'>No Record Found</span>"
                );
            }

        })
    })

    $('.dropdown-header.model').click(function(event) {
        $('.dropdown-content.model_content').toggle();
        event.stopPropagation();
    })

    $('.more.model_more').click(function(event) {
        document.getElementById('model_load_icon').style.display = "block";
        var manufacturer_id = manufacturer_id_set;
        let engine_sub_type = $('#subLinkageTarget :selected').val();
        let url = "{{ route('get_models_by_manufacturer') }}";

        $.get(url + '?manufacturer_id=' + manufacturer_id + '&engine_sub_type=' + engine_sub_type + '&load=1',
            function(data) {
                document.getElementById('model_load_icon').style.display = "none";
                let response = data.data;
                if (data.load_more_model_value > data.total_count) {
                    document.getElementById('model_more').style.display = "none";
                } else {
                    document.getElementById('model_more').style.display = "block";
                }

                if (response.length > 0) {
                    $.each(response, function(key, value) {

                        model_id_check_array.push(value.modelId);
                        $('.model_normal_option').append($(
                            '<div class="model_option" data-model_id="' +
                            value.modelId + '">').html(value.modelname));
                    });
                } else {
                    $('.model_normal_option').append(
                        "<span style='color:red;text-align:center;font-size:13px;'>No Record Found</span>"
                    );
                }
            })
        event.stopPropagation();
    })
    ////// get engines==================
    var engine_id_check_array = [];
    $('.dropdown-header.engine').click(function(event) {
        $('.dropdown-content.engine_content').toggle();
        event.stopPropagation();
    })
    $(document.body).on('click', '.model_option:not(.model_more)', function(
        event) { // click on brand to get sections
        $('.dropdown-header.model').html($(this).html());
        
        var model_id = $(this).data('model_id');
        document.getElementById('model_id').value = model_id;
        model_id_set = model_id;
        let url = "{{ route('get_engines_by_model') }}";
        let engine_sub_type = $('#subLinkageTarget :selected').val();
        $('.dropdown-content.model_content').toggle();
        $('.engine_normal_option').empty();
        $.get(url + '?model_id=' + model_id + '&engine_sub_type=' + engine_sub_type + "&main=1",
            function(data) {
                let response = data.data;

                document.getElementById('engine_load_icon').style.display = "none";
                if (data.load_more_engine_value > data.total_count) {
                    document.getElementById('engine_more').style.display = "none";
                } else {
                    document.getElementById('engine_more').style.display = "block";
                }
                if (response.length > 0) {
                    $.each(response, function(key, value) {
                        engine_id_check_array.push(value.linkageTargetId);
                        $('.engine_normal_option').append($(
                            '<div class="engine_option" data-engine_id="' +
                            value.linkageTargetId + '">').html(value.description + "(" +
                            value
                            .beginYearMonth + " - " + value.endYearMonth));
                    });
                } else {
                    $('.engine_normal_option').append(
                        "<span style='color:red;text-align:center;font-size:13px'>No Record Found</span>"
                    );
                }

            })

    })
    $('.more.engine_more').click(function(event) {
        document.getElementById('engine_load_icon').style.display = "block";
        var model_id = model_id_set;
        let url = "{{ route('get_engines_by_model') }}";
        let engine_sub_type = $('#subLinkageTarget :selected').val();
        
        $.get(url + '?model_id=' + model_id + '&engine_sub_type=' + engine_sub_type + "&load=1",
            function(data) {
                let response = data.data;

                document.getElementById('engine_load_icon').style.display = "none";
                if (data.load_more_engine_value > data.total_count) {
                    document.getElementById('engine_more').style.display = "none";
                } else {
                    document.getElementById('engine_more').style.display = "block";
                }
                    $.each(response, function(key, value) {
                        if(!engine_id_check_array.includes(value.linkageTargetId)){
                            engine_id_check_array.push(value.linkageTargetId)
                            $('.engine_normal_option').append($(
                            '<div class="engine_option" data-engine_id="' +
                            value.linkageTargetId + '">').html(value.description + "(" +
                            value
                            .beginYearMonth + " - " + value.endYearMonth));
                        }
                        
                    });
                

            })
    });
             
   
    ///// get sections==================
    var engine_id_set = 0;
    $('.dropdown-header.section').click(function(event) {
        $('.dropdown-content.section_content').toggle();
        event.stopPropagation();
    })
    $(document.body).on('click', '.engine_option:not(.engine_more)', function(
        event) { // click on brand to get sections
        $('.dropdown-header.engine').html($(this).html());
        
        var engine_id = $(this).data('engine_id');
        document.getElementById('engine_id').value = engine_id;
        engine_id_set = engine_id;
        let url = "{{ route('get_sections_by_engine') }}";
        let engine_sub_type = $('#subLinkageTarget :selected').val();
        $('.dropdown-content.engine_content').toggle();
        $('.section_normal_option').empty();
        $.get(url + '?engine_id=' + engine_id + '&engine_sub_type=' + engine_sub_type + "&main=1",
            function(data) {
                let response = data.data;

                document.getElementById('section_load_icon').style.display = "none";
                if (data.load_more_section_value > data.total_count) {
                    document.getElementById('section_more').style.display = "none";
                } else {
                    document.getElementById('section_more').style.display = "block";
                }
                if (response.length > 0) {
                    $.each(response, function(key, value) {
                        // engine_id_check_array.push(value.linkageTargetId);
                        $('.section_normal_option').append($(
                            '<div class="section_option" data-section_id="' +
                            value.assemblyGroupNodeId + '">').html(value.assemblyGroupName));
                    });
                } else {
                    $('.section_normal_option').append(
                        "<span style='color:red;text-align:center;font-size:13px'>No Record Found</span>"
                    );
                }

            })

    })

    $('.more.section_more').click(function(event) { // click on brand to get sections
        
        var engine_id = engine_id_set;
        document.getElementById('section_load_icon').style.display = "block";
        let url = "{{ route('get_sections_by_engine') }}";
        let engine_sub_type = $('#subLinkageTarget :selected').val();
        $('.dropdown-content.engine_content').toggle();
        $.get(url + '?engine_id=' + engine_id + '&engine_sub_type=' + engine_sub_type + "&load=1",
            function(data) {
                let response = data.data;

                document.getElementById('section_load_icon').style.display = "none";
                if (data.load_more_section_value > data.total_count) {
                    document.getElementById('section_more').style.display = "none";
                } else {
                    document.getElementById('section_more').style.display = "block";
                }
                    $.each(response, function(key, value) {
                        // engine_id_check_array.push(value.linkageTargetId);
                        $('.section_normal_option').append($(
                            '<div class="section_option" data-section_id="' +
                            value.assemblyGroupNodeId + '">').html(value.assemblyGroupName));
                    });
                

            })

    })
  
    

    ///// get section parts============

    var section_id_set = 0;
    $('.dropdown-header.section_part').click(function(event) {
        $('.dropdown-content.section_part').toggle();
        event.stopPropagation();
    })

    $(document.body).on('click', '.section_option:not(.section_more)', function(
        event) { // click on brand to get sections
        $('.dropdown-header.section').html($(this).html());
        
        var section_id = $(this).data('section_id');
        document.getElementById('section_id').value = section_id;
        section_id_set = section_id;
        let url = "{{ route('get_section_parts') }}";
        let engine_sub_type = $('#subLinkageTarget :selected').val();

        $('.dropdown-content.section_content').toggle();
        $('.engine_normal_option').empty();
        $.get(url + '?section_id=' + section_id + '&engine_sub_type=' + engine_sub_type + "&main=1",
            function(data) {
                let response = data.data;

                document.getElementById('section_part_load_icon').style.display = "none";
                if (data.load_more_section_part_value > data.total_count) {
                    document.getElementById('section_part_more').style.display = "none";
                } else {
                    document.getElementById('section_part_more').style.display = "block";
                }
                $('.section_part_normal_option').empty();
                if (response.length > 0) {

                    $.each(response, function(key, value) {
                        // engine_id_check_array.push(value.linkageTargetId);
                        $('.section_part_normal_option').append($(
                            '<div class="section_part_option" data-section_part_id="' +
                            value.dataSupplierId+ "-" + value.legacyArticleId + '">').html(value.genericArticleDescription+ "-" +value.articleNumber));
                    });
                } else {
                    $('.section_part_normal_option').append(
                        "<span style='color:red;text-align:center;font-size:13px'>No Record Found</span>"
                    );
                }

            })

    })
    
    $('.more.section_part_more').click(function(event) { // click on brand to get sections
        
        var section_id = section_id_set;
        document.getElementById('section_part_load_icon').style.display = "block";
        let url = "{{ route('get_section_parts') }}";
        let engine_sub_type = $('#subLinkageTarget :selected').val();
        $.get(url + '?section_id=' + section_id + '&engine_sub_type=' + engine_sub_type + "&load=1",
            function(data) {
                let response = data.data;

                document.getElementById('section_part_load_icon').style.display = "none";
                if (data.load_more_section_part_value > data.total_count) {
                    document.getElementById('section_part_more').style.display = "none";
                } else {
                    document.getElementById('section_part_more').style.display = "block";
                }

                    $.each(response, function(key, value) {
                        // engine_id_check_array.push(value.linkageTargetId);
                        $('.section_part_normal_option').append($(
                            '<div class="section_part_option" data-section_part_id="' +
                            value.dataSupplierId+ "-" + value.legacyArticleId + '">').html(value.genericArticleDescription+ "-" +value.articleNumber));
                    });
                
                

            })

    })
    

    ///// get brands by section parts======
    
    var section_part_id_set = 0;
    $('.dropdown-header.brand').click(function(event) {
        $('.dropdown-content.brand').toggle();
        event.stopPropagation();
    })

    $(document.body).on('click', '.section_part_option:not(.section_part_more)', function(
        event) { // click on brand to get sections
        $('.dropdown-header.section_part').html($(this).html());
        
        var section_part_id = $(this).data('section_part_id');
        document.getElementById('section_part_id').value = section_part_id;
        section_part_id_set = section_part_id;
        let url = "{{ route('get_brands_by_section_part') }}";

        $('.dropdown-content.section_part').toggle();
        $('.brand_normal_option').empty();
        $.get(url + '?section_part_id=' + section_part_id + "&main=1",
            function(data) {
                let response = data.data;
                $('.brand_normal_option').empty();
                console.log(response)
                console.log(response.length)
                if (response) {
                        $('.brand_normal_option').append($(
                            '<div class="brand_option" data-brand_id="' +
                            response.brandId + '">').html(response.brandName));
                } else {
                    $('.brand_normal_option').append(
                        "<span style='color:red;text-align:center;font-size:13px'>No Record Found</span>"
                    );
                }

            })

    })
    

    $(document.body).on('click', '.brand_option:not(.brands_more)', function(
        event) { // click on brand 
            $('.dropdown-header.brand').html($(this).html());
            $('.dropdown-content.brand').toggle();
        var brand_id = $(this).data('brand_id');
        document.getElementById('brand_id').value = brand_id;
        });
    

    $("#product_purchase_date").on('change', function() {
        var selectedDate = this.value;
        var currentDate = new Date();
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = dd + '-' + mm + '-' + yyyy;
        if (selectedDate > today) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select the current date! currently you are not be able to add the purchase on future date',
            });
            $('#product_purchase_date').val('');
            exit();
        }
    });

    var supplier_ids_array = [],
        article_ids_array = [],
        selected_cash_type = [],
        all_product_ids = [];
    var total_quantity = $('#total-quantity');
    var total_amount = $('#total-amount');
    $("#save-btn").click(function() {
        var id = $('#section_part_id').val();
        var engine_type = $('#linkageTarget').find(":selected").val();
        var engine_sub_type = $('#subLinkageTarget').find(":selected").val();
        var manufacturer_id = $('#manufacturer_id').val();
        var model_id = $('#model_id').val();
        var engine_id = $('#engine_id').val();
        var section_id = $('#section_id').val();
        var section_part_id = $('#section_part_id').val();
        var supplier_id = $('#supplier_id').find(":selected").val();
        var status = $('#status').find(":selected").val();
        var date = $('#product_purchase_date').val();
        var cashType = $('#cash_type').find(":selected").val();
        var brandId = $('#brand_id').val();
        if (!engine_type) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select an Engine Type',

            });
            exit();
        }
        if (!engine_sub_type) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select an Engine Type',
            });
            exit();
        }
        if (!manufacturer_id) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a manufacturer',

            });
            exit();
        }
        if (!model_id) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a Model',

            });
            exit();
        }
        if (!engine_id) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select an engine',

            });
            exit();
        }
        if (!section_id) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a section',

            });
            exit();
        }
        if (!section_part_id) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a section part',

            });
            exit();
        }
        if (!status) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a status',

            });
            exit();
        }
        if (!date) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a date',

            });
            exit();
        }
        if (!cashType) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select Cash Type',

            });
            exit();
        }
        $.ajax({
            method: "GET",
            url: "{{ url('show_section_parts_in_table') }}",
            data: {
                id: id,
                engine_type: engine_type,
                engine_sub_type: engine_sub_type,
                manufacturer_id: manufacturer_id,
                model_id: model_id,
                engine_id: engine_id,
                section_id: section_id,
                section_part_id: section_part_id,
                supplier_id: supplier_id,
                brand_id: brandId,
                status: status,
                date: date,
                cash_type: cashType
            },
            success: function(data) {
                if (data.brand_id == null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select Supplier (Brand)',
                    });
                    exit();
                }
                $('#submit-button').css("display", "block");
                $('#order-table-header').text(`{{ trans('file.Order Table') }} *`);
                var tableBody = $("table tbody");
                var tableHead = $("table thead");
                var tableHeadRow = $("table thead tr");
                var other_data_div = $('#other_data');
                var total_calculations = $('#total_calculations');

                var white_cash_head = "";
                var black_cash_head = "";
                var white_cash_calculations_head = "";
                var black_cash_calculations_head = "";
                white_cash_calculations_head += `
                       <div class="col-md-12">
                            <div class="row total-calculations"> 
                                <div class="col-md-3">
                                   <h5>Total Exculding VAT</h5>    
                                </div>
                                <div class="col-md-3">
                                   <div class="input-group mb-3">     
                                        <input type="number" name="entire_total_exculding_vat" value="0" class="form-control"
                                            aria-label="Amount (to the nearest dollar)" id="entire_total_exculding_vat"
                                            class="form-control" min="0" step="any" max="100000000" readonly>
                                        <span class="input-group-text"><b>TND</b></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="row total-calculations"> 
                                <div class="col-md-3">
                                   <h5>VAT <span style="font-size:10px;color:#98AFC7">(value)</span></h5>    
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">     
                                        <input type="number" name="entire_vat" value="0" class="form-control"
                                            aria-label="Amount (to the nearest dollar)" id="entire_vat" 
                                            class="form-control" min="0" step="any" max="100000000" readonly>
                                        <span class="input-group-text"><b>TND</b></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="row total-calculations"> 
                                <div class="col-md-3">
                                   <h5>Tax Stamp</h5>    
                                </div> 
                                <div class="col-md-3">
                                    <div class="input-group mb-3">     
                                        <input type="number" name="tax_stamp" value="0" class="form-control"
                                            aria-label="Amount (to the nearest dollar)" onkeyup="changeFlowTotalWithVAT()" id="tax_stamp" 
                                            class="form-control" min="0" step="any" max="100000000">
                                        <span class="input-group-text"><b>TND</b></span>
                                    </div>
                                        
                                </div>
                            </div> 
                            <div class="row total-calculations"> 
                                <div class="col-md-3">
                                   <h5>Total To Be Paid</h5>    
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">     
                                        <input type="number" name="total_to_be_paid" value="0" class="form-control"
                                            aria-label="Amount (to the nearest dollar)" id="total_to_be_paid"
                                            class="form-control" min="0" max="100000000" readonly>
                                        <span class="input-group-text"><b>TND</b></span>
                                    </div>
                                </div> 
                            </div>
                       </div>
                `;
                black_cash_calculations_head += `
                            <div class="row total-calculations"> 
                                <div class="col-md-3">
                                   <h5>Total To Be Paid</h5>    
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">     
                                        <input type="number" name="total_to_be_paid" value="0" class="form-control"
                                            aria-label="Amount (to the nearest dollar)" id="total_to_be_paid"
                                            class="form-control" min="0" max="100000000" readonly>
                                        <span class="input-group-text"><b>TND</b></span>
                                    </div> 
                                </div> 
                            </div>
                `;
                white_cash_head += `<tr id="">
                    <th>{{ trans('file.name') }}</th>
                    <th>{{ trans('file.Quantity') }}</th>
                    <th>{{ trans('file.Purchase Price') }}</th>
                    <th>{{ trans('file.Sale Price') }}</th>
                    <th>{{ trans('file.Discount') }} %</th>
                    <th>{{ trans('file.Additional Cost Without VAT') }}</th>
                    <th>{{ trans('file.Additional Cost With VAT') }}</th>
                    <th style="width:200px">{{ trans('file.VAT %') }}</th>
                    <th>{{ trans('file.Profit Margin') }} %</th>
                    <th>{{ trans('file.Total Excluding Vat') }}</th>
                    <th>{{ trans('file.Actual Cost Per Product') }}</th>
                    <th>Action</th> 
                </tr>`;
                black_cash_head += `<tr id="">
                    <th>{{ trans('file.name') }}</th>
                    <th>{{ trans('file.Quantity') }}</th>
                    <th>{{ trans('file.Purchase Price') }}</th>
                    <th>{{ trans('file.Sale Price') }}</th>
                    <th>{{ trans('file.Discount') }} %</th>
                    <th>{{ trans('file.Additional Cost Without VAT') }}</th>
                    <th>{{ trans('file.Profit Margin') }} %</th>
                    <th>{{ trans('file.Total Excluding Vat') }}</th>
                    <th>{{ trans('file.Actual Cost Per Product') }}</th>
                    <th>Action</th>
                </tr>`;

                var length = document.getElementById("myTable").rows.length;

                var html = '';
                html += '<input type="hidden" name="manufacturer_id[]" value="' + data
                    .manufacturer_id + '">';
                html += '<input type="hidden" name="linkage_target_type[]" value="' + data
                    .linkage_target_type + '">';
                html += '<input type="hidden" name="linkage_target_sub_type[]" value="' + data
                    .linkage_target_sub_type + '">';
                html += '<input type="hidden" name="modell_id[]" value="' + data.model_id + '">';
                html += '<input type="hidden" name="enginee_id[]" value="' + data.engine_id + '">';
                html += '<input type="hidden" name="sectionn_id[]" value="' + data.section_id +
                    '">';
                html += '<input type="hidden" name="sectionn_part_id[]" value="' + data
                    .section_part_id + '">';
                html += '<input type="hidden" name="statuss[]" value="' + data.status + '">';
                html += '<input type="hidden" name="datee[]" value="' + data.date + '">';
                html += '<input type="hidden" name="cash_type" value="' + data.cash_type + '">';
                html += '<input type="hidden" name="brand_id[]" value="' + data.brand_id + '">';

                if (selected_cash_type.length > 0) {
                    selected_cash_type.forEach(checkCashType);

                    function checkCashType(element, index, data) {
                        if (element != cashType) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'you can not able to change the cash type for a purchase once you selected',
                            });
                            exit();
                        }
                    }
                } else {
                    selected_cash_type.push(cashType);
                }
                calculateFlowEntireTotal(all_product_ids);
                if (data.cash_type == "white" && tableHeadRow.length <= 0) {
                    tableHead.append(white_cash_head);
                    total_calculations.html(white_cash_calculations_head);
                } else if (data.cash_type == "black" && tableHeadRow.length <= 0) {
                    tableHead.append(black_cash_head);
                    total_calculations.html(black_cash_calculations_head);
                }
                $('#total_calculations').css('display', 'block');
                markup = '<tr id="article_' + data.data.legacyArticleId + '"><td>' + data.data
                    .genericArticleDescription + '-' + data.data.articleNumber +
                    '</td>';
                markup +=
                    '<td><input type="number" style="width:100px" class="form-control" onkeyup="alterPurchaseQty(' +
                    data.data.legacyArticleId + ')" id="item_qty' + data.data.legacyArticleId +
                    '" value="1" min="1" name="item_qty[]" required></td>';
                markup +=
                    '<td><input style="width:150px" type="number" class="form-control" onkeyup="alterPurchaseQty(' +
                    data.data.legacyArticleId +
                    ')" value="1" min="1" step="any" id="purchase_price_' +
                    data.data.legacyArticleId +
                    '" name="purchase_price[]" required></td>';
                markup +=
                    '<td><input style="width:150px" type="number" class="form-control"  id="sale_price_' +
                    data.data.legacyArticleId +
                    '" name="sale_price[]" readonly></td>';
                markup +=
                    '<td><input type="number" class="form-control" value="0" min="0" max="100" onkeyup="checkFlowDiscount()" id="discount_' +
                    data.data.legacyArticleId +
                    '" name="discount[]"></td>';
                markup +=
                    '<td><input type="number" class="form-control" value="0" min="0"  onkeyup="alterPurchaseQty(' +
                    data.data.legacyArticleId + ')" id="additional_cost_without_vat_' + data.data
                    .legacyArticleId +
                    '" name="additional_cost_without_vat[]"></td>';
                if (data.cash_type == "white") {
                    markup +=
                        '<td><input type="number" class="form-control" value="0" min="0" step="any" onkeyup="changeFlowTotalWithVAT()" id="additional_cost_with_vat_' +
                        data.data.legacyArticleId +
                        '" name="additional_cost_with_vat[]"></td>';
                }
                if (data.cash_type == "white") {
                    markup +=
                        '<td><input style="width:100px" type="number" onkeyup="changeFlowTotalWithVAT()" class="form-control" max="100" value="0" min="0" id="vat_' +
                        data.data.legacyArticleId +
                        '" name="vat[]" required></td>';
                }
                markup +=
                    '<td><input type="number" style="width:100px" class="form-control" value="0" min="0"  onkeyup="alterPurchaseQty(' +
                    data.data.legacyArticleId + ')" id="profit_margin_' + data.data
                    .legacyArticleId +
                    '" name="profit_margin[]" required></td>';
                markup +=
                    '<td><input style="width:100px" type="number" class="form-control" value="0" min="0"   id="total_excluding_vat_' +
                    data.data.legacyArticleId +
                    '" name="total_excluding_vat[]" readonly></td>';
                markup +=
                    '<td><input type="text" style="width:150px" class="form-control" value="0" min="0"   id="actual_cost_per_product_' +
                    data.data.legacyArticleId +
                    '" name="actual_cost_per_product[]" readonly></td>';
                markup += '<td><button type="button" class="btn btn-danger" id="article_delete_' +
                    data.data.legacyArticleId + '" onclick="deleteFlowArticle(' + data.data
                    .legacyArticleId +
                    ')"><i class="fa fa-trash"></i></button></td>';
                markup += '<td style="display:none;">' + html +
                    '</td></tr>';
                if (length <= 1) {
                    tableBody.append(markup);
                    $('#myTable tr').each(function() {
                        if (this.id != '') {
                            article_ids_array.push(this.id)
                        }
                    });
                } else {
                    if (!article_ids_array.includes("article_" + data.data.legacyArticleId)) {
                        tableBody.append(markup);

                        article_ids_array.push("article_" + data.data.legacyArticleId)


                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'This product is already added...you can update its quantity',
                        })
                    }
                }
                if ($('#myTable tr').length <= 1) {
                    selected_cash_type = [];
                }
                all_product_ids.push(data.data.legacyArticleId);
                alterPurchaseQty(data.data.legacyArticleId);
                calculateSalePrice();
            }
        });
    });

    var t_qty = 0; // why let qn nhi ?? 
    let w_qty = 0; // let why ?? var qn nhi ??
    let b_qty = 0;
    var id_array = [];
    var total_quantity_of_all_row_products = 0;

    function alterPurchaseQty(id) {
        var error = 0;
        item_qty = parseInt($("#item_qty" + id).val());
        var purchasePrice = parseFloat($("#purchase_price_" + id).val());
        var additional_cost_without_vat = parseFloat($("#additional_cost_without_vat_" + id).val());
        if (additional_cost_without_vat == null || isNaN(additional_cost_without_vat)) {
            additional_cost_without_vat = 0;
        }
        var purchase_additional_cost = $('#purchase_additional_cost').val();
        if (purchase_additional_cost == null || isNaN(purchase_additional_cost)) {
            purchase_additional_cost = 0;
        }
        var entireAditionalCost = purchase_additional_cost;
        var cashType = $('#cash_type').find(":selected").val();
        var total_actual = 0.0;
        var total_cost_without_vat = (purchasePrice * item_qty) + additional_cost_without_vat;
        $("#total_excluding_vat_" + id).val(total_cost_without_vat.toFixed(2));
        if (all_product_ids.length > 0) {
            all_product_ids.forEach(getActualProductCost);

            function getActualProductCost(idd, index) {
                total_actual += parseFloat($('#actual_cost_per_product_' + idd).val());
                total_quantity_of_all_row_products += parseInt($("#item_qty" + idd).val());
            }
            var actual_cost_per_product = (total_cost_without_vat / item_qty) + (entireAditionalCost /
                total_quantity_of_all_row_products);
        }
        $('#actual_cost_per_product_' + id).val(actual_cost_per_product.toFixed(2));
        var profit_margin = $('#profit_margin_' + id).val()
        if (profit_margin % 1 != 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Profit Margin must be Type of Integer',

            });
            $('#profit_margin_' + id).val(0)
            error = 1;
        }
        if (profit_margin > 100) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Profit Margin must be less or equal to 100',
            });
            $('#profit_margin_' + id).val(0)
            error = 1;
        }
        profit_margin = parseFloat($('#profit_margin_' + id).val() / 100);
        if (error == 0) {
            if (profit_margin == null || profit_margin == NaN) {
                profit_margin = 0;
            }
            var sale_price_per_product = actual_cost_per_product * (1 + profit_margin);
            sale_price_per_product = parseFloat(sale_price_per_product);
            $('#sale_price_' + id).val(sale_price_per_product.toFixed(2));
            calculateFlowEntireTotal(all_product_ids);

        }
        total_quantity_of_all_row_products = 0;
    }

    function calculatePurchasePrice() {
        if (all_product_ids.length > 0) {
            var total_quantity = 0;
            all_product_ids.forEach(getAllQuantity);

            function getAllQuantity(id, index) {
                var i_qty = parseInt($("#item_qty" + id).val());
                total_quantity += i_qty;
            }
            all_product_ids.forEach(getSalePrice);
            var actual_total = 0.0;

            function getSalePrice(id, index) {
                item_qty = parseInt($("#item_qty" + id).val());
                var purchasePrice = parseFloat($("#purchase_price_" + id).val());
                var additional_cost_without_vat = parseFloat($("#additional_cost_without_vat_" + id).val());
                var purchase_additional_cost = $('#purchase_additional_cost').val();
                if (purchase_additional_cost == null || isNaN(purchase_additional_cost)) {
                    purchase_additional_cost = 0;
                }
                var entireAditionalCost = purchase_additional_cost;
                if (additional_cost_without_vat == null || additional_cost_without_vat == NaN) {
                    additional_cost_without_vat = 0;
                }
                var total_cost_without_vat = (purchasePrice * item_qty) + additional_cost_without_vat;
                $("#total_excluding_vat_" + id).val(total_cost_without_vat.toFixed(2));
                total_quantity_of_all_row_products += parseInt($("#item_qty" + id).val());
                var actual_cost_per_product = (total_cost_without_vat / item_qty) + (entireAditionalCost /
                    total_quantity);
                $('#actual_cost_per_product_' + id).val(actual_cost_per_product.toFixed(2));
                actual_total += actual_cost_per_product.toFixed(2);
                var profit_margin = $('#profit_margin_' + id).val()
                if (profit_margin % 1 != 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Profit Margin must be Type of Integer',

                    });
                    $('#profit_margin_' + id).val(0)
                    exit();
                }
                if (profit_margin > 100) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Profit Margin must be less or equal to 100',
                    });
                    $('#profit_margin_' + id).val(0)
                    exit();
                }
                profit_margin = $('#profit_margin_' + id).val() / 100;
                if (profit_margin == null || profit_margin == NaN) {
                    profit_margin = 0.0;
                }
                var sale_price_per_product = actual_cost_per_product * (1 + parseFloat(profit_margin));
                sale_price_per_product = parseFloat(sale_price_per_product);
                $('#sale_price_' + id).val(sale_price_per_product.toFixed(2));
            }
            calculateFlowEntireTotal(all_product_ids);
            total_quantity_of_all_row_products = 0;
        }
    }

    function deleteFlowArticle(id) {
        $('#article_' + id).remove();
        for (var i = 0; i < all_product_ids.length; i++) {
            if (all_product_ids[i] === id) {
                all_product_ids.splice(i, 1);
            }
        }
        for (var i = 0; i < article_ids_array.length; i++) {
            if (article_ids_array[i] === "article_" + id) {
                article_ids_array.splice(i, 1);
            }
        }
        console.log(article_ids_array)
        if (all_product_ids.length <= 0) {
            $('#total_calculations').css('display', 'none');
            $('#submit-button').css('display', 'none');
            $("table thead").empty();
        }
        calculateSalePrice();
        calculateFlowEntireTotal(all_product_ids);
        if ($('#myTable tr').length == 0) {
            selected_cash_type = [];
        }
    }

    function changeFlowTotalWithVAT() {
        var total_vat = 0;
        var total_actual = 0;
        var cashType = $('#cash_type').find(":selected").val();
        var id_array = [];
        id_array = all_product_ids.filter(onlyUnique);
        if (id_array.length > 0) {
            id_array.forEach(getActualProductCost);

            function getActualProductCost(id, index) {
                var error = 0;
                if (cashType == "white") {
                    var vat = $('#vat_' + id).val();
                    if (vat % 1 != 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'VAT must be Type of Integer',

                        });
                        $('#vat_' + id).val(0)
                        error = 1;
                    }
                    if (vat > 100) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'VAT must be less or equal to 100',
                        });
                        $('#vat_' + id).val(0)
                        error = 1;
                    }
                    if (vat == null || isNaN(vat)) {
                        $('#vat_' + id).val(0);
                        vat = 0;
                    }
                    var add_cost_with_vat = $('#additional_cost_with_vat_' + id).val();
                    if (add_cost_with_vat == null || isNaN(add_cost_with_vat)) {
                        $('#additional_cost_with_vat_' + id).val(0);
                        add_cost_with_vat = 0;
                    }
                    if (error == 0) {
                        total_vat = total_vat + parseFloat(vat / 100) + parseFloat(add_cost_with_vat);
                    }

                }
            }
            var purchase_additional_cost = $('#purchase_additional_cost').val();
            if (purchase_additional_cost == null || isNaN(purchase_additional_cost)) {
                purchase_additional_cost = 0;
            }
            total_vat = total_vat + parseFloat(purchase_additional_cost);
            if (total_vat == null || isNaN(total_vat)) {
                total_vat = 0;
            }
            $('#entire_vat').val(total_vat.toFixed(2));
            var entire_vat = parseFloat($('#entire_vat').val());
            var tax_stamp = parseFloat($('#tax_stamp').val());
            var tot_to_be_paid = $('#total_to_be_paid').val();
            var entire_total_exculding_vat = $('#entire_total_exculding_vat').val();
            if (tax_stamp == null || isNaN(tax_stamp)) {
                tax_stamp = 0.0;
            }
            var total_to_be_paid = parseFloat(entire_total_exculding_vat) + parseFloat(entire_vat.toFixed(2)) +
                parseFloat(tax_stamp.toFixed(
                    2));
            $('#total_to_be_paid').val(total_to_be_paid.toFixed(2));
        }
    }

    function calculateFlowEntireTotal(product_ids_array) {
        var total_actual = 0.0;
        var total_vat = 0.0;
        var total_to_be_paid = 0.0;
        var cashType = $('#cash_type').find(":selected").val();
        var id_array = [];
        id_array = product_ids_array.filter(onlyUnique);
        if (id_array.length > 0) {
            id_array.forEach(getActualProductCost);

            function getActualProductCost(id, index) {
                var qty = parseInt($("#item_qty" + id).val());
                if (qty > 0) {
                    total_actual += parseFloat($('#total_excluding_vat_' + id).val());
                    if (cashType == "white") {
                        var vat = $('#vat_' + id).val();
                        if (vat == null || vat == NaN) {
                            $('#vat_' + id).val(0);
                            vat = 0;
                        }
                        var add_cost_with_vat = $('#additional_cost_with_vat_' + id).val();
                        if (add_cost_with_vat == null || add_cost_with_vat == NaN) {
                            add_cost_with_vat = 0;
                            $('#additional_cost_with_vat_' + id).val(0)
                        }
                        total_vat = total_vat + parseFloat(vat / 100) + parseFloat(add_cost_with_vat);
                    }
                }
            }
            var purchase_additional_cost = $('#purchase_additional_cost').val();
            if (!purchase_additional_cost) {
                purchase_additional_cost = 0;
            }
            total_vat = total_vat + parseFloat(purchase_additional_cost);
            $('#entire_total_exculding_vat').val(total_actual.toFixed(2));
            $('#entire_vat').val(total_vat.toFixed(2));
            var tax_stamp = parseFloat($('#tax_stamp').val());
            if (tax_stamp == null || tax_stamp == NaN) {
                tax_stamp = 0;
            }
            total_to_be_paid = parseFloat(total_actual.toFixed(2)) + parseFloat(total_vat.toFixed(2)) + parseFloat(
                tax_stamp.toFixed(2));
            if (cashType == "white") {
                $('#total_to_be_paid').val(total_to_be_paid.toFixed(2));
            } else if (cashType == "black") {
                $('#total_to_be_paid').val(total_actual.toFixed(2));
            }
        }
    }



    function checkFlowDiscount() {
        var id_array = [];
        id_array = all_product_ids.filter(onlyUnique);
        if (id_array.length > 0) {
            id_array.forEach(checkDiscount);

            function checkDiscount(id, index) {
                var discount = $('#discount_' + id).val();
                if (discount % 1 != 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'discount must be Type of Integer',

                    });
                    $('#discount_' + id).val(0)
                    exit();
                }
                if (discount > 100) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Discount must be less or equal to 100',
                    });
                    $('#discount_' + id).val(0)
                    exit();
                }
            }
        }
    }

    function onlyUnique(value, index, self) {
        return self.indexOf(value) === index;
    }
</script>
