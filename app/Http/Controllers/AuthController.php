<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Auth;
use App\Models\User;


class AuthController extends Controller
{

    ////////// start registration ///////////


    public function register(Request $request){
        // validation

        $validator=validator()->make($request->all(),[

            'name'=>'required',
            'phone'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed',
            'address' =>'required',
            'job'=>'required',

        ]);

        //
        if($validator->fails()){
            return responseapi(0,'fails',$validator->errors());
        }

        $request->merge(['password'=>bcrypt($request->password)]);
        $user=User::create($request->all());
        $user->uuid = uniqid('qr-');
        $user->api_token=str_random(60);
        $user->save();

        return responseapi(1,'suceess',[
           'api_token'=>$user->api_token,
            'user'=>$user,
        ]);
    }

    ////////// Ens registration ///////////



    ////////// start login ///////////

    public function login (Request $request)
    {
        //////// validation ////////////

        $validator = validator()->make($request->all(), [

            'email' => 'required',
            'password' => 'required',

        ]);

        /////////// is validation failed /////////////

        if ($validator->fails()) {
            return responseapi(0, 'هناك خطأ', $validator->errors());
        }


        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password,$user->password)) {

                return responseapi(1, 'sucess', [
                    'api_token' => $user->api_token,
                    'user' => $user,
                ]);



            }
            else {
                return responseapi('0', 'يرجي التأكد من كلمة المرور ثم المحاولة مرة اخري');
            }



        } else {
            return responseapi(0, 'لا يوجد حساب بهذا البريد');
        }
    }
    ////////// End login ///////////





  ////////////////////////////// start forgetPassword ///////////////


  public function forgetPassword(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'email'             =>'required',

    ]);

    if($validator->fails())
    {
      return responseapi(0, $validator->errors()->first(), $validator->errors());
    }

    $user = User::where('email',$request->email)->first();

    if($user)
    {
      $code = rand(111111,999999);
      $update = $user->update(['pin_code' => $code]);

      if($update)
      {
        Mail::to($user->email)
          ->bcc("mahmoud.kssab58@gmail.com")
          ->send(new ResetPassword($code));

        return responseapi(1, 'برجاء فحص الحساب', [
            'code' => $code,
            'email' => $user->email

        ]);
      }

      else
      {
        return responseapi(0, 'حدث خطأ حاول مرة أخرى');
      }

    }

    else
    {
      return responseapi(0, 'لايوجد حساب لهذا البريد');
    }

  }


  ////////////////////////////// end forgetPassword ///////////////

  ////////////////////////////// start changePassword ///////////////


  public function changePassword(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'pin_code'             =>'required',
      'password'             =>'required|confirmed',

    ]);

    if($validator->fails())
    {
      return responseapi(0, $validator->errors()->first(), $validator->errors());
    }

    $user = User::where('pin_code',$request->pin_code)->where('pin_code','!=',0)->first();

    if($user)
    {

      $user->password = bcrypt($request->password);
      $user->pin_code = null;

      if($user->save())
      {
        return responseapi(1, 'تم تغيير كلمة المرور بنجاح');
      }

      else
      {
        return responseapi(0, 'حدث خطأ حاول مرة أخرى');
      }
    }

    else
    {
      return responseapi(0, 'هذا الكود غير صالح');
    }

  }


    ////////// start profile service ///////////



    public function profile(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'email' => 'unique:users,email,'.$request->user()->id
        ]);

        if($validator->fails())
        {
            return responseapi(0, $validator->errors()->first(), $validator->errors());
        }


        $profile = $request->user();
        $profile->update($request->all());
        return responseapi(1,'success',$profile);
    }


    ////////// End profile service ///////////

}
