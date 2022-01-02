<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Permissions;
use App\Models\UsersPermissions;
class CategoriesController extends Controller {
    /**
     * Categories List
     * @OA\Get(
     *     path="/api/categories",
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
     *                      @OA\Property(property="title", type="string"),
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
     * title='لیست دسته بندی ها'
     * action='index'
     */
    public function index() {
        $models = Categories::paginate(10);
        return response()->json($models, 206);
    }
    /**
     * Category Create
     * @OA\Post(
     *     path="/api/categories",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="title",
     *          description="Title",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success: Created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="title", type="string"),
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
     *                  @OA\Property(property="title", type="array", @OA\Items(type="string")),
     *             ),
     *         )
     *     ),
     * )
     * title='ثبت دسته بندی جدید'
     * action='store'
     */
    public function store(Request $request) {
        $model     = new Categories();
        $validated = $model->validate($request);
        $data      = $model->create($validated);

        Permissions::create([
            'name' => 'دسته بندی: ' . $data['title'],
            'slug' => 'nc_' . $data['id']
        ]);

        return response()->json($data, 201);
    }
    /**
     * Category Details
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="Category ID",
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
     *             @OA\Property(property="title", type="string"),
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
     * title='جزئیات دسته بندی'
     * action='show'
     */
    public function show($id) {
        $model = Categories::findOrFail($id);
        return response()->json($model, 200);
    }
    /**
     * Category Update
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="Category ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="title",
     *          description="Title",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success: OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="title", type="string"),
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
     *                  @OA\Property(property="title", type="array", @OA\Items(type="string")),
     *             ),
     *         )
     *     ),
     * )
     * title='ویرایش دسته بندی'
     * action='update'
     */
    public function update(Request $request, $id) {
        $model     = Categories::findOrFail($id);
        $validated = $model->validate($request);
        $model->update($validated);

        $permission = Permissions::where('slug', '=', 'nc_' . $model->id)->first();
        if ($permission === null) {
            Permissions::create([
                'name' => 'دسته بندی: ' . $model->title,
                'slug' => 'nc_' . $model->id
            ]);
        }
        else {
            $permission->update(['name' => 'دسته بندی: ' . $model->title]);
        }

        return response()->json($model, 200);
    }
    /**
     * Category Delete
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="Category ID",
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
     * title='حذف دسته بندی'
     * action='destroy'
     */
    public function destroy($id) {
        Categories::findOrFail($id)->delete();

        $permission = Permissions::where('slug', '=', 'nc_' . $id)->first();
        if ($permission !== null) {
            $permission->delete();
        }

        return response()->json(null, 204);
    }
    /**
     * Categories List Based on access
     * @OA\Get(
     *     path="/api/list-categories",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success: OK",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="integer"),
     *                  @OA\Property(property="title", type="string"),
     *             )
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
     * title='لیست دسته بندی ها بر اساس دسترسی'
     * action='list'
     */
    public function list() {
        $user_id = auth()->user()->id;

        $ids = [];
        UsersPermissions::leftJoin('permissions', function ($join) {
            $join->on('users_permissions.permission_id', '=', 'permissions.id');
        })->whereRaw("users_permissions.user_id = ? AND permissions.slug LIKE 'nc_%'", [$user_id])->get()->map(function ($model) use (&$ids) {
            $ids[] = str_replace('nc_', '', $model->slug);
        });

        $models = Categories::whereIn('id', $ids)->get();
        return response()->json($models, 200);
    }
}