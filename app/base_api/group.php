<?php   
namespace app\base_api;

use OpenApi\Annotations as OA; 
/**
 *  
 * @OA\Tag(
 *     name="group",
 *     description="用户组"
 * )
 */
class group
{
    /**
     * @OA\Post(
     *     tags={"group"},
     *     path="/base_api/group/index",
     *     description="获取用户组列表",
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
        return json_success(['id'=>'group'.$id]);
    }
}