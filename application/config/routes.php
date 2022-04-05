<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'user';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
#$route['script'] = 'script';
#User
$route['login'] 				= 'user/login';
$route['logout'] 				= 'user/logout';
$route['changePassword'] 		= 'user/changePassword';
$route['dashboard'] 			= 'dashboard';
$route['getStockBatchDetails'] 	= 'dashboard/getStockBatchDetails';
$route['addStockApprove'] 		= 'dashboard/addStockApprove';
$route['stockPending'] 			= 'dashboard/stockPending';
$route['stockRejected'] 		= 'dashboard/stockRejected';
$route['stockReject'] 			= 'dashboard/stockReject';
$route['stockDelete'] 			= 'dashboard/stockDelete';
$route['stockUpdate'] 			= 'dashboard/stockUpdate';
$route['adviceApprove'] 		= 'dashboard/adviceApprove';
$route['advicePending'] 		= 'dashboard/advicePending';
$route['adviceRejected'] 		= 'dashboard/adviceRejected';
$route['adviceReject'] 			= 'dashboard/adviceReject';
$route['adviceDelete'] 			= 'dashboard/adviceDelete';
$route['getMapDetails'] 		= 'dashboard/getMapDetails';

$route['userList'] 				= 'user/userList';
$route['addUser'] 				= 'user/addUser';
$route['editUser/(:any)'] 		= 'user/editUser/$1';
$route['viewUser/(:any)'] 		= 'user/viewUser/$1';
$route['permission'] 			= 'permission';
$route['setting'] 				= 'setting';
$route['addSetting'] 			= 'setting/addSetting';



$route['packer'] 				= 'packer';
$route['packerList'] 			= 'packer/packerList';
$route['editPacker/(:any)'] 	= 'packer/editPacker/$1';

#Complaint
$route['complaint'] 				= 'complaint';
$route['addComplaint'] 				= 'complaint/addComplaint';
$route['complaintView/(:any)'] 		= 'complaint/complaintView/$1';
$route['complaintDownload/(:any)'] 		= 'complaint/complaintDownload/$1';
$route['addComplaintMessage'] 		= 'complaint/addComplaintMessage';


#Search
$route['search'] = 'search';
$route['customerSearch'] = 'search/customerSearch';
$route['quotationSearch'] = 'search/quotationSearch';
$route['orderSearch'] = 'search/orderSearch';
$route['challanSearch'] = 'search/challanSearch';
$route['orderPendingProductSearch'] = 'search/orderPendingProductSearch';
$route['orderPendingCustomerSearch'] = 'search/orderPendingCustomerSearch';

#product
$route['product'] = 'product';
//$route['productform'] = 'product/productForm';
$route['addProduct'] = 'product/addProduct';
$route['ajaxGetCertificateBuyId'] = 'product/ajaxGetCertificateBuyId';
$route['addCategory'] = 'product/addCategory';
$route['categoryList'] = 'product/categoryList';
$route['editCategory/(:any)'] = 'product/editCategory/$1';
//$route['addCertificate'] = 'product/addCertificate';
$route['productView/(:any)'] = 'product/productView/$1';
$route['productView'] = 'product/productView';
$route['getProductById'] = 'product/getProductById';
$route['editProduct/(:any)'] = 'product/editProduct/$1';

#Batch
$route['batch'] = 'batch';
$route['addBatch'] = 'batch/addBatch';
#$route['uploadFile'] = 'batch/uploadFile';
$route['getBatchDetail'] = 'batch/getBatchDetail';
$route['editBatch/(:any)'] = 'batch/editBatch/$1';
$route['deleteBatch/(:any)'] = 'batch/deleteBatch/$1';

#Stock
$route['stock'] = 'stock';
$route['addStock'] = 'stock/addStock';

$route['getProductName'] = 'stock/getProductName';
$route['getProductModel'] = 'stock/getProductModel';
$route['getProductName2'] = 'stock/getProductName2';
$route['getProductModel2'] = 'stock/getProductModel2';

$route['getBatch'] = 'stock/getBatch';
$route['stockPrint/(:any)'] = 'stock/stockPrint/$1';
$route['getStockInStoreBase'] = 'stock/getStockInStoreBase';
$route['stockSummary'] = 'stock/stockSummary';
$route['getBatchInfo'] = 'stock/getBatchInfo';
$route['stockListDownload'] 	= 'stock/stockListDownload';
$route['downloadExcelFile'] 	= 'stock/downloadExcelFile';

#Customer
$route['customer'] = 'customer';
$route['addCustomer'] = 'customer/addCustomer';
$route['editCustomer/(:any)'] = 'customer/editCustomer/$1';
$route['ajaxGetSatetByCountryId'] = 'customer/ajaxGetSatetByCountryId';
$route['customerView/(:any)'] = 'customer/customerView/$1';
$route['priceList/(:any)'] = 'customer/priceList/$1';
$route['getCustomerName'] = 'customer/getCustomerName';
$route['addNewState'] = 'customer/addNewState';
$route['addNewAddress'] = 'customer/addNewAddress';
$route['getDefaultAddressCustomerById'] = 'customer/getDefaultAddressCustomerById';
$route['notes/(:any)'] = 'notes/notes/$1';
$route['getAddressByAddressId'] = 'customer/getAddressByAddressId';
$route['customerHistory/(:any)'] = 'customer/customerHistory/$1';
$route['addUniqueCustomer'] = 'customer/addUniqueCustomer';

