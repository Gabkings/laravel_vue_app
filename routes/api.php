<?php
Route::post('/v1/notes', 'NotesController@create');
Route::get('/v1/notes', 'NotesController@allNotes');
Route::delete('v1/notes/{id}', 'NotesController@permanentDelete'); //this on first permanent delete models
Route::delete('v2/notes/{id}', 'NotesController@softDelete');
Route::get('v2/notes/withsoftdelete','NotesController@notesWithSoftDelete');
Route::get('v2/notes/softdeleted','NotesController@softDeleted');
Route::patch('/v1/notes/{id}','NotesController@restore');
Route::delete('v3/notes/{id}','NotesController@permanentDeleteSoftDeleted');


//suppliers routtes

Route::post('/v1/suppliers', 'SuppliersController@create');
Route::put('/v1/suppliers/{id}', 'SuppliersController@create');
Route::get('/v1/suppliers', 'SuppliersController@allSuppliers');
Route::get('/v1/suppliers/get_1/{id}', 'SuppliersController@getOneSupplier');
Route::delete('v1/suppliers/delete/{id}', 'SuppliersController@permanentDelete'); //this on first permanent 
Route::delete('v1/suppliers/soft/{id}', 'SuppliersController@softDelete');
Route::get('v2/suppliers/withsoftdelete','SuppliersController@suppliersWithSoftDelete');
Route::get('v2/suppliers/softdeleted','SuppliersController@softDeleted');
Route::patch('/v1/suppliers/restore/{id}','SuppliersController@restore');
Route::delete('v1/suppliers/{id}','SuppliersController@permanentDeleteSoftDeleted');

//supply products routes

Route::post('/v1/supply_products', 'SupplierProductsController@create');
Route::put('/v1/supply_products/{id}', 'SupplierProductsControllerr@create');
Route::get('/v1/supply_products', 'SupplierProductsController@allSupplier_products');
Route::get('/v1/supply_products/get_1/{id}', 'SupplierProductsController@oneProduct');
Route::delete('v1/supply_products/delete/{id}', 'SupplierProductsController@permanentDelete'); //this on first permanent 
Route::delete('v1/supply_products/soft/{id}', 'SupplierProductsController@softDelete');
Route::get('v2/supply_products/withsoftdelete','SupplierProductsController@Supplier_productsWithSoftDelete');
Route::get('v2/supply_products/softdeleted','SupplierProductsController@softDeleted');
Route::patch('/v1/supply_products/restore/{id}','SupplierProductsController@restore');
Route::delete('v1/supply_products/{id}','SupplierProductsController@permanentDeleteSoftDeleted');

//orders routes

Route::post('/v1/orders', 'OrdersController@create');
Route::put('/v1/orders/{id}', 'OrdersController@create');
Route::get('/v1/orders', 'OrdersController@allOrders');
Route::get('/v1/orders/{id}', 'OrdersController@getOneOrder');
Route::delete('v1/orders/delete/{id}', 'OrdersController@permanentDelete'); //this on first permanent 
Route::delete('v1/orders/soft/{id}', 'OrdersController@softDelete');
Route::get('v2/orders/withsoftdelete','OrdersController@suppliersWithSoftDelete');
Route::get('v2/orders/softdeleted','OrdersController@softDeleted');
Route::patch('/v1/orders/restore/{id}','OrdersController@restore');
Route::delete('v1/orders/{id}','OrdersController@permanentDeleteSoftDeleted');

// Products Routes

Route::post('/v1/products', 'ProductsController@create');
Route::put('/v1/products/{id}', 'ProductsController@create');
Route::get('/v1/products', 'ProductsController@allProducts');
Route::get('/v1/products/{id}', 'ProductsController@oneProduct');
Route::delete('v1/products/delete/{id}', 'ProductsController@permanentDelete'); //this on first permanent 
Route::delete('v1/products/soft/{id}', 'ProductsController@softDelete');
Route::get('v2/products/withsoftdelete','ProductsController@suppliersWithSoftDelete');
Route::get('v2/products/softdeleted','ProductsController@softDeleted');
Route::patch('/v1/products/restore/{id}','ProductsController@restore');
Route::delete('v1/products/{id}','ProductsController@permanentDeleteSoftDeleted');

//Order details controller

Route::post('/v1/order_details', 'OrderDetailsController@create');
Route::put('/v1/order_details/{id}', 'OrderDetailsController@create');
Route::get('/v1/order_details', 'OrderDetailsController@allOrder_details');
Route::get('/v1/order_details/{id}', 'OrderDetailsController@oneProduct');
Route::delete('v1/order_details/delete/{id}', 'OrderDetailsController@permanentDelete'); //this on first permanent 
Route::delete('v1/order_details/soft/{id}', 'OrderDetailsController@softDelete');
Route::get('v2/order_details/withsoftdelete','OrderDetailsController@suppliersWithSoftDelete');
Route::get('v2/order_details/softdeleted','OrderDetailsController@softDeleted');
Route::patch('/v1/order_details/restore/{id}','OrderDetailsController@restore');
Route::delete('v1/order_details/{id}','OrderDetailsController@permanentDeleteSoftDeleted');

//Supply details 




