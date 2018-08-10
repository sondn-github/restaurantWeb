<?php

namespace App\Http\Controllers;

use App\eating;
use App\category;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class productController extends Controller
{
    public function showListProduct()
    {
        $eating = eating::all();
    	return $eating;
    }

    public function addProduct()
    {
        $categories = category::all();

    	// return view('admin.product.addProduct', ['categories' => $categories]);
        return $categories;
    }

    public function editProduct($id)
    {
        $eating = eating::find($id);
        $categories = category::all();
    	return response()->json(['eating' => $eating, 'categories' => $categories]);
    }

    public function addEating(Request $request)
    {
        $rules = [
            'txtName' => 'required|max:100|unique:eating,eatingName',
            'txtPrice' => 'required|numeric|min:0',
            'txtIntro' => 'required',
        ];

        $messages = [
            'txtName.required' => 'A eating\'name is required.',
            'txtName.max' => 'The max length is 100.',
            'txtName.unique' => 'The eating name is duplicated.',
            'txtPrice.required' => 'A eating\'price is required.',
            'txtPrice.numeric' => 'Price is a number.',
            'txtPrice.min' => 'Min price is 0.',
            'txtIntro.required' => 'A eating\'intro is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }
        $eating = new eating;

        $eating->eatingName = $request->txtName;
        $eating->cost = $request->txtPrice;
        $eating->description = $request->txtIntro;
        $eating->category_id = $request->cateId;
        $eating->save();
        return response([
            'result' => 'success'
        ], 200);
        // echo "Thanh cong";
    }

    public function updateEating(Request $request, $id)
    {
        $rules = [
            'txtName' => 'required|max:100',
            'txtPrice' => 'required|numeric|min:0',
            'txtIntro' => 'required',
        ];

        $messages = [
            'txtName.required' => 'A eating\'name is required.',
            'txtName.max' => 'The max length is 100.',
            'txtPrice.required' => 'A eating\'price is required.',
            'txtPrice.numeric' => 'Price is a number.',
            'txtPrice.min' => 'Min price is 0.',
            'txtIntro.required' => 'A eating\'intro is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $eating = eating::find($id);

        $eating->eatingName = $request->txtName;
        $eating->cost = $request->txtPrice;
        $eating->description = $request->txtIntro;
        $eating->category_id = $request->cateId;
        $eating->save();

        return response([
            'result' => 'success'
        ], 200);
    }

    public function deleteEating($id)
    {
        $eating = eating::findOrFail($id);

        $eating->delete();
        return response()->json(['result' => 'successed']);
    }
}
