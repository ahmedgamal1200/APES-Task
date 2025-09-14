<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Transformers\RegisterResource;
use Modules\Tenants\Models\Tenant;
use Spatie\Permission\Models\Role;
use Throwable;

class AuthController extends Controller
{
    /**
     * @throws Throwable
     */
    public function register(RegisterRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $tenant = Tenant::query()->create(['name' => $request->tenant_name]);

            $user = $tenant->users()->create($request->except('tenant_name'));

            $user->assignRole(Role::query()->firstOrCreate(['name' => 'admin']));

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User and Tenant registered successfully.',
                'user' => RegisterResource::make($user->load('tenant', 'roles')
                ),
                'token' => $token,
            ], 201);
        });
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
            'token' => $token,
        ]);
    }

}
