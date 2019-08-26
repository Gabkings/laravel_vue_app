<?php

namespace App\Http\Controllers;

use App\Supplier_products;
use Illuminate\Http\Request;
use Validator;
class SupplierProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['allSupplier_products']);
    }
    private function notFoundMessage()
    {
        return [
            'code' => 404,
            'message' => 'Note not found',
            'success' => false,
        ];
    }
    private function successfulMessage($code, $message, $status, $count, $payload)
    {
        return [
            'code' => $code,
            'message' => $message,
            'success' => $status,
            'count' => $count,
            'data' => $payload,
        ];
    }
 //create new article
    public function create(Request $request)
    {


        $rules = [
            'supply_id' => 'required|integer',
            'product_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data'] = $validator->messages();
            return $response;
        }
        $supplier_products = $request->isMethod('put') ? Supplier_products::findOrFail($request->id) : new Supplier_products;
        $supplier_products->supply_id = $request->supply_id;
        $supplier_products->product_id = $request->product_id;
        $supplier_products->save();
        $response = $this->successfulMessage(201, 'Successfully created', true, $supplier_products->count(), $supplier_products);
        return response($response);

    }
    //return those which are not deleted
    public function allSupplier_products()
    {

        $supplier_products = Supplier_products::all();
        if($supplier_products->count() > 0){
            $response = $this->successfulMessage(200, 'Successfully', true, $supplier_products->count(), $supplier_products);

            return response($response);            
        }else{
            $response = $this->notFoundMessage();

        return response($response);
        }


    }

    public function oneProduct($id){
        $supplier_products = Supplier_products::find($id);
        if($supplier_products){
            $response = $this->successfulMessage(200, 'Successfully', true, $supplier_products->count(), $supplier_products);
            return response($response);
        }else{
            $response = $this->notFoundMessage();
            return response($response);
        }
        
    }

    //first permanent delete

    public function permanentDelete($id)
    {

        $supplier_products = Supplier_products::destroy($id);
        if ($supplier_products) {

            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $supplier_products);

        } else {

            $response = $this->notFoundMessage();
        }

        return response($response);
    }

    public function softDelete($id)
    {

        $supplier_products = Supplier_products::destroy($id);
        if ($supplier_products) {
            $response = $this->successfulMessage(200, 'Successfully deleted', true,0, $supplier_products);
        } else {

            $response = $this->notFoundMessage();

        }
        return response($response);
    }
    //returns both non-deleted and softdeleted
    public function Supplier_productsWithSoftDelete()
    {

        $supplier_products = Supplier_products::withTrashed()->get();
        $response = $this->successfulMessage(200, 'Successfully', true, $supplier_products->count(), $supplier_products);
        return response($response);

    }

    public function softDeleted()
    {
        $supplier_products = Supplier_products::onlyTrashed()->get();

        $response = $this->successfulMessage(200, 'Successfully', true, $supplier_products->count(), $supplier_products);
        return response($response);
    }

    public function restore($id)
    {

        $supplier_products = Supplier_products::onlyTrashed()->find($id);

        if (!is_null($supplier_products)) {

            $supplier_products->restore();
            $response = $this->successfulMessage(200, 'Successfully restored', true, $supplier_products->count(), $supplier_products);
        } else {

            return response($response);
        }
        return response($response);
    }

    public function permanentDeleteSoftDeleted($id)
    {
        $supplier_products = Supplier_products::onlyTrashed()->find($id);

        if (!is_null($supplier_products)) {

            $supplier_products->forceDelete();
            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $supplier_products);
        } else {

            return response($response);
        }
        return response($response);
    }
}
