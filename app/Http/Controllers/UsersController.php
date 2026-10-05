<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * @api {post} /users/login Login
     * @apiName Login
     * @apiGroup User
     * @apiDescription Authenticates a user. All previous tokens of the user are revoked and a new one is issued.
     *
     * @apiBody {String} email User email address
     * @apiBody {String} password User password
     *
     * @apiSuccess {Object} user Authenticated user
     * @apiSuccess {Number} user.id User ID
     * @apiSuccess {String} user.name User name
     * @apiSuccess {String} user.email User email
     * @apiSuccess {String} user.token Plain text token, use it as `Authorization: Bearer <token>`
     *
     * @apiSuccessExample {json} Success:
     *     HTTP/1.1 200 OK
     *     {
     *       "user": {
     *         "id": 1,
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "token": "1|abc123..."
     *       }
     *     }
     *
     * @apiError (401) InvalidCredentials Wrong email or password.
     * @apiErrorExample {json} 401 Invalid credentials:
     *     HTTP/1.1 401 Unauthorized
     *     {
     *       "message": "Invalid email or password"
     *     }
     * @apiUse ValidationError
     */
    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password))
        {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }

        // revoke old tokens
        $user->tokens()->delete();

        // DB:
        // personal_access_tokens table: the tokens are stored here
        // personal_access_tokens.tokenable_id: the user who the token belongs to
        // abilities, name, expires_at, etc...

        $user->token = $user->createToken('access')->plainTextToken;
        // ablities can be set https://laravel.com/docs/11.x/sanctum#token-abilities
        // $token = $user->createToken('access', ['server:update']);

        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * @api {get} /users List users
     * @apiName GetUsers
     * @apiGroup User
     * @apiUse AuthRequired
     *
     * @apiSuccess {Object[]} users List of users
     * @apiSuccess {Number} users.id User ID
     * @apiSuccess {String} users.name User name
     * @apiSuccess {String} users.email User email
     *
     * @apiSuccessExample {json} Success:
     *     HTTP/1.1 200 OK
     *     {
     *       "users": [
     *         { "id": 1, "name": "John Doe", "email": "john@example.com" }
     *       ]
     *     }
     */
    public function index() {
        $users = User::all();
        return response()->json(['users' => $users]);
    }
}
