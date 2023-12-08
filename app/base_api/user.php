<?php  
 
namespace app\base_api;

use OpenApi\Annotations as OA; 
/** 
 * 
 * @OA\Tag(
 *     name="user",
 *     description="用户相关"
 * )
 */
class user
{
    /**
     * @OA\Post(
     *     tags={"user"},
     *     path="/base_api/user/index",
     *     description="获取用户列表",
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *           @OA\Property(property="id", type="string"), 
     *       )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="成功返回", 
     *     )
     * )
     */
    public function index()
    { 
        $id = g('id');
        return json_success(['id'=>$id]);
    }
}