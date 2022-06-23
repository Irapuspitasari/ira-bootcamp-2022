<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Repositories\Customers;
use Hash;


class AuthController extends Controller
{
    public function getLogin(){
        return view('front.login');
    }
    public function postLogin(Request $request){
        $validator = validator::make($request->all(),
        [
            'email' => 'required|email',
            'password' => 'min:6|required',
        ]);
        if ($validator->fails()){
            $message = $validator->errors()->all();
            return redirect()->back()->with('danger', implade(',' , $message));

        }
        $customers = Customers::findBy('email', $request->email);

        if($customers->id == null) {
            return redirect()->back()->with('danger', 'Customers not found');


        }
        if(!Hash::check($request->password, $customers->password)){
            return redirect()->back()->with('danger', 'wrong password');
        }

        storeCustSession($customers);
        return redirect('/')->with('succes','welcome back!' .$customers->name);
    }
    public function postLogout(Request $request){
        session()->forget('customers');
        return redirect('login')->with(['succes' => 'success Logout']);
        
    }
}