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
                            <h3>Stock Item</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Reference No</label>
                                    <p>{{ isset($get_product->stock->reference_no) ? $get_product->stock->reference_no : 'N/A' }}</p>
                                    {{-- <input type="text" class="form-control view-edit-purchase-input" value="" readonly> --}}
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">White Items</label>
                                    <p>{{ isset($get_product->stock->white_items) ? $get_product->stock->white_items : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Balck Items</label>
                                    <p>{{ isset($get_product->stock->black_items) ? $get_product->stock->black_items : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Total Qunatity</label>
                                    <p>{{ (isset($get_product->stock->white_items) ? $get_product->stock->white_items : 0)  + (isset($get_product->stock->black_items) ? $get_product->stock->black_items : 0)}}</p>
                                </div>
                            </div> 
                            <div class="row">
                                 <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Unit Purchase Price Of White Cash</label>
                                    <p>{{ isset($get_product->stock->unit_purchase_price_of_white_cash) ? $get_product->stock->unit_purchase_price_of_white_cash : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Unit Sale Price Of White Cash</label>
                                    <p>{{ isset($get_product->stock->unit_sale_price_of_white_cash) ? $get_product->stock->unit_sale_price_of_white_cash : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Unit Purchase Price Of Black Cash</label>
                                    <p>{{ isset($get_product->stock->unit_purchase_price_of_black_cash) ? $get_product->stock->unit_purchase_price_of_black_cash : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Unit Sale Price Of Black Cash</label>
                                    <p>{{ isset($get_product->stock->unit_sale_price_of_black_cash) ? $get_product->stock->unit_sale_price_of_black_cash : 'N/A' }}</p>
                                </div>
                           
                                
                            </div> 
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Supplier Name <span> (Brand Name) </span></label>
                                    <p>{{ isset($get_product->brand->brandName) ? $get_product->brand->brandName : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Section Name</label>
                                    <p>{{ isset($get_product->section->assemblyGroupName) ? $get_product->section->assemblyGroupName : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Engine Sub Type</label>
                                    <p>{{ isset($get_product->section->linkageTarget->linkageTargetType) ? $get_product->section->linkageTarget->linkageTargetType : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Engine Description</label>
                                    <p>{{ isset($get_product->section->linkageTarget->description) ? $get_product->section->linkageTarget->description : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Manufatrer</label>
                                    <p>{{ isset($get_product->section->linkageTarget->mfrName) ? $get_product->section->linkageTarget->mfrName : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="view-edit-purchase">Vehicle Model Series Name</label>
                                    <p>{{ isset($get_product->section->linkageTarget->vehicleModelSeriesName) ? $get_product->section->linkageTarget->vehicleModelSeriesName : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3 text-right">
                                    <a href="{{ url('product/list') }}" class="btn btn-primary">Back</a>
                                </div>
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
