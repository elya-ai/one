<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Human;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class HumanController extends Controller
{
	public function get()
	{
		$humans = Human::get();
		return response()->json($humans);
	}

	public function register(Request $req)
	{
		 $validator = Validator::make($req->all(),
    		[
    			"name" => "required",
    			"login" => "required",
    			"password" => "required",
    		]);
    	if ($validator->fails())
    		return response()->json($validator->errors());

    	$arr = $req->all();
		$arr['password'] = Hash::make($req->password);

    	$humans = Human::create($arr);
    		return response()->json("Вы зарегистрированы!");
	}

	public function auth(Request $req)
	{
		$validator = Validator::make($req->all(),
    		[
    			"login" => "required",
    			"password" => "required",
    		]);
    	if ($validator->fails())
    		return response()->json($validator->errors());

    	if ($humans = Human::where('login', $req->login)->first())
    	{
    		if (Hash::check($req->password, $humans->password))
    		{
    			$humans->api_token = Str::random(50);
    			$humans->save();
    			return response()->json("Вы авторизованы!". $humans->api_token);
    		}
    	}
    	return response()->json("Попробуйте снова...");
	}

	public function check(Request $req)
	{
		return response()->json("Метод отработал");
	}

	public function ResetPassword(Request $req)
	{
		$rules = [
            'old_password' => 'required',
            'new_password' => 'required',
        ];

        $validator = Validator::make(
            $req->all(),
            $rules
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "secces" => false,
                    "message" => $validator->messages(),
                ]
            , 400);
        }	

		$token = $req->header('api_token');

		$humans = Human::where('api_token', $token)->first();

		$check = Hash::check(
			$req->old_password,
			$humans->password
		);

		if(!$check)
		{
			return response()->json([
    			"success" => false,
        		"message" => "Текущий пароль указан неверно."
			]
	        , 400);
		}

		$humans->password = Hash::make($req->new_password);

		if(!$humans->save())
        {
			return response()->json([
    			"success" => false,
        		"message" => "Произошла какая-то ошибка, попробуйте позже."
			]
	        , 500);	
        }

        return response()->json([
			"success" => true,
			"message" => "Пароль успешно изменен.",
        ], 200);
	}
}
