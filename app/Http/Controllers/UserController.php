<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    function index(Request $req)
    {
        return view('/users');
    }

    public function fetchuser() {
    	
    	$users = User::all();
        
        //return $users;
        
    	return response()->json([
    		'users'=>$users,
    	]);
    }

    public function store(Request $req) {

   	
    	$validator = Validator::make($req->all(), [

    		'name' => 'required|max:191',
    		'email' => 'required|email|max:191',
    		'phone' => 'required|max:10',
            'password' => 'required|min:8',
    	]);

    	if($validator->fails()) 
    	{
    		return response()->json([
    			'status'=>400,
    			'errors'=>$validator->messages(),
    		]);
    	}
    	else
    	{
    		$user = new User;
    		$user->name = $req->input('name');
    		$user->email = $req->input('email');
    		$user->phone = $req->input('phone');
            $user->password = Hash::make($req->input('password'));

            if($req->hasFile('image'))
            {
                $file = $req->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/user/'.$filename);
                $user->profile_photo_path = $imageName;
            }

    		$user->save();

    		return response()->json([
    			'status'=>200,
    			'message'=>'User Added Successfully',
    		]);
    	}
    }

    public function edit($id) {
    	
    	$user = User::find($id);

    	if($user)
    	{
    		return response()->json([
	    		'status'=>200,
	    		'users'=>$user,
	    	]);
    	}
    	else
    	{
    		return response()->json([
    			'status'=>400,
	    		'message'=>'User Not Found',
	    	]);
    	}
    	
    	
    }


    public function update(Request $req, $id) {
    	
    	$validator = Validator::make($req->all(), [

    		'name' => 'required|max:191',
    		'email' => 'required|email|max:191',
    		'phone' => 'required|max:10',
    	]);

    	if($validator->fails()) 
    	{
    		return response()->json([
    			'status'=>400,
    			'errors'=>$validator->messages(),
    		]);
    	}
    	else
    	{
    		$user = User::find($id);
    		
    		if($user)
    		{
    			$user->name = $req->input('name');
	    		$user->email = $req->input('email');
	    		$user->phone = $req->input('phone');

				if($req->hasFile('image'))
				{
					$file = $req->file('image');
					$extension = $file->getClientOriginalExtension();
					$filename = time().'.'.$extension;
					$file->move('uploads/user/'.$filename);
					
				}
				$user->profile_photo_path = $req->input('image');
	    		$user->update();

	    		return response()->json([
	    			'status'=>200,
	    			'message'=>'User Updated Successfully',
	    		]);
    		}
    		else
    		{
    			return response()->json([
	    			'status'=>404,
	    			'message'=>'User Not Found',
	    		]);
    		}

    		
    	}
    }

     public function delete($id) {
		$user = User::find($id);
		$user->delete();

		return response()->json([
			'status'=>200,
			'message'=>'User Deleted Successfully',
		]);
     }
}
