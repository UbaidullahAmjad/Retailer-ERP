<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\CustomerGroup;
use App\Supplier;
use App\Warehouse;
use App\Biller;
use App\Product;
use App\Unit;
use App\Tax;
use App\Quotation;
use App\Delivery;
use App\PosSetting;
use App\ProductQuotation;
use App\Product_Warehouse;
use App\ProductVariant;
use App\ProductBatch;
use App\Variant;
use DB;
use NumberToWords\NumberToWords;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PreInvoiceController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('quotes-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            
            if(Auth::user()->role_id > 2 && config('staff_access') == 'own')
                $lims_quotation_all = Quotation::with('customer', 'supplier', 'user')->orderBy('id', 'desc')->where('user_id', Auth::id())->where('payment_status','!=', 4)->get();
            else
                $lims_quotation_all = Quotation::with('customer', 'supplier', 'user')->orderBy('id', 'desc')->where('payment_status','!=', 4)->get();
            return view('preinvoice.index', compact('lims_quotation_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('quotes-edit')){
            $lims_customer_list = Customer::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_biller_list = Biller::where('is_active', true)->get();
            $lims_supplier_list = Supplier::where('is_active', true)->get();
            $lims_tax_list = Tax::where('is_active', true)->get();
            $lims_quotation_data = Quotation::find($id);
            $lims_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
            // dd($lims_quotation_data);
            return view('preinvoice.edit',compact('lims_customer_list', 'lims_warehouse_list', 'lims_biller_list', 'lims_tax_list', 'lims_quotation_data','lims_product_quotation_data', 'lims_supplier_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
    public function update(Request $request, $id)
    {
        $data = $request->except('document');
        //return dd($data);
        $document = $request->document;
        if($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($request->document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());

            $documentName = $document->getClientOriginalName();
            $document->move('public/quotation/documents', $documentName);
            $data['document'] = $documentName;
        }
        $lims_quotation_data = Quotation::find($id);
        $lims_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
        //update quotation table
        $lims_quotation_data->update($data);
        if($lims_quotation_data->quotation_status == 2){
            //collecting mail data
            $lims_customer_data = Customer::find($data['customer_id']);
            $mail_data['email'] = $lims_customer_data->email;
            $mail_data['reference_no'] = $lims_quotation_data->reference_no;
            $mail_data['total_qty'] = $data['total_qty'];
            $mail_data['total_price'] = $data['total_price'];
            $mail_data['order_tax'] = $data['order_tax'];
            $mail_data['order_tax_rate'] = $data['order_tax_rate'];
            $mail_data['order_discount'] = $data['order_discount'];
            $mail_data['shipping_cost'] = $data['shipping_cost'];
            $mail_data['grand_total'] = $data['grand_total'];
        }
        $product_id = $data['product_id'];
        $product_batch_id = $data['product_batch_id'];
        $product_variant_id = $data['product_variant_id'];
        $qty = $data['qty'];
        $sale_unit = $data['sale_unit'];
        $net_unit_price = $data['net_unit_price'];
        $discount = $data['discount'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];

        foreach ($lims_product_quotation_data as $key => $product_quotation_data) {
            $old_product_id[] = $product_quotation_data->product_id;
            $lims_product_data = Product::select('id')->find($product_quotation_data->product_id);
            if($product_quotation_data->variant_id) {
                $lims_product_variant_data = ProductVariant::select('id')->FindExactProduct($product_quotation_data->product_id, $product_quotation_data->variant_id)->first();
                $old_product_variant_id[] = $lims_product_variant_data->id;
                if(!in_array($lims_product_variant_data->id, $product_variant_id))
                    $product_quotation_data->delete();
            }
            else {
                $old_product_variant_id[] = null;
                if(!in_array($product_quotation_data->product_id, $product_id))
                    $product_quotation_data->delete();
            }
        }

        foreach ($product_id as $i => $pro_id) {
            if($sale_unit[$i] != 'n/a'){
                $lims_sale_unit_data = Unit::where('unit_name', $sale_unit[$i])->first();
                $sale_unit_id = $lims_sale_unit_data->id;
            }
            else
                $sale_unit_id = 0;
            $lims_product_data = Product::select('id', 'name', 'is_variant')->find($pro_id);
            if($sale_unit_id)
                $mail_data['unit'][$i] = $lims_sale_unit_data->unit_code;
            else
                $mail_data['unit'][$i] = '';
            $input['quotation_id'] = $id;
            $input['product_id'] = $pro_id;
            $input['product_batch_id'] = $product_batch_id[$i];
            $input['qty'] = $mail_data['qty'][$i] = $qty[$i];
            $input['sale_unit_id'] = $sale_unit_id;
            $input['net_unit_price'] = $net_unit_price[$i];
            $input['discount'] = $discount[$i];
            $input['tax_rate'] = $tax_rate[$i];
            $input['tax'] = $tax[$i];
            $input['total'] = $mail_data['total'][$i] = $total[$i];
            $flag = 1;
            if($lims_product_data->is_variant) {
                $lims_product_variant_data = ProductVariant::select('variant_id')->where('id', $product_variant_id[$i])->first();
                $input['variant_id'] = $lims_product_variant_data->variant_id;
                if(in_array($product_variant_id[$i], $old_product_variant_id)) {
                    ProductQuotation::where([
                        ['product_id', $pro_id],
                        ['variant_id', $input['variant_id']],
                        ['quotation_id', $id]
                    ])->update($input);
                }
                else {
                    ProductQuotation::create($input);
                }
                $variant_data = Variant::find($input['variant_id']);
                $mail_data['products'][$i] = $lims_product_data->name . ' [' . $variant_data->name . ']';
            }
            else {
                $input['variant_id'] = null;
                if(in_array($pro_id, $old_product_id)) {
                    ProductQuotation::where([
                        ['product_id', $pro_id],
                        ['quotation_id', $id]
                    ])->update($input);
                }
                else {
                    ProductQuotation::create($input);
                }
                $mail_data['products'][$i] = $lims_product_data->name;
            }
        }

        $message = 'Pre Invoice updated successfully';

        if($lims_quotation_data->quotation_status == 2 && $mail_data['email']){
            try{
                Mail::send( 'mail.quotation_details', $mail_data, function( $message ) use ($mail_data)
                {
                    $message->to( $mail_data['email'] )->subject( 'Quotation Details' );
                });
            }
            catch(\Exception $e){
                $message = 'Pre Invoice updated successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            } 
        }
        return redirect('preinvoices')->with('message', $message);
    }

    public function getProduct($id)
    {
        $product_code = [];
        $product_name = [];
        $product_qty = [];
        $product_price = [];
        $product_data = [];

        //retrieve data of product without variant
        $lims_product_warehouse_data = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
        ->where([
            ['products.is_active', true],
            ['product_warehouse.warehouse_id', $id],
        ])
        ->whereNull('product_warehouse.variant_id')
        ->whereNull('product_warehouse.product_batch_id')
        ->select('product_warehouse.*')
        ->get();

        foreach ($lims_product_warehouse_data as $product_warehouse) 
        {
            $product_qty[] = $product_warehouse->qty;
            $product_price[] = $product_warehouse->price;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $product_code[] =  $lims_product_data->code;
            $product_name[] = $lims_product_data->name;
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = null;
            $qty_list[] = null;
            $batch_no[] = null;
            $product_batch_id[] = null;
        }

        config()->set('database.connections.mysql.strict', false);
        \DB::reconnect(); //important as the existing connection if any would be in strict mode

        $lims_product_with_batch_warehouse_data = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
        ->where([
            ['products.is_active', true],
            ['product_warehouse.warehouse_id', $id],
        ])
        ->whereNull('product_warehouse.variant_id')
        ->whereNotNull('product_warehouse.product_batch_id')
        ->select('product_warehouse.*')
        ->groupBy('product_warehouse.product_id')
        ->get();

        //now changing back the strict ON
        config()->set('database.connections.mysql.strict', true);
        \DB::reconnect();

        foreach ($lims_product_with_batch_warehouse_data as $product_warehouse) 
        {
            $product_qty[] = $product_warehouse->qty;
            $product_price[] = $product_warehouse->price;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $product_code[] =  $lims_product_data->code;
            $product_name[] = $lims_product_data->name;
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = null;
            $qty_list[] = null;
            $product_batch_data = ProductBatch::select('id', 'batch_no')->find($product_warehouse->product_batch_id);
            $batch_no[] = $product_batch_data->batch_no;
            $product_batch_id[] = $product_batch_data->id;
        }
        //retrieve data of product with variant
        $lims_product_warehouse_data = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
        ->where([
            ['products.is_active', true],
            ['product_warehouse.warehouse_id', $id],
        ])->whereNotNull('product_warehouse.variant_id')->select('product_warehouse.*')->get();
        foreach ($lims_product_warehouse_data as $product_warehouse)
        {
            $product_qty[] = $product_warehouse->qty;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $lims_product_variant_data = ProductVariant::select('item_code')->FindExactProduct($product_warehouse->product_id, $product_warehouse->variant_id)->first();
            $product_code[] =  $lims_product_variant_data->item_code;
            $product_name[] = $lims_product_data->name;
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = null;
            $qty_list[] = null;
            $batch_no[] = null;
            $product_batch_id[] = null;
        }
        //retrieve product data of digital and combo
        $lims_product_data = Product::whereNotIn('type', ['standard'])->where('is_active', true)->get();
        foreach ($lims_product_data as $product) 
        {
            $product_qty[] = $product->qty;
            $lims_product_data = $product->id;
            $product_code[] =  $product->code;
            $product_name[] = $product->name;
            $product_type[] = $product->type;
            $product_id[] = $product->id;
            $product_list[] = $product->product_list;
            $qty_list[] = $product->qty_list;
        }
        $product_data = [$product_code, $product_name, $product_qty, $product_type, $product_id, $product_list, $qty_list, $product_price, $batch_no, $product_batch_id];
        return $product_data;
    }

    public function limsProductSearch(Request $request)
    {
        $todayDate = date('Y-m-d');
        $product_code = explode("(", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");
        $product_variant_id = null;
        $lims_product_data = Product::where('code', $product_code[0])->first();
        if(!$lims_product_data) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.*', 'product_variants.id as product_variant_id', 'product_variants.item_code', 'product_variants.additional_price')
                ->where('product_variants.item_code', $product_code[0])
                ->first();
            $product_variant_id = $lims_product_data->product_variant_id;
            $lims_product_data->code = $lims_product_data->item_code;
            $lims_product_data->price += $lims_product_data->additional_price;
        }
        $product[] = $lims_product_data->name;
        $product[] = $lims_product_data->code;
        if($lims_product_data->promotion && $todayDate <= $lims_product_data->last_date){
            $product[] = $lims_product_data->promotion_price;
        }
        else
            $product[] = $lims_product_data->price;
        
        if($lims_product_data->tax_id) {
            $lims_tax_data = Tax::find($lims_product_data->tax_id);
            $product[] = $lims_tax_data->rate;
            $product[] = $lims_tax_data->name;
        }
        else{
            $product[] = 0;
            $product[] = 'No Tax';
        }
        $product[] = $lims_product_data->tax_method;
        if($lims_product_data->type == 'standard'){
            $units = Unit::where("base_unit", $lims_product_data->unit_id)
                        ->orWhere('id', $lims_product_data->unit_id)
                        ->get();
            $unit_name = array();
            $unit_operator = array();
            $unit_operation_value = array();
            foreach ($units as $unit) {
                if($lims_product_data->sale_unit_id == $unit->id) {
                    array_unshift($unit_name, $unit->unit_name);
                    array_unshift($unit_operator, $unit->operator);
                    array_unshift($unit_operation_value, $unit->operation_value);
                }
                else {
                    $unit_name[]  = $unit->unit_name;
                    $unit_operator[] = $unit->operator;
                    $unit_operation_value[] = $unit->operation_value;
                }
            }
            
            $product[] = implode(",",$unit_name) . ',';
            $product[] = implode(",",$unit_operator) . ',';
            $product[] = implode(",",$unit_operation_value) . ',';
        }
        else {
            $product[] = 'n/a'. ',';
            $product[] = 'n/a'. ',';
            $product[] = 'n/a'. ',';
        }
        $product[] = $lims_product_data->id;
        $product[] = $product_variant_id;
        $product[] = $lims_product_data->promotion;
        $product[] = $lims_product_data->is_batch;
        $product[] = $lims_product_data->is_imei;
        return $product;
    }

    public function productQuotationData($id)
    {
        $lims_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
        foreach ($lims_product_quotation_data as $key => $product_quotation_data) {
            $product = Product::find($product_quotation_data->product_id);
            if($product_quotation_data->variant_id) {
                $lims_product_variant_data = ProductVariant::select('item_code')->FindExactProduct($product_quotation_data->product_id, $product_quotation_data->variant_id)->first();
                $product->code = $lims_product_variant_data->item_code;
            }
            if($product_quotation_data->sale_unit_id){
                $unit_data = Unit::find($product_quotation_data->sale_unit_id);
                $unit = $unit_data->unit_code;
            }
            else
                $unit = '';

            $product_quotation[0][$key] = $product->name . ' [' . $product->code . ']';
            $product_quotation[1][$key] = $product_quotation_data->qty;
            $product_quotation[2][$key] = $unit;
            $product_quotation[3][$key] = $product_quotation_data->tax;
            $product_quotation[4][$key] = $product_quotation_data->tax_rate;
            $product_quotation[5][$key] = $product_quotation_data->discount;
            $product_quotation[6][$key] = $product_quotation_data->total;
            if($product_quotation_data->product_batch_id) {
                $product_batch_data = ProductBatch::select('batch_no')->find($product_quotation_data->product_batch_id);
                $product_quotation[7][$key] = $product_batch_data->batch_no;
            }
            else
                $product_quotation[7][$key] = 'N/A';
        }
        return $product_quotation;
    }

    public function productWithoutVariant()
    {
        return Product::ActiveStandard()->select('id', 'name', 'code')
                ->whereNull('is_variant')->get();
    }

    public function productWithVariant()
    {
        return Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->ActiveStandard()
                ->whereNotNull('is_variant')
                ->select('products.id', 'products.name', 'product_variants.item_code')
                ->orderBy('position')->get();
    }
    public function deleteBySelection(Request $request)
    {
        $quotation_id = $request['quotationIdArray'];
        foreach ($quotation_id as $id) {
            $lims_quotation_data = Quotation::find($id);
            $lims_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
            foreach ($lims_product_quotation_data as $product_quotation_data) {
                $product_quotation_data->delete();
            }
            $lims_quotation_data->delete();
        }
        return 'Pre Invoice deleted successfully!';
    }

    public function destroy($id)
    {
        $lims_quotation_data = Quotation::find($id);
        $lims_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
        foreach ($lims_product_quotation_data as $product_quotation_data) {
            $product_quotation_data->delete();
        }
        $lims_quotation_data->delete();
        return redirect('preinvoices')->with('not_permitted', 'Pre Invoice deleted successfully');
    }
}
