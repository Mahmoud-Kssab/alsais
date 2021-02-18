<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{

    public function index(Request $request){
        if(auth('users')->user()){
            return redirect()->to('qr/show');
        }
        else {
            return view('welcome');
        }
    }

    public function create(Request $request){
        $request->validate([
            'address' => ['nullable', 'string'],
            'email' => ['required', 'email', Rule::unique('users', 'email'), 'string'],
            'job' => ['nullable', 'string'],
            'name' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:7', 'string'],
            'phone' => ['required', Rule::unique('users', 'phone'), 'string'],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->job = $request->job;
        $user->password = bcrypt($request->password);
        $user->uuid = uniqid('qr-');
        $user->save();

        if(auth('users')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], 1)){
            if ($request->ajax()) {
                return ['redirect' => url('qr/show'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
            }

            return redirect('qr/show');
        }
        else {
            if ($request->ajax()) {
                return ['redirect' => url('/'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
            }
        }
    }

    public function qr(Request $request){
        return view('qr');
    }

    public function logout(){
        auth('users')->logout();
        return redirect('/login');
    }

    public function login(Request $request){
        if(auth('users')->user()){
            return redirect()->to('qr/show');
        }
        else {
            return view('login');
        }
    }

    public function check(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(auth('users')->attempt([
            "email" => $request->email,
            "password" => $request->password,
        ], 1)){

            if(auth('users')->user()->activated){
                if ($request->ajax()) {
                    return ['success'=>true,'redirect' => url('qr/show'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
                }

                return redirect('qr/show');
            }
            else {
                auth('users')->logout();
                return response()->json(['success'=>false, 'message'=>__(':( Sorry! Your Account Has Been Blocked')], 403);
            }


        }
        else {
            return response()->json(['success'=>false, 'message'=>__('User Name Or Password Not Found!')], 403);
        }
    }

    public function uuid($uuid){
        $checkIfExist = User::where('uuid', $uuid)->first();
        if($checkIfExist){
            return view('request', ['user' => $checkIfExist]);
        }
        else {
            return redirect()->to('qr/show');
        }

    }

    public function update(Request $request){
        $user = User::find(auth('users')->user()->id);
        if($user){
            if($user->public){
                $user->public = 0;
                $user->save();
            }
            else {
                $user->public = 1;
                $user->save();
            }
        }

        if($user->public){
            toast(__('You Are In Public Now'), 'success');
        }
        else {
            toast(__('You Are In Private Now'), 'success');
        }

        return back();
    }

    public function updateId(Request $request, $id){
        $findRequset = \App\Models\Request::find($id);
        if($findRequset){
            $findRequset->activated = $request->activated;
            $findRequset->save();

            if ($request->ajax()) {
                return ['redirect' => url('admin/requests'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
            }
        }

        return back();
    }

    public function send(Request $request){
        $request->validate([
            'message' => 'required|string',
            'user' => 'required'
        ]);

        if($request->user == auth('users')->user()->id){
            toast(__('You Can Not Send Request To Your Self'), 'error');
            return back();
        }
        else {
            $send = new \App\Models\Request();
            $send->user_id =$request->user;
            $send->sender_id = auth('users')->user()->id;
            $send->message = $request->message;
            $send->save();

            $from = User::find(auth('users')->user()->id);
            $user = User::find($request->user);
            if($user && $from){
                $user->notify(new NewRequest($from));
            }

            toast(__('Your Request Has Been Send Success'), 'success');
            return redirect()->to('qr/show');
        }


    }

    public function my(Request $request){
        $myRequests = \App\Models\Request::where('sender_id', auth('users')->user()->id)->orderBy('created_at', 'desc')->get();
        foreach ($myRequests as $item){
            $item->sender_id = User::find($item->sender_id);
            $item->user_id = User::find($item->user_id);
        }
        $data = $this->paginate($myRequests);
        if($request->ajax()){
            return ['data'=>$data];
        }
        return view('qr', ['data'=>$data]);
    }

    public function other(Request $request){
        $otherRequests = \App\Models\Request::where('user_id', auth('users')->user()->id)->orderBy('created_at', 'desc')->get();
        foreach ($otherRequests as $item){
            $item->sender_id = User::find($item->sender_id);
            $item->user_id = User::find($item->user_id);
        }
        $other = $this->paginate($otherRequests);
        if($request->ajax()){
            return ['other' => $other];
        }
        return view('qr', ['other'=>$other]);
    }
}