#Quotation
$route['quotation'] = 'quotation';
$route['quoteComplete'] = 'quotation/quoteComplete';
$route['genQuote'] = 'quotation/generateQuote';
$route['addQuote'] = 'quotation/addQuote';
$route['quotationView/(:any)'] = 'quotation/quotationView/$1';
$route['editQuotation/(:any)'] = 'quotation/editQuotation/$1';
$route['downloadPdf/(:any)'] = 'quotation/downloadPdf/$1';
$route['sendMail'] = 'quotation/sendMail';

#Bank
$route['addBank'] = 'bank/addBank';
$route['saveBank'] = 'bank/saveBank';
$route['editBank/(:any)'] = 'bank/editBank/$1';
$route['bankView/(:any)'] = 'bank/bankView/$1';

#Order
$route['order'] = 'order';
$route['saveOrder'] = 'order/saveOrder';
$route['updateOrder'] = 'order/updateOrder';
$route['orderList'] = 'order/orderList';
$route['orderView/(:any)'] = 'order/orderView/$1';
$route['orderPrint/(:any)'] = 'order/orderPrint/$1';
$route['editOrder/(:any)'] = 'order/editOrder/$1';
$route['getOrderProductList'] = 'order/getOrderProductList';
$route['deleteOrderProduct'] = 'order/deleteOrderProduct';
$route['getOrderProductNotList'] = 'order/getOrderProductNotList';
$route['downloadPdf'] = 'order/downloadPdf';
$route['orderSendMail'] = 'order/orderSendMail';
$route['OrderSavePdf'] = 'order/OrderSavePdf';
$route['paymentAdvice/(:any)'] = 'order/paymentAdvice/$1';
$route['ordChallan/(:any)'] = 'order/ordChallan/$1';
$route['orderPendingProduct'] = 'order/orderPendingProduct';
$route['orderPendingProductView/(:any)'] = 'order/orderPendingProductView/$1';
$route['orderPendingCustomer'] = 'order/orderPendingCustomer';
$route['orderPendingCustomerView/(:any)'] = 'order/orderPendingCustomerView/$1';
$route['orderProductView/(:any)'] = 'order/orderProductView/$1';
$route['orderCustomerView/(:any)'] = 'order/orderCustomerView/$1';
$route['getChallanMissingFields/'] = 'order/getChallanMissingFields';

#Challan
$route['challan'] = 'challan';
$route['challanList'] = 'challan/challanList';
$route['getProductBatch'] = 'challan/getProductBatch';
$route['saveChallan'] = 'challan/saveChallan';
$route['challanList'] = 'challan/challanList';
$route['getBatchList'] = 'challan/getBatchList';
$route['getProductBatchManul'] = 'challan/getProductBatchManul';
$route['challanView/(:any)'] = 'challan/challanView/$1';
$route['challanPrint/(:any)'] = 'challan/challanPrint/$1';
$route['downloadChallan'] = 'challan/downloadChallan';
$route['createSli'] = 'challan/createSli';
$route['printSli'] = 'challan/printSli';
$route['dispatchNote/(:any)'] = 'challan/dispatchNote/$1';
$route['dispatchNoteSave'] = 'challan/dispatchNoteSave';
$route['dispatchNotePrint/(:any)'] = 'challan/dispatchNotePrint/$1';
$route['downloadPdf'] = 'challan/downloadPdf';
$route['challanSendMail'] = 'challan/challanSendMail';
$route['challanSavePdf'] = 'challan/challanSavePdf';
$route['dispatchNoteSavePdf'] = 'challan/dispatchNoteSavePdf';
$route['deleteChallan'] = 'challan/deleteChallan';

$route['addressslip'] 	= 'addressslip';
$route['addSlip'] 		= 'addressslip/addSlip';
$route['addSlipPrint'] 	= 'addressslip/addSlipPrint';
$route['addSlipDetailPrint'] 	= 'addressslip/addSlipDetailPrint';

#Returns
$route['returns'] = 'returns';
$route['addReturns'] = 'returns/addReturns';
$route['getChallanProDetails'] = 'returns/getChallanProDetails';
$route['returnsPrint'] = 'returns/returnsPrint';

#Records
$route['records'] = 'records';
$route['addRecord'] = 'records/addRecord';
$route['editRecord/(:any)'] = 'records/editRecord/$1';
$route['viewRecord/(:any)'] = 'records/viewRecord/$1';
$route['printRecord/(:any)'] = 'records/printRecord/$1';

#Certificate
$route['addCertificate'] = 'certificate/addCertificate';
$route['saveCertificate'] = 'certificate/saveCertificate';
$route['editCertificate/(:any)'] = 'certificate/editCertificate/$1';
$route['editCertificate'] = 'certificate/editCertificate';

#UploadFIle
$route['fileupload'] = 'fileupload';