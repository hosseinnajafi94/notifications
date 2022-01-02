<?php
namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller {
    /**
     * User Login
     * @OA\Post(
     *     path="/api/login",
     *     @OA\Parameter(
     *          name="username",
     *          description="Username",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              default="superadmin",
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              default="superadmin",
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success: Login Successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(
     *                  property="profile",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer"),
     *                  @OA\Property(property="fname", type="string"),
     *                  @OA\Property(property="lname", type="string"),
     *                  @OA\Property(property="username", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="email_verified_at", type="string"),
     *             ),
     *             @OA\Property(
     *                  property="permissions",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer"),
     *                      @OA\Property(property="name", type="string"),
     *                  )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Error: Unauthorized, Wrong Username or Password",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation Error: Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(property="username", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="password", type="array", @OA\Items(type="string")),
     *             ),
     *         )
     *     ),
     * )
     */
    public function login(Request $request) {
        $validated = $request->validate([
            'username' => 'required|string|max:255|exists:App\Models\User,username',
            'password' => 'required|string|max:255',
        ]);

        $user = User::with('permissions')->where('username', '=', $validated['username'])->first();
        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json(['error' => 'wrong password'], 401);
        }

        $token       = auth()->login($user);
        $permissions = Arr::pull($user, 'permissions');

        $response = [
            'token'       => $token,
            'profile'     => $user,
            'permissions' => $permissions,
        ];
        return response()->json($response, 200);
    }
    /**
     * User Logout
     * @OA\Post(
     *     path="/api/logout",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *          response="204",
     *          description="Success: Logout Successful",
     *          @OA\JsonContent(
     *          )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Error: Unauthorized, Wrong Token",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     * )
     */
    public function logout() {
        auth()->logout();
        return response()->json(null, 204);
    }
}
//$token = auth()->attempt($validated);
//if (!$token) {
//    return response()->json(['message' => 'Unauthorized'], 401);
//}
//$token = auth()->refresh();
//$user  = auth()->user();