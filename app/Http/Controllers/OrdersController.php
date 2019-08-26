<?php

namespace App\Http\Controllers;

use App\Orders;
use Illuminate\Http\Request;
use Validator;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['allOrders']);
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
            'order_number' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data'] = $validator->messages();
            return $response;
        }
        $orders = $request->isMethod('put') ? Orders::find($request->id) : new Orders;
        $orders->order_number = $request->order_number;
        $orders->save();
        $response = $this->successfulMessage(201, 'Successfully created', true, $orders->count(), $orders);
        return response($response);

    }
    //return those which are not deleted
    public function allOrders()
    {

        $orders = Orders::all();
        $response = $this->successfulMessage(200, 'Successfully', true, $orders->count(), $orders);

        return response($response);
    }

    public function getOneOrder($id){
        $orders = Orders::find($id);
        if($orders){
            $response = $this->successfulMessage(200, 'Successfully', true, $orders->count(), $orders);
            return response($response);
        }else{
            $response = $this->notFoundMessage();
            return response($response);
        }
        
    }

    //first permanent delete

    public function permanentDelete($id)
    {

        $orders = Orders::destroy($id);
        if ($orders) {

            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $orders);

        } else {

            $response = $this->notFoundMessage();
        }

        return response($response);
    }

    public function softDelete($id)
    {

        $orders = Orders::destroy($id);
        if ($orders) {
            $response = $this->successfulMessage(200, 'Successfully deleted', true,0, $orders);
        } else {

            $response = $this->notFoundMessage();

        }
        return response($response);
    }
    //returns both non-deleted and softdeleted
    public function ordersWithSoftDelete()
    {

        $orders = Orders::withTrashed()->get();
        $response = $this->successfulMessage(200, 'Successfully', true, $orders->count(), $orders);
        return response($response);

    }

    public function softDeleted()
    {
        $orders = Orders::onlyTrashed()->get();

        $response = $this->successfulMessage(200, 'Successfully', true, $orders->count(), $orders);
        return response($response);
    }

    public function restore($id)
    {

        $orders = Orders::onlyTrashed()->find($id);

        if (!is_null($orders)) {

            $orders->restore();
            $response = $this->successfulMessage(200, 'Successfully restored', true, $orders->count(), $orders);
        } else {

            return response($response);
        }
        return response($response);
    }

    public function permanentDeleteSoftDeleted($id)
    {
        $orders = Orders::onlyTrashed()->find($id);

        if (!is_null($orders)) {

            $orders->forceDelete();
            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $orders);
        } else {

            return response($response);
        }
        return response($response);
    }
}
