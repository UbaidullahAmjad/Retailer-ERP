@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<section>
<div class="row allforms p-3">
            <div class="col-lg-6">
                <div class="pull-left">
                    <h2>Create New Form</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="pull-right">
                    <a class="btn btn-primary float-right" href="{{ route('form.index') }}"> Back</a>
                </div>
            </div>
        </div>
</div>

<div class="row pl-5 pr-5">
    <!-- <div class="col-lg-3"></div> -->
    <div class="col-lg-12">
        @if(Session::has('error'))
            <p class="bg-danger text-white p-2 rounded">{{Session::get('error')}}</p>
            @endif
            @if(Session::has('success'))
            <p class="bg-success text-white p-2 rounded">{{Session::get('success')}}</p>
            @endif
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif


<form action="{{ route('form.store') }}" method="post" enctype="multipart/form-data">
    @csrf
<div class="row card mt-2 p-2">
    <div class="col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            <select name="role" id="" class="form-control">
                <option value="10">Dealer</option>
                <option value="11">Refactor</option>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <strong>Form Name:</strong>
            <input type="text" name="name" class="form-control">
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <strong>Field Label:</strong>
                    <input type="text" name="field_label[]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <strong>Field Name:</strong>
                    <input type="text" name="field_name[]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <strong>Field Type:</strong>
                    <select name="field_type[]" id="" class="form-control" required>
                        <option value="1">Text</option>
                        <option value="2">Text Area</option>
                        <option value="3">File Upload</option>
                        <option value="4">Radio</option>
                        <option value="5">Password</option>
                        <option value="6">Email</option>

                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <button id="addRow" type="button" class="btn btn-success mt-2"><i class="fa fa-plus"></i> Add More</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12" id="newRow">
        
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <button type="submit" class="btn btn-primary">Add Form</button>
    </div>
</div>
</form>

    </div>
</div>
</div>
</div>


</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
    // add row
    $("#addRow").click(function () {
        var html = '';
        html += '<div class="row" id="inputFormRow">';
        html += '<div class="col-md-3"><div class="form-group"><strong>Field Label:</strong><input type="text" name="field_label[]" class="form-control" required></div></div>';
        html += '<div class="col-md-3"><div class="form-group"><strong>Field Name:</strong><input type="text" name="field_name[]" class="form-control" required></div></div>';
        html += '<div class="col-md-3"><div class="form-group"><strong>Field Type:</strong><select name="field_type[]" id="" class="form-control" required><option value="1">Text</option><option value="2">Text Area</option><option value="3">File Upload</option><option value="4">Radio</option><option value="5">Password</option><option value="6">Email</option></select></div></div>';
        // html += '<div class="col-md-4"><div class="form-group"><button id="addRow" class="btn btn-success mt-2"><i class="fa fa-plus"></i> Add More</button></div></div>';
        html += '<div class="col-md-3"><div class="form-group">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
        html += '</div>';
        html += '</div>';
        $('#newRow').append(html);
    });
    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });
</script>
</section>
@endsection

