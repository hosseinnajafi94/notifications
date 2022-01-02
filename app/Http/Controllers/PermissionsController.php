<?php
namespace App\Http\Controllers;
use App\Models\Permissions;
class PermissionsController extends Controller {
    /**
     * Permissions List
     * @OA\Get(
     *     path="/api/list-permissions",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success: OK",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="integer"),
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="slug", type="string"),
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
     * title='لیست دسترسی ها'
     * action='list'
     */
    public function list() {
        $models = Permissions::get();
        return response()->json($models, 200);
    }
}