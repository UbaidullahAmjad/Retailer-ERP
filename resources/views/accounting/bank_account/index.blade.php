@extends('layout.main')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> --}}

@section('content')
@if(session()->has('create_message'))
<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('create_message') }}</div>
@endif
@if(session()->has('edit_message'))
<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('edit_message') }}</div>
@endif
@if(session()->has('import_message'))
<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('import_message') }}</div>
@endif
@if(session()->has('not_permitted'))
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif


<section>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="">
                            <div class="d-flex flex-row-reverse mb-3 mr-4">
                                {{-- <a href="{{route('bank_account.create')}}" class="btn btn-info mb-1"><i class="dripicons-plus"></i> {{trans('file.Add Bank Account')}}</a> --}}
                                <div class="col pl-4 pt-1">
                                    <h2>{{trans('file.Bank Account')}}</h2>
                                </div>
                            </div>
                            <div class="    table-responsive">
                                @if(session()->has('message'))
                                <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
                                @endif
                                @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                                @endif
                                @if ($message = Session::get('error'))
                                <div class="alert alert-danger">
                                    <p>{{ $message }}</p>
                                </div>
                                @endif
                                <table id="data-table" class="table" style="width: 100% !important">
                                    <thead class="article_view_tr_head">
                                        <tr>
                                            <th>#</th>
                                            <th>Bank Title</th>
                                            <th>Account No.</th>
                                            <th>Account Title</th>
                                            <th>Swift Code</th>
                                            <th>IBAN</th>
                                            <th>Primary Balance</th>
                                            <th>Secondary Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        console.log('here');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var i = 1;

        $('#data-table').DataTable({
            "ordering" : false,
            "processing": true,
            "serverside": true,
            ajax: "{{ route('bank_account.index') }}",

            columns: [{
                    "data": "index",
                    name: 'index'
                },
                {
                    "data": "bank",
                    name: 'bank'
                },
                {
                    "data": "account_number",
                    name: 'account_number'
                },
                {
                    "data": "account_title",
                    name: 'account_title'
                },
                {
                    "data": "swift_code",
                    name: 'swift_code'
                },
                {
                    "data": "iban",
                    name: 'iban'
                },
                {
                    "data": "primary_balance",
                    name: 'primary_balance'
                },
                {
                    "data": "secondary_balance",
                    name: 'secondary_balance'
                },
                {
                    "data": 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });
    });
</script>


@endsection