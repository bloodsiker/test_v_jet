<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecoverPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Company;
use App\Models\User;
use App\Traits\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ResetsPasswords;

    public function __construct()
    {
        $this->broker = 'users';
    }

    /**
     * @param  RegisterRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->only(['first_name', 'last_name', 'phone', 'email']);
            $data['password'] = Hash::make($request->input('password'));

            $user = new User();
            $user->fill($data);

            if ($user->save()) {
                $response = [
                    'code' => 201,
                    'message' => 'User created successfully',
                    'user' => $user,
                ];
            } else {
                $response = [
                    'code' => 500,
                    'message' => 'An error occured while creating user',
                ];
            }

        } catch (\Exception $e) {
            $response = [
                'code' => 500,
                'message' => 'An error occured while creating user',
            ];
        }

        return response()->json($response, $response['code']);
    }

    /**
     * @param  RecoverPasswordRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recoverPassword(RecoverPasswordRequest $request)
    {
        $status = $this->sendResetLinkEmail($request);

        if ($status) {
            $response = [
                'code' => 200,
                'message' => 'We have emailed your password reset link',
            ];
        } else {
            $response = [
                'code' => 500,
                'message' => 'Failed to send password reset link via email',
            ];
        }

        return response()->json($response, $response['code']);
    }

    /**
     * @param  ResetPasswordRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = $this->reset($request);

        if ($status) {
            $response = [
                'code' => 200,
                'message' => 'You have successfully changed your password',
            ];
        } else {
            $response = [
                'code' => 500,
                'message' => 'Failed to change password',
            ];
        }

        return response()->json($response, $response['code']);
    }

    /**
     * @param  LoginRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'code' => 401,
                'message' => 'User in not authorized'
            ], 401);
        }

        return response()->json([
            'code' => 200,
            'message' => 'User logged successfully',
            'token' => $this->respondWithToken($token),
        ], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompanies()
    {
        $companies = Auth::user()->companies()->orderByDesc('id')->get();

        return response()->json([
            'code' => 200,
            'companies' => $companies,
        ], 200);
    }

    /**
     * @param  CompanyStoreRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCompany(CompanyStoreRequest $request)
    {
        try {
            $company = new Company();
            $company->fill($request->all())->save();

            Auth::user()->companies()->attach($company);

            $response = [
                'code' => 201,
                'message' => 'Company created successfully',
                'company' => $company,
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => 500,
                'message' => 'An error occured while creating company',
            ];
        }

        return response()->json($response, $response['code']);
    }
}
