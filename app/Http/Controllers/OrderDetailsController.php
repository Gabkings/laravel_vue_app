<?php

namespace App\Http\Controllers;

use App\Order_details;
use Illuminate\Http\Request;
use Validator;

class OrderDetailsController extends Controller
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
            'order_id' => 'required|integer',
            'product_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data'] = $validator->messages();
            return $response;
        }
        $order_details = $request->isMethod('put') ? Order_details::find($request->id) : new Order_details;
        $order_details->order_id = $request->order_id;
        $order_details->product_id = $request->product_id;
        $order_details->save();
        $response = $this->successfulMessage(201, 'Successfully created', true, $order_details->count(), $order_details);
        return response($response);

    }
    //return those which are not deleted
    public function allOrder_details()
    {

        $order_details = Order_details::all();
        if($order_details->count() > 0){
            $response = $this->successfulMessage(200, 'Successfully', true, $order_details->count(), $order_details);

            return response($response);            
        }else{
            $response = $this->notFoundMessage();

        return response($response);
        }


    }

    public function getOneOrder($id){
        $order_details = Order_details::find($id);
        if($order_details){
            $response = $this->successfulMessage(200, 'Successfully', true, $order_details->count(), $order_details);
            return response($response);
        }else{
            $response = $this->notFoundMessage();
            return response($response);
        }
        
    }

    //first permanent delete

    public function permanentDelete($id)
    {

        $order_details = Order_details::destroy($id);
        if ($order_details) {

            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $order_details);

        } else {

            $response = $this->notFoundMessage();
        }

        return response($response);
    }

    public function softDelete($id)
    {

        $order_details = Order_details::destroy($id);
        if ($order_details) {
            $response = $this->successfulMessage(200, 'Successfully deleted', true,0, $order_details);
        } else {

            $response = $this->notFoundMessage();

        }
        return response($response);
    }
    //returns both non-deleted and softdeleted
    public function Order_detailsWithSoftDelete()
    {

        $order_details = Order_details::withTrashed()->get();
        $response = $this->successfulMessage(200, 'Successfully', true, $order_details->count(), $order_details);
        return response($response);

    }

    public function softDeleted()
    {
        $order_details = Order_details::onlyTrashed()->get();

        $response = $this->successfulMessage(200, 'Successfully', true, $order_details->count(), $order_details);
        return response($response);
    }

    public function restore($id)
    {

        $order_details = Order_details::onlyTrashed()->find($id);

        if (!is_null($order_details)) {

            $order_details->restore();
            $response = $this->successfulMessage(200, 'Successfully restored', true, $order_details->count(), $order_details);
        } else {

            return response($response);
        }
        return response($response);
    }

    public function permanentDeleteSoftDeleted($id)
    {
        $order_details = Order_details::onlyTrashed()->find($id);

        if (!is_null($order_details)) {

            $order_details->forceDelete();
            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $order_details);
        } else {

            return response($response);
        }
        return response($response);
    }
}
