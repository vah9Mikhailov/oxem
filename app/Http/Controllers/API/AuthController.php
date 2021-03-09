<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends RespController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed'
            ]);

        if ($validator->fails()){
            $this->getError('Ошибка валидации', $validator->errors());
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $success['token'] = $user->createToken('authtoken')->accessToken;
        $success['name'] = $user->name;
        return $this->getResponse($success,'Регистрация прошла успешно');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])){
            $user = Auth::user();
            $success['token'] = $user->createToken('authtoken')->accessToken;
            return $this->getResponse($success,'Вход выполнен');
        }else {
            return $this->getError('Неверные данные');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        $user = Auth::user()->token();
        $user->revoke();
        return $this->getResponse($user,'Вы вышли');

    }
}
