<?php

namespace App\Http\Controllers;
use App\Models\Friends;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

class FriendsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    
    //rerurn all customers from mysql table
    public function all() {
        return Friends::all();
    }
    public function getById($id)
    {
        return Friends::findOrFail($id);
    }
    public function createFriend(Request $request)
    {
        $response = array();
        $parameters = $request->all();
        $rules =  array(
            'name'    => 'required'
        );
        $friend_name = $parameters['name'];
 
        $messages = array(
            'name.required' => 'name is required.'
        );
 
        $validator = \Illuminate\Support\Facades\Validator::make(array('name' => $friend_name), $rules, $messages);
        if(!$validator->fails()) {
            $response = Friends::create($parameters);
            
            return response()->json($response, 201);
        } else {
         $errors = $validator->errors();
            return response()->json(["error" => 'Validation error(s) occurred', "message" =>$errors->all()], 400);
      }
    }
    public function updateFriend($id, Request $request)
    {
        $response = array();
        $parameters = $request->all();

        $rules =  array(
            'name'    => 'required'
        );
        $friend_name = $parameters['name'];
 
        $messages = array(
            'name.required' => 'name is required.'
        );
        $cust = Friends::findOrFail($id);
        if(empty($cust)) {
            return response()->json(["error" => 'Record not found!'], 400); 
        }

        $validator = \Illuminate\Support\Facades\Validator::make(array('name' => $friend_name), $rules, $messages);
        if(!$validator->fails()) {
            $response = $cust->update($parameters);
            
            return response()->json(['status' => $response, "message" => "Record has been updated successfully."], 200);
        } else {
         $errors = $validator->errors();
            return response()->json(["error" => 'Validation error(s) occurred', "message" =>$errors->all()], 400);
      }
      
    }
    public function deleteFriend($id)
    { 
        try {
            $resp = Friends::findOrFail($id)->delete();
            return response(['status' => $resp, "message" =>'Record has been deleted Successfully'], 200);
        } catch(ModelNotFoundException $e) {
            return response(['status' => 'error', "message" => $e->getMessage()], 200);
        }
        
    }
}