<?php

use App\Brand;
use App\Http\Controllers\AssemblyGroupNodeController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RetailerRegisterController;
use App\Http\Controllers\Auth\RetailerLoginController;
use App\Http\Controllers\BalanceSheetController;
use App\Http\Controllers\CashManagementController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeSearchController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MakeController;
use App\Http\Controllers\StockManagementController;
use App\Models\Ambrand;
use App\Models\ChassisNumber;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/testview', function(){
	$type = ["V","L","B"];
        $manufacturers = Manufacturer::whereIn('linkingTargetType', $type)->limit(10)->get();
        $manfuacture_array = [
            'type' => "P",
            'sub_type' => "home",
            'value' => 10,
        ];
        session()->put('manufacturer_load_more',$manfuacture_array);
        $model_array = [
            'type' => "null",
            'sub_type' => "null",
            'value' => 0,
        ];
        session()->put('model_load_more',$model_array);
        $engine_array = [
            'engine_type' => "null",
            'engine_sub_type' => "null",
            'value' => 0,
        ];
        session()->put('engine_load_more',$engine_array);
        $brands = Ambrand::where('lang','EN')->limit(10)->get();
        $brands_count = Ambrand::count();
        session()->put("record",10);
        session()->put('section_count',[]);
        session()->put('sub_section_count',[]);
        session()->put('section_brand_id',[]);

        session()->put('manufacturer_count_value', 0);
        session()->put('model_count_value', 0);
        session()->put('engine_count_value', 0);
        session()->put('section_count_value', 0);
        session()->put('section_part_count_value', 0);
        session()->put('purchase_brand_count_value', 0);
        session()->put('section_part_count_value_for_sale', 0);
        session()->put('plate_engine_count_value', 0);
        session()->put('plate_section_count_value', 0);
        session()->put('plate_section_part_count_value', 0);
        return view('test',compact('manufacturers','brands','brands_count'));
});

Route::get('/export',function(Request $request){
	ini_set('memory_limit', '666666666666666666666666666666664M');
    ini_set('max_execution_time', '66666666666666666666666666666666666666666666666666666');

	// $headers = [
	// 	'Cache-Control'        => 'must-revalidate, post-check=0, pre-check=0'
	// 	,'Content-type'        => 'text/csv'
	// 	,'Content-Disposition' => 'attachment; filename=plate_no_data.csv'
	// 	,'Expires'             => '0'
	// 	,'Pragma'              => 'public',
	// ];
	$new_list = [];
	$chassis_numbers = ChassisNumber::select('CHASSIS')->skip(23000)->take(1000)->get();
	$content = "";
	foreach ($chassis_numbers as $chassis_number) {
		$response_data = [];
		//sleep(240);
		$response = Http::get('https://partsapi.ru/api.php?method=VINdecode&key=f1af8ee7f280a19d3bec7b44a8c64310&vin='.$chassis_number->CHASSIS.'&lang=en');
		// if(!empty($response->body())){
			$chassis_number['VIN_Number'] = $chassis_number->CHASSIS;
			$chassis_number['Data'] = !empty($response->body()) ? json_decode($response->body()) : NULL;
			$content .= $chassis_number->VIN_Number ."-----". json_encode($chassis_number->Data);
			$content .= "\n";
		// }
		
		// array_push($new_list, $chassis_number);
	}
	$fileName = "chassis_numbers.txt";

// make a response, with the content, a 200 response code and the headers
			return Response::make($content, 200, [
			'Content-type' => 'text/plain', 
			'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
			'Content-Length' => 9000000000000000000000000000000000000000000000000000000000000000000000000000000000000
			]);
		
			// dd($collection);
			// return Excel::download(new UsersExport, 'chassis.xlsx');
		// $callback = function () use ($new_list) {
		// 	$FH = fopen('php://output', 'w');
		// 	foreach ($new_list as $row) {
		// 		//dd($row);
		// 		fputcsv($FH, $row);
		// 	}
		// 	fclose($FH);
		// };
		// 	// dd(response()->stream($callback, 200, $headers));

		// return response()->stream($callback, 200, $headers);
		// return new Response($callback, 200, $headers);
})->name('exportData');

Route::post('checkFile', 'StockManagementController@getRejectedItemCSV')->name('checkFile');

Route::get('preinvoice-pdf/{id}', 'SaleController@preinvoicepdf')->name('sales.preinvoicepdf');
Route::get('delivery-slip-pdf/{id}', 'SaleController@deliverySlipPDF')->name('sales.delivery-slip');
Route::get('purchase_pdf/{id}', 'PurchaseController@purchasePdf')->name('purchase_pdf');

Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard', 'HomeController@dashboard');
});

Route::post('do-register', [RetailerRegisterController::class, 'create'])->name('do-register');
Route::post('do-login', [RetailerLoginController::class, 'login'])->name('do-login');

Route::get('/get_logout', 'UserController@userLogout')->name('user_logout');



