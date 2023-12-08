<?php  
 
namespace app\base_api;

use OpenApi\Annotations as OA; 

/*
 * 
 * @OA\Info(
 *     version="1.0.0",
 *     title="用户",
 *     description="快递接口",
 *     @OA\Contact(name="开发商")
 * )
 * @OA\Server(
 *     url="https://127.0.0.1:3001",
 *     description="API server"
 * ) 
 * @OA\Response(
 *     response="200",
 *     description="成功返回", 
 *     @OA\Schema(
 *          @OA\Property(
 *                  property="code",
 *                  type="number",
 *                  description="状态码"
 *           ),
 *           @OA\Property(
 *                  property="msg",
 *                  type="string",
 *                  description="错误提示"
 *           ),
 *            @OA\Property(
 *                  property="data",
 *                  type="array",
 *                  items={},
 *                  description="返回的数据"
 *           )
 *      )
 * )  
 */
class api{

}
