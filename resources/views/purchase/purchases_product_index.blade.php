@extends('layout.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

@endsection

@section('style')
@endsection
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}




@section('breadcrumb-title')
    <h3>Purchases list</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Purchases list</li>
@endsection

@section('content')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> --}}
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <div class="container-fluid">
        <div class="row">
            <!-- Individual column searching (text inputs) Starts-->

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Purchases</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row-reverse mb-3">
                            <a class="p-1" href="{{ route('purchasesPdfDownload') }}"><button
                                    class="btn btn-primary"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                    Pdf</button></a>
                            <a class="p-1" href="{{ route('exportPurchases') }}"><button
                                    class="btn btn-warning">Export</button></a>
                            {{-- <a class="p-1" href="{{ route('purchases.create') }}"><button class="btn btn-success"><i
                                        class="fa fa-plus"></i> Add</button></a> --}}
                        </div>

                        <div class="product-table">
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

                            <table class="display" id="data-table">
                                <thead class="article_view_tr_head">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Supplier</th>
                                        <th>Items</th>
                                        <th>Total Quantity</th>
                                        <th>Purchase Status</th>
                                        <th>Cash Type</th>
                                        {{-- <th>Paid</th>
                                        <th>Due</th> --}}
                                        <th>Grand Total</th>
                                        <th width="150px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Individual column searching (text inputs) Ends-->
        </div>
    </div>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            console.log('here');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#data-table').DataTable({
                "order": [[ 1, "DESC" ]],
                // "scrollX": true,
                "overflow-x": "auto",
                "processing": true,
                "serverside": true,
                "paging": true,
                ajax: "{{ route('purchases.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        "data": "date",
                        name: 'date'
                    },
                    {
                        "data": "supplier",
                        name: 'supplier'
                    },
                    {
                        "data": "item",
                        name: 'item'
                    },
                    {
                        "data": "total_qty",
                        name: 'total_qty'
                    },
                    {
                        "data": "purchase_status",
                        name: 'purchase_status'
                    },
                    // {
                    //     "data": "paid_amount",
                    //     name: 'paid_amount'
                    // },
                    {
                        "data": "cash_type",
                        name: 'cash_type'
                    },
                    {
                        "data": "grand_total",
                        name: 'grand_total'
                    },
                    {
                        "data": 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],


            });

            table.ajax.reload(null, false);
            
        });
         //////// sweet alert ///////////
         async function   modified_delete(id)
      {
        console.log(id);
                // href="deletePurchase/' . $row['id'] . '"
                var form = $(this).closest("form");
                var name = $(this).data("name");
                const enteredText="purchase/delete";
                event.preventDefault();
        const { value: text } = await Swal.fire({
            icon:'warning',
                title: 'Are you sure ?',
                input: 'text',
               text:'you wont be able to revert this!',
                inputLabel: 'Entrer purchase/delete to delete the item',
                inputPlaceholder: 'Enter ',
                showCancelButton: true,
                closeOnCancel: true,
                cancelButtonColor: "#FF0000",
                cancelButtonText: 'Cancel',
                inputValidator: (text) => {
        if (text === enteredText ) 
        {
            Swal.fire(`item deleted`);
             $.ajax({
                                method: "GET",
                               url: "/deletePurchase/"+id,
                                data: {
                                    id:id
                                },
                                 success: function($data){
                                    location.reload();
                               }
                         });
        }
       
        else  return 'Type purchase/delete to Delete the item'
      }
              
                    })
           

    //         if (text === enteredText) {
    //         Swal.fire(`Entered text: ${text}`);
    //         $.ajax({
    //                             method: "GET",
    //                            url: "/deletePurchase/"+id,
    //                             data: {
    //                                id:id
    //                            },
    //                             success: function($data){
    //                                location.reload();
    //                             }
    //                         });
    //         }
    //         else {
               
    //             Swal.showValidationError(
    //             'please enter a refund amount.'
    //           );
    // }
  
               
              
                   
            };
         

        //  function deletePurchase(id) {
        //         console.log(id);
        //         // href="deletePurchase/' . $row['id'] . '"
        //         var form = $(this).closest("form");
        //         var name = $(this).data("name");
        //         event.preventDefault();
               
        //         Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then((willDelete) => {
        //                 if (willDelete.isConfirmed) {
        //                     $.ajax({
        //                        method: "GET",
        //                        url: "/deletePurchase/"+id,
        //                        data: {
        //                           id:id
        //                        },
        //                        success: function($data){
        //                           location.reload();
        //                        }
        //                     });
        //                 }
        //             });
                
        //     }
    </script>
@endsection
