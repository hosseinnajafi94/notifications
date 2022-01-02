<?php
namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\UsersPermissions;
use App\Models\User;
class UsersController extends Controller {
    /**
     * Users List
     * @OA\Get(
     *     path="/api/users",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="page",
     *          description="Page",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *         response=206,
     *         description="Success: Partial Content",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer"),
     *                      @OA\Property(property="fname", type="string"),
     *                      @OA\Property(property="lname", type="string"),
     *                      @OA\Property(property="username", type="string"),
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="email_verified_at", type="string"),
     *                  )
     *             ),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(
     *                  property="links",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="url", type="string"),
     *                      @OA\Property(property="label", type="string"),
     *                      @OA\Property(property="active", type="boolean"),
     *                  )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Error: Unauthorized, Wrong Token",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Error: Forbidden, Access Denied",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     * )
     * title='لیست کاربران'
     * action='index'
     */
    public function index() {
        $models = User::paginate(10);
        return response()->json($models, 206);
    }
    /**
     * User Create
     * @OA\Post(
     *     path="/api/users",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="fname",
     *          description="First Name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="lname",
     *          description="Last Name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="username",
     *          description="Username",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          description="Email",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="permissions[]",
     *          description="Permissions",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(type="integer")
     *          )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success: Created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="fname", type="string"),
     *             @OA\Property(property="lname", type="string"),
     *             @OA\Property(property="username", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="email_verified_at", type="string"),
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
     *         response=401,
     *         description="Error: Unauthorized, Wrong Token",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Error: Forbidden, Access Denied",
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
     *                  @OA\Property(property="fname", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="lname", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="username", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="password", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="email", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="permissions", type="array", @OA\Items(type="string")),
     *             ),
     *         )
     *     ),
     * )
     * title='ثبت کاربر جدید'
     * action='store'
     */
    public function store(Request $request) {
        $model     = new User();
        $validated = $model->validate($request);

        $permissions = Arr::pull($validated, 'permissions', []);

        $data = $model->create($validated);

        foreach ($permissions as $permission) {
            UsersPermissions::create([
                'user_id'       => $data['id'],
                'permission_id' => $permission
            ]);
        }

        $output = User::with('permissions')->find($data['id']);
        return response()->json($output, 201);
    }
    /**
     * User Details
     * @OA\Get(
     *     path="/api/users/{id}",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success: OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="fname", type="string"),
     *             @OA\Property(property="lname", type="string"),
     *             @OA\Property(property="username", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="email_verified_at", type="string"),
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
     *         response=401,
     *         description="Error: Unauthorized, Wrong Token",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Error: Forbidden, Access Denied",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Error: Not Found",
     *         @OA\JsonContent(
     *         )
     *     ),
     * )
     * title='جزئیات کاربر'
     * action='show'
     */
    public function show($id) {
        $model = User::with('permissions')->findOrFail($id);
        return response()->json($model, 200);
    }
    /**
     * User Update
     * @OA\Put(
     *     path="/api/users/{id}",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="fname",
     *          description="First Name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="lname",
     *          description="Last Name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="username",
     *          description="Username",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          description="Email",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="permissions[]",
     *          description="Permissions",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(type="integer")
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success: OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="fname", type="string"),
     *             @OA\Property(property="lname", type="string"),
     *             @OA\Property(property="username", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="email_verified_at", type="string"),
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
     *         response=401,
     *         description="Error: Unauthorized, Wrong Token",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Error: Forbidden, Access Denied",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Error: Not Found",
     *         @OA\JsonContent(
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
     *                  @OA\Property(property="fname", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="lname", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="username", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="password", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="email", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="permissions", type="array", @OA\Items(type="string")),
     *             ),
     *         )
     *     ),
     * )
     * title='ویرایش کاربر'
     * action='update'
     */
    public function update(Request $request, $id) {
        $model     = User::findOrFail($id);
        $validated = $model->validate($request);

        $permissions = Arr::pull($validated, 'permissions', []);

        $model->update($validated);

        UsersPermissions::whereRaw('user_id=?', [$model->id])->delete();
        foreach ($permissions as $permission) {
            UsersPermissions::create([
                'user_id'       => $model->id,
                'permission_id' => $permission
            ]);
        }

        $output = User::with('permissions')->find($model->id);
        return response()->json($output, 201);
    }
    /**
     * User Delete
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Success: No Content",
     *         @OA\JsonContent(
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Error: Unauthorized, Wrong Token",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Error: Forbidden, Access Denied",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Error: Not Found",
     *         @OA\JsonContent(
     *         )
     *     ),
     * )
     * title='حذف کاربر'
     * action='destroy'
     */
    public function destroy($id) {
        User::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}