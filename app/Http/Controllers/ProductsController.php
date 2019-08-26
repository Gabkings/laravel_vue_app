<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;
use Validator;

class ProductsController extends Controller
{
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
            'name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data'] = $validator->messages();
            return $response;
        }
        $products = $request->isMethod('put') ? Products::findOrFail($request->id) : new Products;
        $products->name = $request->name;
        $products->description = $request->description;
        $products->quantity = $request->quantity;
        $products->save();
        $response = $this->successfulMessage(201, 'Successfully created', true, $products->count(), $products);
        return response($response);

    }
    //return those which are not deleted
    public function allProducts()
    {

        $products = Products::all();
        if($products->count() > 0){
            $response = $this->successfulMessage(200, 'Successfully', true, $products->count(), $products);
            return response($response);            
        }else{
            $response = $this->notFoundMessage();

            return response($response);
        }

    }

    public function oneProduct($id){
        $products = Products::find($id);
        if($products){
            $response = $this->successfulMessage(200, 'Successfully', true, $products->count(), $products);
            return response($response);
        }else{
            $response = $this->notFoundMessage();
            return response($response);
        }
        
    }

    //first permanent delete

    public function permanentDelete($id)
    {

        $products = Products::destroy($id);
        if ($products) {

            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $products);

        } else {

            $response = $this->notFoundMessage();
        }

        return response($response);
    }

    public function softDelete($id)
    {

        $products = Products::destroy($id);
        if ($products) {
            $response = $this->successfulMessage(200, 'Successfully deleted', true,0, $products);
        } else {

            $response = $this->notFoundMessage();

        }
        return response($response);
    }
    //returns both non-deleted and softdeleted
    public function ProductsWithSoftDelete()
    {

        $products = Products::withTrashed()->get();
        $response = $this->successfulMessage(200, 'Successfully', true, $products->count(), $products);
        return response($response);

    }

    public function softDeleted()
    {
        $products = Products::onlyTrashed()->get();

        $response = $this->successfulMessage(200, 'Successfully', true, $products->count(), $products);
        return response($response);
    }

    public function restore($id)
    {

        $products = Products::onlyTrashed()->find($id);

        if (!is_null($products)) {

            $products->restore();
            $response = $this->successfulMessage(200, 'Successfully restored', true, $products->count(), $products);
        } else {

            return response($response);
        }
        return response($response);
    }

    public function permanentDeleteSoftDeleted($id)
    {
        $products = Products::onlyTrashed()->find($id);

        if (!is_null($products)) {

            $products->forceDelete();
            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $products);
        } else {

            return response($response);
        }
        return response($response);
    }
}
