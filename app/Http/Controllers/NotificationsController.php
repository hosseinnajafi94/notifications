<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Notifications;
class NotificationsController extends Controller {
    /**
     * Notifications List
     * @OA\Get(
     *     path="/api/notifications",
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
     *                      @OA\Property(property="category_id", type="integer"),
     *                      @OA\Property(property="title", type="string"),
     *                      @OA\Property(property="description", type="string"),
     *                      @OA\Property(property="file", type="string"),
     *                      @OA\Property(property="exp_time", type="string"),
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
     * title='لیست اطلاعیه ها'
     * action='index'
     */
    public function index() {
        $models = Notifications::paginate(10);
        return response()->json($models, 206);
    }
    /**
     * Notification Create
     * @OA\Post(
     *     path="/api/notifications",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="category_id",
     *          description="Category ID",
     *          required=true,
     *          in="query",
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
     *     @OA\Parameter(
     *          name="description",
     *          description="Description",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="exp_time",
     *          description="Expiration date",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              default="2021-12-31 02:30:00",
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="file",
     *                     description="File",
     *                     type="file",
     *                ),
     *                 required={"file"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success: Created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="file", type="string"),
     *             @OA\Property(property="exp_time", type="string"),
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
     *                  @OA\Property(property="category_id", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="title", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="description", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="file", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="exp_time", type="array", @OA\Items(type="string")),
     *             ),
     *         )
     *     ),
     * )
     * title='ثبت اطلاعیه جدید'
     * action='store'
     */
    public function store(Request $request) {
        $model = new Notifications();
        $validated = $model->validate($request);
        $data = $model->create($validated);
        return response()->json($data, 201);
    }
    /**
     * Notification Details
     * @OA\Get(
     *     path="/api/notifications/{id}",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="Notification ID",
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
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="file", type="string"),
     *             @OA\Property(property="exp_time", type="string"),
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
     * title='جزئیات اطلاعیه'
     * action='show'
     */
    public function show($id) {
        $model = Notifications::findOrFail($id);
        return response()->json($model, 200);
    }
    /**
     * Notification Update
     * @OA\Put(
     *     path="/api/notifications/{id}",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="Notification ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="category_id",
     *          description="Category ID",
     *          required=true,
     *          in="query",
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
     *     @OA\Parameter(
     *          name="description",
     *          description="Description",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="exp_time",
     *          description="Expiration date",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              default="2021-12-31 02:30:00",
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="file",
     *                     description="File",
     *                     type="file",
     *                ),
     *                 required={"file"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success: OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="file", type="string"),
     *             @OA\Property(property="exp_time", type="string"),
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
     *                  @OA\Property(property="category_id", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="title", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="description", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="file", type="array", @OA\Items(type="string")),
     *                  @OA\Property(property="exp_time", type="array", @OA\Items(type="string")),
     *             ),
     *         )
     *     ),
     * )
     * title='ویرایش اطلاعیه'
     * action='update'
     */
    public function update(Request $request, $id) {
        $model     = Notifications::findOrFail($id);
        $validated = $model->validate($request);
        $model->update($validated);
        return response()->json($model, 200);
    }
    /**
     * Notification Delete
     * @OA\Delete(
     *     path="/api/notifications/{id}",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="Notification ID",
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
     * title='حذف اطلاعیه'
     * action='destroy'
     */
    public function destroy($id) {
        Notifications::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}