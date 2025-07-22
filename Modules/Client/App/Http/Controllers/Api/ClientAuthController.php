<?php

namespace Modules\Client\App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Client\DTO\ClientDto;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Client\App\Models\Client;
use Modules\Client\Service\ClientService;
use Modules\Client\App\resources\ClientResource;
use Modules\Client\App\Http\Requests\ClientLoginRequest;
use Modules\Client\App\Http\Requests\ClientVerifyRequest;
use Modules\Client\App\Http\Requests\ClientResendOtpRequest;
use Modules\Client\App\Http\Requests\ClientForgetPasswordRequest;
use Modules\Client\App\Http\Requests\ClientLoginOrRegisterRequest;


class ClientAuthController extends Controller
{
    protected $clientService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(ClientService $clientService)
    {
        $this->middleware('auth:client', ['except' => ['verifyOtp', 'loginOrRegister', 'resendOtp', 'forgetPassword', 'verifyForgetPassword', 'newPassword']]);
        $this->clientService = $clientService;

    }

    public function loginOrRegister(ClientLoginOrRegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $client = Client::where('phone', $request->phone)->first();
            if ($client) {
                $credentials = $request->validated();
                if (!$token = auth('client')->attempt($credentials)) {
                    return returnMessage(false, 'غير مصرح لك بالدخول', ['password' => 'كلمة المرور غير صحيحة'], 'created');
                }
                if (auth('client')->user()['is_active'] == 0) {
                    return returnMessage(false, 'العميل غير مفعل', null);
                }
                if ($request['fcm_token'] ?? null) {
                    auth('client')->user()->update(['fcm_token' => $request->fcm_token]);
                }
                DB::commit();
                return $this->respondWithToken($token);
            }
            $data = (new ClientDto($request))->dataFromRequest();
            $user = $this->clientService->create($data);
            DB::commit();
            return returnMessage(true, 'تم التسجيل بنجاح', null);
        } catch (\Exception $e) {
            DB::rollBack();
            return returnMessage(false, $e->getMessage(), null, 'server_error');
        }
    }


    public function verifyOtp(ClientVerifyRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $result = $this->clientService->verifyOtp($data);
            if ($result == false) {
                return returnMessage(false, 'الرمز غير صحيح', null, 'unprocessable_entity');
            }
            DB::commit();
            $token = auth('client')->login($result);
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            DB::rollBack();
            return returnMessage(false, $e->getMessage(), null, 'server_error');
        }
    }

    public function resendOtp(ClientResendOtpRequest $request, ClientService $clientService)
    {
        $data = $request->all();
        $client = $clientService->findBy('phone', $request['phone'])[0];
        // $verify_code = rand(1000, 9999);
        $verify_code = 9999;
        $clientService->update($client->id, ['verify_code' => $verify_code]);
        // $smsService = new SMSService();
        // $smsService->sendSMS($client->phone, $verify_code);
        return returnMessage(true, 'تم ارسال الرمز بنجاح', null);
    }
    public function forgetPassword(ClientForgetPasswordRequest $request, ClientService $clientService)
    {
        $data = $request->all();
        $client = $clientService->findBy('phone', $data['phone'])[0];
        // $verify_code = rand(1000, 9999);
        $verify_code = 9999;
        $clientService->update($client->id, ['verify_code' => $verify_code]);
        // $smsService = new SMSService();
        // $smsService->sendSMS($client->phone, $verify_code);
        return returnMessage(true, 'تم ارسال الرمز بنجاح', null);
    }

    public function verifyForgetPassword(ClientVerifyRequest $request, ClientService $clientService)
    {
        $data = $request->all();
        $client = $clientService->findBy('phone', $data['phone'])[0];
        if ($client && $client['verify_code'] == $data['otp']) {
            return returnMessage(true, 'الرمز صحيح');
        }
        return returnMessage(false, 'الرمز غير صحيح', null, 'unauthorized');
    }

    public function newPassword(ClientLoginRequest $request, ClientService $clientService)
    {
        $data = $request->all();
        $client = $clientService->findBy('phone', $data['phone'])[0];
        $clientService->update($client->id, ['password' => bcrypt($data['password'])]);
        return returnMessage(true, 'تم تعديل كلمة المرور بنجاح');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return returnMessage(true, 'بيانات العميل', new ClientResource(auth('client')->user()));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('client')->logout();
        return returnMessage(true, 'تم تسجيل الخروج بنجاح', null);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('client')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return returnMessage(true, 'تم تسجيل الدخول بنجاح', [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('client')->factory()->getTTL() * 60,
            'user' => new ClientResource(auth('client')->user()),
        ]);
    }

}
