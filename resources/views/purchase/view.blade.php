@extends('layout.main') @section('content')

    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center article_view_tr_head">
                            <h4><b>{{ trans('file.Purchase') }}</b></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for=""><b>Date</b></label>
                                    <p>{{ $purchase->date }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label for=""><b>Total Purchase Items</b></label>
                                    <p>{{ $purchase->item }}</p>
                                    
                                </div>
                                <div class="col-md-4">
                                    <label for=""><b>Total Purchase Items Quantity</b></label>
                                    <p>{{ $purchase->total_qty }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label for=""><b>Purchase Cash Type</b></label>
                                    <p>{{ ($purchase->cash_type == "white") ? "Primary" : "Secondary" }}</p>

                                </div>
                                <div class="col-md-4">
                                    <label for=""><b>Grand Total</b></label>
                                    <p>{{ $purchase->grand_total }} TND</p>
                                    
                                </div>
                                <div class="col-md-4">
                                    <label for=""><b>After Markit Supplier</b></label>
                                    @php $supplier = App\Models\AfterMarkitSupplier::where('id', $purchase->supplier_id)->first(); @endphp
                                    <p>{{ isset($supplier) ? $supplier->name : '' }}</p>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex align-items-center article_view_tr_head">
                            <h4><b>{{ trans('file.Purchase Products') }}</b></h4>
                        </div>
                        <table class="table" id="purchase-table">
                            <thead class="article_view_tr_head">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Reference No</th>
                                    <th>Manufacturer</th>
                                    <th>Model</th>
                                    <th>Section</th>
                                    <th>Supplier <span>(Brand)</span></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase_products as $key => $product)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $product->date }}</td>
                                    <td>{{ $product->reference_no }}</td>
                                    <td>{{ $product->manufacturer }}</td>
                                    <td>{{ $product->model }}</td>
                                    <td>{{ $product->section }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#viewPurchaseProduct_{{ $product->id }}"><i class="fa fa-eye"></i></button></td>
                                    <!-- Modal -->
                                    <div class="modal fade" id="viewPurchaseProduct_{{ $product->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header article_view_tr_head">
                                                        <h3 class="text-center">Product Detail  ({{ $product->section_part }} <span>Article Number</span>)</h3>
                                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true" style="color: cyan">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="" class="view-edit-purchase">Purchase
                                                                Status</label>
                                                            <p>{{ $product->status }}</p>
                                                            
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="" class="view-edit-purchase">Total
                                                                Quantity</label>
                                                            <p>{{ $product->qty }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="" class="view-edit-purchase">Actual Cost Per Product</label>
                                                            <p> {{  $product->actual_cost_per_product }} TND </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="" class="view-edit-purchase">Total Cost (excluding VAT)</label>
                                                            
                                                                <p> {{  $product->total_excluding_vat }} TND </p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="" class="view-edit-purchase">Purchase
                                                                Price</label>
                                                           
                                                                <p> {{  $product->actual_price }} TND </p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="" class="view-edit-purchase">Sale
                                                                Price</label>
                                                            
                                                                <p> {{  $product->sell_price }} TND </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="" class="view-edit-purchase">Engine
                                                                Details</label>
                                                            
                                                                <p> {{  $product->engine_details }} </p>
                                                        </div>

                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                @endforeach

                            </tbody>

                        </table>
                        <div class="row">
                            <div class="col-md-3 button-padding">
                                <a href="{{ route('purchases.index') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
@push('scripts')
<script>
    $('#purchase-table').DataTable( {
        "processing": true,
        "searching" : true,
    });
</script>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
@endpush
