<?php

namespace App\Http\Controllers;

use App\Suppliers;
use Illuminate\Http\Request;
use Validator;

class SuppliersController extends Controller
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
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data'] = $validator->messages();
            return $response;
        }
        $suppliers = $request->isMethod('put') ? Suppliers::find($request->id) : new Suppliers;
        $suppliers->name = $request->name;
        $suppliers->save();
        $response = $this->successfulMessage(201, 'Successfully created', true, $suppliers->count(), $suppliers);
        return response($response);

    }
    //return those which are not deleted
    public function allSuppliers()
    {

        $suppliers = Suppliers::all();
        $response = $this->successfulMessage(200, 'Successfully', true, $suppliers->count(), $suppliers);

        return response($response);
    }

    public function getOneSupplier($id){
        $suppliers = Suppliers::find($id);
        $response = $this->successfulMessage(200, 'Successfully', true, $suppliers->count(), $suppliers);
        return response($response);
    }

    //first permanent delete

    public function permanentDelete($id)
    {

        $suppliers = Suppliers::destroy($id);
        if ($suppliers) {

            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $suppliers);

        } else {

            $response = $this->notFoundMessage();
        }

        return response($response);
    }

    public function softDelete($id)
    {

        $suppliers = Suppliers::destroy($id);
        if ($suppliers) {
            $response = $this->successfulMessage(200, 'Successfully deleted', true,0, $suppliers);
        } else {

            $response = $this->notFoundMessage();

        }
        return response($response);
    }
    //returns both non-deleted and softdeleted
    public function suppliersWithSoftDelete()
    {

        $suppliers = Suppliers::withTrashed()->get();
        $response = $this->successfulMessage(200, 'Successfully', true, $suppliers->count(), $suppliers);
        return response($response);

    }

    public function softDeleted()
    {
        $suppliers = Suppliers::onlyTrashed()->get();

        $response = $this->successfulMessage(200, 'Successfully', true, $suppliers->count(), $suppliers);
        return response($response);
    }

    public function restore($id)
    {

        $suppliers = Suppliers::onlyTrashed()->find($id);

        if (!is_null($suppliers)) {

            $suppliers->restore();
            $response = $this->successfulMessage(200, 'Successfully restored', true, $suppliers->count(), $suppliers);
        } else {

            return response($response);
        }
        return response($response);
    }

    public function permanentDeleteSoftDeleted($id)
    {
        $suppliers = Suppliers::onlyTrashed()->find($id);

        if (!is_null($suppliers)) {

            $suppliers->forceDelete();
            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $suppliers);
        } else {

            return response($response);
        }
        return response($response);
    }

}
