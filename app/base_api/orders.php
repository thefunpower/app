<?php   
namespace app\base_api;

use OpenApi\Annotations as OA; 
/**
 *  
 * @OA\Tag(
 *     name="orders",
 *     description="订单"
 * )
 */
class orders
{
    /**
     * @OA\Post(
     *     tags={"orders"},
     *     path="/base_api/orders/pager",
     *     description="订单分页",
     *     @OA\Parameter(
     *          name="order_num",
     *          description="订单号",
     *          required=false,
     *          in="query",
     *     ), 
     *     @OA\Parameter(
     *          name="wl_order_num",
     *          description="运单号",
     *          required=false,
     *          in="query",
     *     ),  
     *     @OA\Response(
     *         response="0",
     *         description="成功返回", 
     *         @OA\JsonContent(type="object",
     *            @OA\Examples(example="{code:0}", description="",value={"code":0,"msg":"成功","data":{}}),
     *         ) 
     *      )
     * )
     */
    public function pager()
    { 
        $where = [];
        $order_num = g('order_num');
        $wl_order_num = g('wl_order_num'); 
        if($order_num){
            $where['order_num[~]'] = $order_num;
        }
        if($wl_order_num){
            $where['wl_order_num[~]'] = $wl_order_num;
        } 
        $where['status[>]'] = 0;
        $all = db_pager("express_order","*",$where);
        $all['where'] = $where;
        return json($all);
    }
}