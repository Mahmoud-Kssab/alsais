<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class MainController extends Controller
{

///////////////////////////// scan qr code  /////////////////////////////////////////

    public function scanQrCode(Request $request)
    {
        $qr_code = $request->uuid;
        $user = User::where('uuid', $qr_code)->first();

        if($user->public)
        {
            return responseapi(1, 'بيانات العميل', $user);
        }else
        {
            return responseapi(0,'لا يمكنك الاطلاع علي بيانات هذا المستخدم');
        }

    }


///////////////////////////// send requests  /////////////////////////////////////////

    public function sendRequest(Request $request)
    {

        $validator = validator()->make($request->all(), [

            'message' => 'required|string',
            'user_id' => 'required'
        ]);

        if($validator->fails())
        {
            return responseapi(0, $validator->errors()->first(), $validator->errors());
        }


        $req = \App\Models\Request::create([

            'user_id'         => $request->user_id,
            'sender_id'       => Auth::user()->id,
            'message'         => $request->message

        ]);


        if($req)
        {
            return responseapi(1, 'تم ارسال الرسالة بنجاح', $req);
        }else
        {
            return responseapi(0,'حدث خطأ');

        }

    }
///////////////////////////// active requests  /////////////////////////////////////////

    public function activeUserRequest(Request $request)
    {
        $req = \App\Models\Request::where('id', $request->request_id);
        $req->update([

            'activated' => 1
        ]);

        return responseapi(1, 'تم التفعيل');
    }


///////////////////////////// user requests  /////////////////////////////////////////

    public function userRequests(Request $request)
    {
        $req = \App\Models\Request::where('user_id', Auth::user()->id )
                                    ->where('activated', 0)->orderBy('created_at', 'desc')->get();


        if($requests)
        {
            return responseapi(1, 'جميع الرسايل', $req);

        }else
        {
            return responseapi(0,'لا توجد رسايل');

        }
    }

///////////////////////////// other requests  /////////////////////////////////////////

    public function otherRequests(Request $request)
    {
        $requests = \App\Models\Request::where('sender_id', Auth::user()->id )
                                        ->where('activated', 1)->orderBy('created_at', 'desc')->get();



        $user = User::select('name','phone')->where('id', $requests->first()->user_id)->first();


        $data = [

            'req'   => $requests,
            'user'  => $user
        ];

        if(count($requests))
        {
            return responseapi(1, ' الاوذنات الاخري', $data);

        }else
        {
            return responseapi(0,'لا توجد اذونات');

        }
    }

}