Route::group(['middleware' => ['auth', 'active']], function () {
	
	Route::get('purchase_preview', function () {
		return view('purchase.purchase_preview');
	})->name('purchase_preview');

	Route::resource('preinvoices', 'PreInvoiceController');

	Route::resource('assembly_group_nodes', 'AssemblyGroupNodeController');  // for erp
	Route::get('assembly_group_nodes/getSectionParts/{id}', 'AssemblyGroupNodeController@getSectionParts')->name('get_section.parts'); // for erp
	Route::get('assembly_group_nodes/language/{id}', 'AssemblyGroupNodeController@getLanguage')->name('get_language'); // for erp
	Route::resource('languages', 'LanguagesController'); // for erp

	Route::resource('invoices', 'InvoiceController');
	Route::get('invoices/getproduct/{id}', 'InvoiceController@getProduct')->name('invoice.getproduct');
	Route::get('preinvoices/getproduct/{id}', 'PreInvoiceController@getProduct')->name('preinvoice.getproduct');
	Route::get('invoices/product_quotation/{id}', 'InvoiceController@productQuotationData');
	Route::get('preinvoices/product_quotation/{id}', 'PreInvoiceController@productQuotationData');
	Route::get('preinvoices/lims_product_search', 'PreInvoiceController@limsProductSearch')->name('product_preinvoice.search');
	Route::get('lims_product_search_invoice', 'InvoiceController@limsProductSearch')->name('product_invoice.search');

	// Route::get('data/edit/{id}','QuotationController@edit');

	Route::get('getform', [FormController::class, 'getForm'])->name('getform');
	Route::post('formSave', [FormController::class, 'formSave'])->name('formSave');
	Route::get('formMessage', [FormController::class, 'formMessage'])->name('formMessage');

	Route::get('/read_notification/{id?}', 'FormController@readNotification')->name('read_notification');

	Route::resource('form', 'FormController');
	Route::get('fillform/{id}', [FormController::class, 'showform'])->name('Filform');
	Route::get('showSubmitForm', [FormController::class, 'showSubmitForm'])->name('showSubmitForm');
	Route::get('/reShowSubmitForm/{noti_id}', 'FormController@reShowSubmitForm');

	Route::post('formData', [FormController::class, 'formData'])->name('formData');

	Route::get('test', function () {
		event(new App\Events\StatusLiked('Ali'));
		return "Event has been sent!";
	});


	Route::get('/user_show/{user_id}/{noti_id}', [UserController::class, 'show']);

	Route::get('/', 'HomeSearchController@homeSearchView');
	Route::get('/approved_dashboard/{id?}', 'HomeController@approvedDashboard');
	Route::get('switch-theme/{theme}', 'HomeController@switchTheme')->name('switchTheme');
	Route::get('/dashboard-filter/{start_date}/{end_date}', 'HomeController@dashboardFilter');
	Route::get('check-batch-availability/{product_id}/{batch_no}/{warehouse_id}', 'ProductController@checkBatchAvailability');

	Route::get('language_switch/{locale}', 'LanguageController@switchLanguage');

	Route::get('role/permission/{id}', 'RoleController@permission')->name('role.permission');
	Route::post('role/set_permission', 'RoleController@setPermission')->name('role.setPermission');
	Route::resource('role', 'RoleController');

	Route::post('importunit', 'UnitController@importUnit')->name('unit.import');
	Route::post('unit/deletebyselection', 'UnitController@deleteBySelection');
	Route::get('unit/lims_unit_search', 'UnitController@limsUnitSearch')->name('unit.search');
	Route::resource('unit', 'UnitController');

	Route::post('category/import', 'CategoryController@import')->name('category.import');
	Route::post('category/deletebyselection', 'CategoryController@deleteBySelection');
	Route::post('category/category-data', 'CategoryController@categoryData');
	Route::resource('category', 'CategoryController');

	Route::post('importbrand', 'BrandController@importBrand')->name('brand.import');
	Route::post('brand/deletebyselection', 'BrandController@deleteBySelection');
	Route::get('brand/lims_brand_search', 'BrandController@limsBrandSearch')->name('brand.search');
	Route::resource('brand', 'BrandController');

	Route::post('importsupplier', 'SupplierController@importSupplier')->name('supplier.import');
	Route::post('supplier/deletebyselection', 'SupplierController@deleteBySelection');
	Route::get('supplier/lims_supplier_search', 'SupplierController@limsSupplierSearch')->name('supplier.search');
	Route::resource('supplier', 'SupplierController');

	Route::post('importwarehouse', 'WarehouseController@importWarehouse')->name('warehouse.import');
	Route::post('warehouse/deletebyselection', 'WarehouseController@deleteBySelection');
	Route::get('warehouse/lims_warehouse_search', 'WarehouseController@limsWarehouseSearch')->name('warehouse.search');
	Route::resource('warehouse', 'WarehouseController');

	Route::post('importtax', 'TaxController@importTax')->name('tax.import');
	Route::post('tax/deletebyselection', 'TaxController@deleteBySelection');
	Route::get('tax/lims_tax_search', 'TaxController@limsTaxSearch')->name('tax.search');
	Route::resource('tax', 'TaxController');

	//Route::get('products/getbarcode', 'ProductController@getBarcode');
	Route::post('products/product-data', 'ProductController@productData');
	Route::get('products/gencode', 'ProductController@generateCode');
	Route::get('products/search', 'ProductController@search');
	Route::get('products/saleunit/{id}', 'ProductController@saleUnit');
	Route::get('products/getdata/{id}/{variant_id}', 'ProductController@getData');
	Route::get('products/product_warehouse/{id}', 'ProductController@productWarehouseData');
	Route::post('importproduct', 'ProductController@importProduct')->name('product.import');
	Route::post('exportproduct', 'ProductController@exportProduct')->name('product.export');
	Route::get('products/print_barcode', 'ProductController@printBarcode')->name('product.printBarcode');

	Route::get('products/lims_product_search', 'ProductController@limsProductSearch')->name('product.search');
	Route::post('products/deletebyselection', 'ProductController@deleteBySelection');
	Route::post('products/update', 'ProductController@updateProduct');


	// Route::resource('products', ProductController::class);

	Route::post('importcustomer_group', 'CustomerGroupController@importCustomerGroup')->name('customer_group.import');
	Route::post('customer_group/deletebyselection', 'CustomerGroupController@deleteBySelection');
	Route::get('customer_group/lims_customer_group_search', 'CustomerGroupController@limsCustomerGroupSearch')->name('customer_group.search');
	Route::resource('customer_group', 'CustomerGroupController');

	Route::resource('discount-plans', 'DiscountPlanController');
	Route::resource('discounts', 'DiscountController');
	Route::get('discounts/product-search/{code}', 'DiscountController@productSearch');

	Route::post('importcustomer', 'CustomerController@importCustomer')->name('customer.import');
	Route::get('customer/getDeposit/{id}', 'CustomerController@getDeposit');
	Route::post('customer/add_deposit', 'CustomerController@addDeposit')->name('customer.addDeposit');
	Route::post('customer/update_deposit', 'CustomerController@updateDeposit')->name('customer.updateDeposit');
	Route::post('customer/deleteDeposit', 'CustomerController@deleteDeposit')->name('customer.deleteDeposit');
	Route::post('customer/deletebyselection', 'CustomerController@deleteBySelection');
	Route::get('customer/lims_customer_search', 'CustomerController@limsCustomerSearch')->name('customer.search');
	Route::resource('customer', 'CustomerController');

	Route::post('importbiller', 'BillerController@importBiller')->name('biller.import');
	Route::post('biller/deletebyselection', 'BillerController@deleteBySelection');
	Route::get('biller/lims_biller_search', 'BillerController@limsBillerSearch')->name('biller.search');
	Route::resource('biller', 'BillerController');

	Route::post('sales/sale-data', 'SaleController@saleData');
	Route::post('sales/sendmail', 'SaleController@sendMail')->name('sale.sendmail');
	Route::get('sales/sale_by_csv', 'SaleController@saleByCsv');
	Route::get('sales/product_sale/{id}', 'SaleController@productSaleData');
	Route::post('importsale', 'SaleController@importSale')->name('sale.import');
	Route::get('pos', 'SaleController@posSale')->name('sale.pos');
	Route::get('sales/lims_sale_search', 'SaleController@limsSaleSearch')->name('sale.search');
	Route::get('sales/lims_product_search', 'SaleController@limsProductSearch')->name('product_sale.search');
	Route::get('sales/getcustomergroup/{id}', 'SaleController@getCustomerGroup')->name('sale.getcustomergroup');
	Route::get('sales/getproduct', 'SaleController@getProduct')->name('sale.getproduct');
	Route::get('sales/getproduct/{category_id}/{brand_id}', 'SaleController@getProductByFilter');
	Route::get('sales/getfeatured', 'SaleController@getFeatured');
	Route::get('sales/get_gift_card', 'SaleController@getGiftCard');
	Route::get('sales/paypalSuccess', 'SaleController@paypalSuccess');
	Route::get('sales/paypalPaymentSuccess/{id}', 'SaleController@paypalPaymentSuccess');
	Route::get('sales/gen_invoice/{id}', 'SaleController@genInvoice')->name('sale.invoice');
	Route::post('sales/add_payment', 'SaleController@addPayment')->name('sale.add-payment');
	Route::get('sales/getpayment/{id}', 'SaleController@getPayment')->name('sale.get-payment');
	Route::post('sales/updatepayment', 'SaleController@updatePayment')->name('sale.update-payment');
	Route::post('sales/deletepayment', 'SaleController@deletePayment')->name('sale.delete-payment');
	Route::get('sales/{id}/create', 'SaleController@createSale');
	Route::post('sales/deletebyselection', 'SaleController@deleteBySelection');
	Route::get('sales/print-last-reciept', 'SaleController@printLastReciept')->name('sales.printLastReciept');
	Route::get('sales/today-sale', 'SaleController@todaySale');
	Route::get('sales/today-profit/{warehouse_id}', 'SaleController@todayProfit');
	Route::get('sales/check-discount', 'SaleController@checkDiscount');
	Route::get('sales/estimate/preview', 'SaleController@estimatePreview')->name('sales.estimatePreview');
	Route::get('approve/sale/estimate/{id}', 'SaleController@approveEstimate')->name('sales.approveEstimate');
	Route::get('accept/sale/estimate/{id}', 'SaleController@acceptEstimate')->name('sales.acceptEstimate');
	Route::get('cancel/sale/estimate/{id}', 'SaleController@cancelEstimate')->name('sales.cancelEstimate');
	Route::get('negotiate/sale/estimate/{id}', 'SaleController@negotiateEstimate')->name('sales.negotiateEstimate');
	Route::get('reactivate/sale/estimate/{id}', 'SaleController@reactivateEstimate')->name('sales.reactivateEstimate');
	Route::get('downloadpdf/sale/estimate/{id}', 'SaleController@downloadPdfEstimate')->name('sales.downloadPdfEstimate');
	Route::get('create/sale/invoice/{id}', 'SaleController@createSaleInvoice')->name('sales.createSaleInvoice');
	Route::get('sales/invoices', 'SaleController@salesInvoices')->name('sales.salesInvoices');
	Route::get('generate-preinvoice-pdf/{id}', 'SaleController@generatePreInvoicePDF')->name('sales.generatePreInvoicePDF');
	Route::get('preinvoice-pdf/{id}', 'SaleController@PreInvoicePDF')->name('sales.PreInvoicePDF');

	Route::get('invoice/edit/{id}', 'SaleController@editInvoice')->name('sales.editInvoice');
	Route::put('invoice/update/{id}', 'SaleController@updateInvoice')->name('sales.updateInvoice');
	Route::get('invoice/change/status/{id}/{val}', 'SaleController@changeInvoiceStatus')->name('sales.changeInvoiceStatus');

	// Route::get('generate-pdf', [PDFController::class, 'generatePDF']);
	///////////////////// sale controllers ////////////////////////
	Route::resource('sales', 'SaleController');
	Route::get('sale/new/create', 'SaleController@newCreate')->name('sales.newCreate');
	Route::get('sale_product_delete', 'SaleController@saleProductDelete');
	Route::get('get_section_parts_in_table', 'SaleController@showSectionParts')->name('get_section_parts_in_table');

	/////////////////////////// end /////////////////////////////

	Route::get('delivery', 'DeliveryController@index')->name('delivery.index');
	Route::get('delivery/product_delivery/{id}', 'DeliveryController@productDeliveryData');
	Route::get('delivery/create/{id}', 'DeliveryController@create');
	Route::post('delivery/store', 'DeliveryController@store')->name('delivery.store');
	Route::post('delivery/sendmail', 'DeliveryController@sendMail')->name('delivery.sendMail');
	Route::get('delivery/{id}/edit', 'DeliveryController@edit');
	Route::post('delivery/update', 'DeliveryController@update')->name('delivery.update');
	Route::post('delivery/deletebyselection', 'DeliveryController@deleteBySelection');
	Route::post('delivery/delete/{id}', 'DeliveryController@delete')->name('delivery.delete');

	Route::get('quotations/product_quotation/{id}', 'QuotationController@productQuotationData');
	Route::get('quotations/lims_product_search', 'QuotationController@limsProductSearch')->name('product_quotation.search');
	Route::get('quotations/getcustomergroup/{id}', 'QuotationController@getCustomerGroup')->name('quotation.getcustomergroup');
	Route::get('quotations/getproduct/{id}', 'QuotationController@getProduct')->name('quotation.getproduct');
	Route::get('quotations/{id}/create_sale', 'QuotationController@createSale')->name('quotation.create_sale');
	Route::get('quotations/{id}/create_purchase', 'QuotationController@createPurchase')->name('quotation.create_purchase');
	Route::post('quotations/sendmail', 'QuotationController@sendMail')->name('quotation.sendmail');
	Route::post('quotations/deletebyselection', 'QuotationController@deleteBySelection');
	Route::resource('quotations', 'QuotationController');

	Route::post('purchases/purchase-data', 'PurchaseController@purchaseData')->name('purchases.data');
	Route::get('purchases/product_purchase/{id}', 'PurchaseController@productPurchaseData');
	Route::get('purchases/lims_product_search', 'PurchaseController@limsProductSearch')->name('product_purchase.search');
	Route::post('purchases/add_payment', 'PurchaseController@addPayment')->name('purchase.add-payment');
	Route::get('purchases/getpayment/{id}', 'PurchaseController@getPayment')->name('purchase.get-payment');
	Route::post('purchases/updatepayment', 'PurchaseController@updatePayment')->name('purchase.update-payment');
	Route::post('purchases/deletepayment', 'PurchaseController@deletePayment')->name('purchase.delete-payment');
	Route::get('purchases/purchase_by_csv', 'PurchaseController@purchaseByCsv');
	Route::post('importpurchase', 'PurchaseController@importPurchase')->name('purchase.import');
	Route::post('purchases/deletebyselection', 'PurchaseController@deleteBySelection');

	/////////////// Purchase Controller ////////////////
	Route::resource('purchases', PurchaseController::class);
	Route::get('viewPurchase/{id}', 'PurchaseController@viewPurchase')->name('view_purchase'); // view a purchase
	Route::get('editPurchase/{id}', 'PurchaseController@editPurchase'); // edit a purchase
	Route::get('updatePurchaseProduct', 'PurchaseController@updatePurchase')->name('update_purchase'); // update a purchase
	Route::get('deletePurchaseProduct/{purchase_id}/{id}', 'PurchaseController@deletePurchaseProduct')->name('delete_purchase'); // delete a purchase product
	Route::get('deletePurchase/{purchase_id}', 'PurchaseController@deleteParentPurchase')->name('delete_parent_purchase'); // delete a parent purchase
	Route::get('updatePurchaseProductQuantity', 'PurchaseController@updatePurchaseProductQuantity')->name('update_purchase_product_quantity'); // update a purchase
	////////////////Purchase END //////////////////////// 

	/////////////// Product Controller /////////////////
	Route::resource('products', ProductController::class);
	Route::get('product/editPurchaseByProduct/{product_id}', 'ProductController@editProduct');
	Route::get('product/viewProduct/{product_id}', 'ProductController@viewProduct');
	/////////////////// Product end /////////////////////

	///////////////// Stock management ///////////////////
	Route::resource('stockManagement', 'StockManagementController');
	Route::get('product/deleteStock/{stock_id}', 'StockManagementController@destroy');
	Route::post('/import/csv/', 'StockManagementController@importCsv')->name('stock.import');
	/////////////////// Stock end //////////////////////

	Route::get('product/list', 'ProductController@index')->name('products.index'); // view a purchase
	Route::get('exportPurchases', 'PurchaseController@exportPurchases')->name('exportPurchases'); // Export Purchase
	Route::get('pdfDownload', 'PurchaseController@pdfDownload')->name('purchasesPdfDownload'); //  Purchases pdf download


	///////////////// Purchase Article management ///////////////////
	Route::get('manufacturers_by_engine_type', 'PurchaseController@getManufacturersByEngineType')->name('manufacturers_by_engine_type');
	Route::get('get_manufacturers_by_engine_type', 'PurchaseController@getManufacturersByEngineType')->name('get_manufacturers_by_engine_type');
	Route::get('get_models_by_manufacturer', 'PurchaseController@getModelsByManufacturer')->name('get_models_by_manufacturer');
	Route::get('get_engines_by_model', 'PurchaseController@getEnginesByModel')->name('get_engines_by_model');
	Route::get('get_sections_by_engine', 'PurchaseController@getSectionsByEngine')->name('get_sections_by_engine');
	Route::get('get_section_parts', 'PurchaseController@getSectionParts')->name('get_section_parts'); // get all articles
	Route::get('get_brands_by_section_part', 'PurchaseController@getBrandsBySectionPart')->name('get_brands_by_section_part'); // get all suppliers against an article
	Route::get('show_section_parts_in_table', 'PurchaseController@showSectionParts')->name('show_section_parts_in_table');
	Route::get('getArticleInfo', 'PurchaseController@getArticleInfo')->name('article.info.get');
	Route::get('articlesByReferenceNo', 'PurchaseController@articlesByReferenceNo')->name('article.reference');
	Route::get('sale_products_by_product_number', 'SaleController@productByArticleNumber')->name('sale_products_by_product_number');

	Route::get('get_chasis_number', 'PurchaseController@getChasisNumber')->name('chasis_number.get');
	Route::get('get_purchase_plate_engine_by_model', 'PurchaseController@getPurchasePlateEngineByModel')->name('get_purchase_plate_engine_by_model');
	Route::get('get_purchase_plate_section_by_engine', 'PurchaseController@getPurchasePlateSectionByEngine')->name('get_purchase_plate_section_by_engine');
	Route::get('get_purchase_plate_section_part_by_section', 'PurchaseController@getPurchasePlateSectionPartBySection')->name('get_purchase_plate_section_part_by_section');
	Route::get('get_purchase_plate_brand_by_section_part', 'PurchaseController@getPurchasePlateBrandBySectionPart')->name('get_purchase_plate_brand_by_section_part');
	Route::get('get_home_brand_auto_complete', 'HomeSearchController@getHomeBrandAutoComplete')->name('get_home_brand_auto_complete');

	///////////////////  end //////////////////////

	///////////////////////// Sale-unique ////////////////////////
	Route::get('getArticleSale', 'SaleController@getArticleInfo')->name('article.info.getsale');

	Route::get('get_section_parts_for_sale', 'SaleController@getSectionPartsForSale')->name('get_section_parts_for_sale'); // get all articles from stock
	Route::get('check_product_stock', 'SaleController@checkProductStock')->name('check_product_stock'); // 
	Route::get('show_section_parts_in_table_for_sale', 'SaleController@showSectionParts')->name('show_section_parts_in_table_for_sale');
	Route::get('change_sale_status', 'SaleController@changeSaleStatus')->name('change_sale_status');
	Route::get('view_sale/{id}', 'SaleController@viewSale')->name('view_sale');

	Route::get('change_invoice_status', 'InvoiceController@changeInvoiceStatus')->name('change_invoice_status');
	Route::get('createInvoice/{id}', 'InvoiceController@createInvoice')->name('create_invoice');
	Route::get('show_invoice/{id}', 'InvoiceController@showInvoice')->name('show_invoice');

	Route::get('delivery_slips', 'InvoiceController@getDeliverySlips')->name('delivery_slips');
	Route::get('show_delivery_slip/{id}', 'InvoiceController@showDeliverySlip')->name('show_delivery_slip');

	Route::get('delivery_slips', 'InvoiceController@getDeliverySlips')->name('delivery_slips'); 
	Route::get('show_delivery_slip/{id}', 'InvoiceController@showDeliverySlip')->name('show_delivery_slip'); 
	///////////////////  Home Search views  ///////////////////
	Route::get('home_search', 'HomeSearchController@homeSearchView')->name('home_search'); 
	Route::get('get_home_manufacturers', 'HomeSearchController@getManufacturers')->name('get_home_manufacturers'); 
	Route::get('get_models_by_manufacturer_home_search', 'HomeSearchController@getModelsByManufacturer')->name('get_models_by_manufacturer_home_search'); 
	Route::get('get_engines_by_model_home_search', 'HomeSearchController@getEnginesByModel')->name('get_engines_by_model_home_search'); 
	Route::get('get_data_of_engine_home_search', 'HomeSearchController@getEngineData')->name('get_data_of_engine_home_search'); 
	Route::post('search_sections_by_engine', 'HomeSearchController@searchSectionByEngine')->name('search_sections_by_engine'); 

	// old functions
	Route::get('get_search_sections_by_enginee/{engine_id}/{type}/{sub_type}/{model_year}/{fuel}/{cc}', 'HomeSearchController@getSearchSectionByEngineOld')->name('get_search_sections_by_enginee'); 
	Route::get('articles_search_vieww/{id}/{section_id}/{type}', [HomeSearchController::class,'articleSearchViewOld'])->name('articles_search_vieww');
	Route::get('articles_vieww/{id}/{engine_id}/{sub_section_id}', [HomeSearchController::class,'articleViewOld'])->name('articles_vieww');
	// new functions 
	Route::get('get_search_sections_by_engine/{engine_id}/{type}/{sub_type}/{model_year}/{fuel}/{cc}', 'HomeSearchController@getSearchSectionByEngine')->name('get_search_sections_by_engine'); 
	Route::get('articles_search_view/{id}/{section_id}/{type}/{articleId}', [HomeSearchController::class,'articleSearchView'])->name('articles_search_view');
	Route::get('articles_view/{id}/{engine_id}/{sub_section_id}/{ga?}', [HomeSearchController::class,'articleView'])->name('articles_view');
	Route::get('get_search_sections_by_engine_load_more', 'HomeSearchController@getSearchSectionByEngineByLoadMore')->name('get_search_sections_by_engine_load_more'); 


	Route::post('purchase_add_to_cart', [HomeSearchController::class,'addToCart'])->name('purchase_add_to_cart');
	Route::get('cart', [HomeSearchController::class,'cart'])->name('cart');
	Route::post('changes_save', [HomeSearchController::class,'updateCart'])->name('changes_save');
	Route::get('remove_cart_item/{id}', [HomeSearchController::class,'removeCartItem'])->name('remove_cart_item');
	Route::get('get_sub_sections_by_brand', 'HomeSearchController@getSubSectionByBrand')->name('get_sub_sections_by_brand'); 
	Route::post('get_article_by_sub_sections', 'HomeSearchController@articleSearchViewByBrandSection')->name('get_article_by_sub_sections'); 

	Route::get('load_more_brand', 'HomeSearchController@loadMoreBrands')->name('load_more_brand'); 

	Route::get('get_article_by_sub_section/{id}/{section_id}/{type}', 'HomeSearchController@articleSearchViewBySection')->name('get_article_by_sub_section'); 
	
	// For Home Search==========auto complete routes
	Route::get('get_all_brands_by_autocomplete', 'HomeSearchController@getAutoCompleteBrands')->name('get_all_brands_by_autocomplete'); 
	Route::get('get_all_sections_by_autocomplete', 'HomeSearchController@getAutoCompleteSections')->name('get_all_sections_by_autocomplete'); 
	Route::get('get_all_manufacturers_by_autocomplete', 'HomeSearchController@getAutoCompleteManufacturers')->name('get_all_manufacturers_by_autocomplete'); 
	Route::get('get_all_models_by_autocomplete', 'HomeSearchController@getAutoCompleteModels')->name('get_all_models_by_autocomplete'); 
	Route::get('get_all_engines_by_autocomplete', 'HomeSearchController@getAutoCompleteEngine')->name('get_all_engines_by_autocomplete'); 


	// For Purchase/Sale Search==========auto complete routes
	Route::get('get_all_manufacturers_by_autocomplete_sale', 'PurchaseController@getAutoCompleteManufacturers')->name('get_all_manufacturers_by_autocomplete_sale'); 
	Route::get('get_all_models_by_autocomplete_sale', 'PurchaseController@getAutoCompleteModels')->name('get_all_models_by_autocomplete_sale'); 
	Route::get('get_all_engines_by_autocomplete_sale', 'PurchaseController@getAutoCompleteEngines')->name('get_all_engines_by_autocomplete_sale'); 
	Route::get('get_all_sections_by_autocomplete_sale', 'PurchaseController@getAutoCompleteSections')->name('get_all_sections_by_autocomplete_sale'); 
	Route::get('get_all_section_parts_by_autocomplete_sale', 'PurchaseController@getAutoCompleteSectionParts')->name('get_all_section_parts_by_autocomplete_sale'); 



	Route::get('transfers/product_transfer/{id}', 'TransferController@productTransferData');
	Route::get('transfers/transfer_by_csv', 'TransferController@transferByCsv');
	Route::post('importtransfer', 'TransferController@importTransfer')->name('transfer.import');
	Route::get('transfers/getproduct/{id}', 'TransferController@getProduct')->name('transfer.getproduct');
	Route::get('transfers/lims_product_search', 'TransferController@limsProductSearch')->name('product_transfer.search');
	Route::post('transfers/deletebyselection', 'TransferController@deleteBySelection');
	Route::resource('transfers', 'TransferController');

	Route::get('qty_adjustment/getproduct/{id}', 'AdjustmentController@getProduct')->name('adjustment.getproduct');
	Route::get('qty_adjustment/lims_product_search', 'AdjustmentController@limsProductSearch')->name('product_adjustment.search');
	Route::post('qty_adjustment/deletebyselection', 'AdjustmentController@deleteBySelection');
	Route::resource('qty_adjustment', 'AdjustmentController');

	Route::get('return-sale/getcustomergroup/{id}', 'ReturnController@getCustomerGroup')->name('return-sale.getcustomergroup');
	Route::post('return-sale/sendmail', 'ReturnController@sendMail')->name('return-sale.sendmail');
	Route::get('return-sale/getproduct/{id}', 'ReturnController@getProduct')->name('return-sale.getproduct');
	Route::get('return-sale/lims_product_search', 'ReturnController@limsProductSearch')->name('product_return-sale.search');
	Route::get('return-sale/product_return/{id}', 'ReturnController@productReturnData');
	Route::post('return-sale/deletebyselection', 'ReturnController@deleteBySelection');
	Route::resource('return-sale', 'ReturnController');

	Route::get('return-purchase/getcustomergroup/{id}', 'ReturnPurchaseController@getCustomerGroup')->name('return-purchase.getcustomergroup');
	Route::post('return-purchase/sendmail', 'ReturnPurchaseController@sendMail')->name('return-purchase.sendmail');
	Route::get('return-purchase/getproduct/{id}', 'ReturnPurchaseController@getProduct')->name('return-purchase.getproduct');
	Route::get('return-purchase/lims_product_search', 'ReturnPurchaseController@limsProductSearch')->name('product_return-purchase.search');
	Route::get('return-purchase/product_return/{id}', 'ReturnPurchaseController@productReturnData');
	Route::post('return-purchase/deletebyselection', 'ReturnPurchaseController@deleteBySelection');
	Route::resource('return-purchase', 'ReturnPurchaseController');

	Route::get('report/product_quantity_alert', 'ReportController@productQuantityAlert')->name('report.qtyAlert');
	Route::get('report/warehouse_stock', 'ReportController@warehouseStock')->name('report.warehouseStock');
	Route::post('report/warehouse_stock', 'ReportController@warehouseStockById')->name('report.warehouseStock');
	Route::get('report/daily_sale/{year}/{month}', 'ReportController@dailySale');
	Route::post('report/daily_sale/{year}/{month}', 'ReportController@dailySaleByWarehouse')->name('report.dailySaleByWarehouse');
	Route::get('report/monthly_sale/{year}', 'ReportController@monthlySale');
	Route::post('report/monthly_sale/{year}', 'ReportController@monthlySaleByWarehouse')->name('report.monthlySaleByWarehouse');
	Route::get('report/daily_purchase/{year}/{month}', 'ReportController@dailyPurchase');
	Route::post('report/daily_purchase/{year}/{month}', 'ReportController@dailyPurchaseByWarehouse')->name('report.dailyPurchaseByWarehouse');
	Route::get('report/monthly_purchase/{year}', 'ReportController@monthlyPurchase');
	Route::post('report/monthly_purchase/{year}', 'ReportController@monthlyPurchaseByWarehouse')->name('report.monthlyPurchaseByWarehouse');
	Route::get('report/best_seller', 'ReportController@bestSeller');
	Route::post('report/best_seller', 'ReportController@bestSellerByWarehouse')->name('report.bestSellerByWarehouse');
	Route::post('report/profit_loss', 'ReportController@profitLoss')->name('report.profitLoss');
	Route::get('report/product_report', 'ReportController@productReport')->name('report.product');
	Route::post('report/product_report_data', 'ReportController@productReportData');
	Route::post('report/purchase', 'ReportController@purchaseReport')->name('report.purchase');
	Route::post('report/sale_report', 'ReportController@saleReport')->name('report.sale');
	Route::post('report/payment_report_by_date', 'ReportController@paymentReportByDate')->name('report.paymentByDate');
	Route::post('report/warehouse_report', 'ReportController@warehouseReport')->name('report.warehouse');
	Route::post('report/user_report', 'ReportController@userReport')->name('report.user');
	Route::post('report/customer_report', 'ReportController@customerReport')->name('report.customer');
	Route::post('report/supplier', 'ReportController@supplierReport')->name('report.supplier');
	Route::post('report/due_report_by_date', 'ReportController@dueReportByDate')->name('report.dueByDate');

	Route::get('user/profile/{id}', 'UserController@profile')->name('user.profile');
	Route::put('user/update_profile/{id}', 'UserController@profileUpdate')->name('user.profileUpdate');
	Route::put('user/changepass/{id}', 'UserController@changePassword')->name('user.password');
	Route::get('user/genpass', 'UserController@generatePassword');
	Route::post('user/deletebyselection', 'UserController@deleteBySelection');
	Route::resource('user', 'UserController');

	Route::get('setting/general_setting', 'SettingController@generalSetting')->name('setting.general');
	Route::post('setting/general_setting_store', 'SettingController@generalSettingStore')->name('setting.generalStore');

	Route::get('setting/reward-point-setting', 'SettingController@rewardPointSetting')->name('setting.rewardPoint');
	Route::post('setting/reward-point-setting_store', 'SettingController@rewardPointSettingStore')->name('setting.rewardPointStore');

	Route::get('backup', 'SettingController@backup')->name('setting.backup');
	Route::get('setting/general_setting/change-theme/{theme}', 'SettingController@changeTheme');
	Route::get('setting/mail_setting', 'SettingController@mailSetting')->name('setting.mail');
	Route::get('setting/sms_setting', 'SettingController@smsSetting')->name('setting.sms');
	Route::get('setting/createsms', 'SettingController@createSms')->name('setting.createSms');
	Route::post('setting/sendsms', 'SettingController@sendSms')->name('setting.sendSms');
	Route::get('setting/hrm_setting', 'SettingController@hrmSetting')->name('setting.hrm');
	Route::post('setting/hrm_setting_store', 'SettingController@hrmSettingStore')->name('setting.hrmStore');
	Route::post('setting/mail_setting_store', 'SettingController@mailSettingStore')->name('setting.mailStore');
	Route::post('setting/sms_setting_store', 'SettingController@smsSettingStore')->name('setting.smsStore');
	Route::get('setting/pos_setting', 'SettingController@posSetting')->name('setting.pos');
	Route::post('setting/pos_setting_store', 'SettingController@posSettingStore')->name('setting.posStore');
	Route::get('setting/empty-database', 'SettingController@emptyDatabase')->name('setting.emptyDatabase');

	Route::get('expense_categories/gencode', 'ExpenseCategoryController@generateCode');
	Route::post('expense_categories/import', 'ExpenseCategoryController@import')->name('expense_category.import');
	Route::post('expense_categories/deletebyselection', 'ExpenseCategoryController@deleteBySelection');
	Route::resource('expense_categories', 'ExpenseCategoryController');

	Route::post('expenses/deletebyselection', 'ExpenseController@deleteBySelection');
	Route::resource('expenses', 'ExpenseController');

	Route::get('gift_cards/gencode', 'GiftCardController@generateCode');
	Route::post('gift_cards/recharge/{id}', 'GiftCardController@recharge')->name('gift_cards.recharge');
	Route::post('gift_cards/deletebyselection', 'GiftCardController@deleteBySelection');
	Route::resource('gift_cards', 'GiftCardController');

	Route::get('coupons/gencode', 'CouponController@generateCode');
	Route::post('coupons/deletebyselection', 'CouponController@deleteBySelection');
	Route::resource('coupons', 'CouponController');
	//accounting routes
	Route::get('accounts/make-default/{id}', 'AccountsController@makeDefault');
	Route::get('accounts/balancesheet', 'AccountsController@balanceSheet')->name('accounts.balancesheet');
	Route::post('accounts/account-statement', 'AccountsController@accountStatement')->name('accounts.statement');
	Route::resource('accounts', 'AccountsController');
	Route::resource('money-transfers', 'MoneyTransferController');
	//HRM routes
	Route::post('departments/deletebyselection', 'DepartmentController@deleteBySelection');
	Route::resource('departments', 'DepartmentController');

	Route::post('employees/deletebyselection', 'EmployeeController@deleteBySelection');
	Route::resource('employees', 'EmployeeController');

	Route::post('payroll/deletebyselection', 'PayrollController@deleteBySelection');
	Route::resource('payroll', 'PayrollController');

	Route::post('attendance/deletebyselection', 'AttendanceController@deleteBySelection');
	Route::resource('attendance', 'AttendanceController');

	Route::resource('stock-count', 'StockCountController');
	Route::post('stock-count/finalize', 'StockCountController@finalize')->name('stock-count.finalize');
	Route::get('stock-count/stockdif/{id}', 'StockCountController@stockDif');
	Route::get('stock-count/{id}/qty_adjustment', 'StockCountController@qtyAdjustment')->name('stock-count.adjustment');

	Route::post('holidays/deletebyselection', 'HolidayController@deleteBySelection');
	Route::get('approve-holiday/{id}', 'HolidayController@approveHoliday')->name('approveHoliday');
	Route::get('holidays/my-holiday/{year}/{month}', 'HolidayController@myHoliday')->name('myHoliday');
	Route::resource('holidays', 'HolidayController');

	Route::get('cash-register', 'CashRegisterController@index')->name('cashRegister.index');
	Route::get('cash-register/check-availability/{warehouse_id}', 'CashRegisterController@checkAvailability')->name('cashRegister.checkAvailability');
	Route::post('cash-register/store', 'CashRegisterController@store')->name('cashRegister.store');
	Route::get('cash-register/getDetails/{id}', 'CashRegisterController@getDetails');
	Route::get('cash-register/showDetails/{warehouse_id}', 'CashRegisterController@showDetails');
	Route::post('cash-register/close', 'CashRegisterController@close')->name('cashRegister.close');

	Route::post('notifications/store', 'NotificationController@store')->name('notifications.store');
	Route::get('notifications/mark-as-read', 'NotificationController@markAsRead');

	Route::resource('currency', 'CurrencyController');

	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('my-transactions/{year}/{month}', 'HomeController@myTransaction');

	Route::get('products', [ProductController::class, 'getProducts'])->name('product.get');
	Route::get('suppliers', [SupplierController::class, 'getSuppliers'])->name('supplier.get');
	Route::get('supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
	Route::post('supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
	Route::get('cash/management', [CashManagementController::class, 'index'])->name('cash.management');
	Route::get('cash/management/cheque', [CashManagementController::class, 'cheque'])->name('cash.management.cheque');
	Route::get('cash/management/balance', [CashManagementController::class, 'balance'])->name('cash.management.balance');
	Route::get('cash/management/regulation/{id}', [CashManagementController::class, 'regulation'])->name('cash.managemnt.regulation');



	Route::resource('balanceSheet', 'BalanceSheetController');
	Route::get('get/balanacecategories', [BalanceSheetController::class, 'getBalanaceCategories'])->name('get_categories_from_type');
	Route::resource('bank_account', 'BankAccountController');



	Route::get('allMakes', [MakeController::class, 'getAllMakes'])->name('allmake.get');
});
Route::get('/logout', 'HomeController@logOut');
Route::get('/verify/mail', 'MailController@index');
Route::get('/sent/mail_view', 'UserController@mailView');


Auth::routes();
