var main_url = document.getElementById('app_url').value;

var model_id_check_array = [];
        $('.dropdown-header.model').click(function(event) {
            $('.dropdown-content.model_content').toggle();
            $('.dropdown-content.manufacturer_content').css('display','none');
            // $('.dropdown-content.model_content').css('display','none');
            $('.dropdown-content.engine_content').css('display','none');
            $('.dropdown-content.brands_content').css('display','none');
            $('.dropdown-content.product_group_content').css('display','none');
            if(document.getElementById('model_caret').style.transform == "rotate(180deg)"){
                document.getElementById('model_caret').style.transform = "rotate(0deg)";
            }else{
                document.getElementById('model_caret').style.transform = "rotate(180deg)";
            }
            event.stopPropagation();
        })
        var manufacturer_id_set = 0;
        $(document.body).on('click', '.manufacturer_option:not(.manufacturer_more)', function(
            event) { // click on brand to get sections
            model_id_check_array = [];
            $('.dropdown-header.model').html('Select Model <i id="model_caret" class="fa fa-solid fa-caret-down"></i>');
            $('.dropdown-header.engine').html('Select Engine <i id="engine_caret" class="fa fa-solid fa-caret-down"></i>');
            $('.model_normal_option').empty();
            $('.engine_normal_option').empty();
             document.getElementById('engine_more').style.display = "none";
            document.getElementById('model_more').style.display = "none";
             
            document.getElementById('model_input_search').value = "";
            document.getElementById('engine_input_search').value = "";
            $('#model_year').val('');
                $('#fuel').val('');
                $('#cc').val('');
               
            document.getElementById('model_searching').style.display = "block";

            $('.dropdown-content.manufacturer_content').toggle();
            var manufacturer_id = $(this).data('manufacturer_id');
            manufacturer_id_set = manufacturer_id;
            let engine_sub_type = $('input[name="sub_type"]:checked').val();
            let engine_type = $('input[name="type"]:checked').val();
            $('.dropdown-header.manufacturer').html($(this).html() + ' <i id="manufacturer_caret" class="fa fa-solid fa-caret-down"></i>');
            let url = '/get_models_by_manufacturer_home_search';
            $.get(url + '?manufacturer_id=' + manufacturer_id + '&engine_sub_type=' + engine_sub_type +
                '&engine_type=' + engine_type + '&main=1',
                function(data) {

                    let response = data.data;
            document.getElementById('model_searching').style.display = "none";
           

            document.getElementById('model_searching').style.display = "none";
                    if (data.load_more_model['value'] > data.total_count) {
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

        $('.more.model_more').click(function(event) {
          
          
           
            document.getElementById('model_load_icon').style.display = "block";
            var manufacturer_id = manufacturer_id_set;
            let engine_sub_type = $('input[name="sub_type"]:checked').val();
            let engine_type = $('input[name="type"]:checked').val();
            let url = '/get_models_by_manufacturer_home_search';

            $.get(url + '?manufacturer_id=' + manufacturer_id + '&engine_sub_type=' + engine_sub_type +
                '&engine_type=' +
                engine_type + '&load=1',
                function(data) {

                    let response = data.data;
                    document.getElementById('model_load_icon').style.display = "none";
                    if (data.load_more_model['value'] > data.total_count) {
                        document.getElementById('model_more').style.display = "none";
                    } else {
                        document.getElementById('model_more').style.display = "block";
                    }
                    var error = [];
                    $.each(response, function(key, value) {
                        if (!model_id_check_array.includes(value.modelId)) {
                            $('.model_normal_option').append($(
                                '<div class="model_option" data-model_id="' +
                                value.modelId + '">').html(value.modelname));
                            error.push('data');
                        }
                    });
                })
            event.stopPropagation();
        })



        function filterModel() {
            var input, filter, ul, li, a, i;
            input = document.getElementById("model_input_search").value;
            document.getElementById('model_searching').style.display = "block";
            document.getElementById('model_more').style.display = "none";
            $('.model_normal_option').empty();
        
            var sub_type = $('input[name="sub_type"]:checked').val();
            var type = $('input[name="type"]:checked').val();
        
        
            if(currentRequest != null){
                currentRequest.abort();
            }
        
            currentRequest = $.ajax({
                url: '/get_all_models_by_autocomplete',
                method: "GET",
                data: {
                    name: input,
                    engine_type:type,
                    engine_sub_type:sub_type,
                    manufacturer_id: manufacturer_id_set
                },
                success: function(data) {
        
                    if(data.autocomplete == 1){
                        $('.model_normal_option').empty();
                        document.getElementById('model_searching').style.display = "none";
                        if(data.models.length > 0){
                            $.each(data.models, function(key, value) {
                                $('.model_normal_option').append($(
                                    '<div class="model_option" data-model_id="' +
                                    value.modelId + '">').html(value.modelname));
                            });
                        }else{
                            $('.model_normal_option').append(
                                "<span style='color:red;text-align:center;font-size:13px'>No Record Found</span>"
                            );
                        }
                        
                    }else if(data.autocomplete == 0){
                        $('.model_normal_option').empty();
                        document.getElementById('model_searching').style.display = "none";
                        $.each(data.models, function(key, value) {
                            $('.model_normal_option').append($(
                                '<div class="model_option" data-model_id="' +
                                value.modelId + '">').html(value.modelname));
                        });
                        document.getElementById('model_more').style.display = "block";
                    }
                    
        
                    
        
        
                }

                
            });
        
        }
        function removeData()
                {
                    document.getElementById('manufacturer_caret').value="";
                  
                     
                }