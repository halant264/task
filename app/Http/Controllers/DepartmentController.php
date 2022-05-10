<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Itemsr;
use App\Models\Order_details;
use App\Models\Order;
use App\Models\Category;
use App\Models\Table;
use DB;

class DepartmentController extends Controller
{
    public function department($id){

            $dw = Department::with('categories' )->whereHas('categories' ,  function($ss){
                 $ss->with('items')->whereHas('items' ,  function($s1){
                    $s1->with('order_detailss')->whereHas('order_detailss' , function($s2){
                        $s2->where('order_id' , 66);
                    });
                 });
            })->where('id' , 1)->get();

            $order_department = DB::table('order_details')
            ->leftJoin('itemsr', 'itemsr.id' , 'item_id')
            ->leftJoin('categories', 'categories.id' , 'category_id')
            ->where('department_id' , $id )
            ->select('order_details.*' , 'itemsr.title')
            ->get();

            $grouped = $order_department->groupBy('order_id');


        return    response()->json([
            "order_for_department" => $grouped,
        ]);;
    }

    public function order_details($id){

        $order = Order::with('order_detailss')->where("id" ,$id )->get();

        if (!$order->isEmpty()){
            return   response()->json([
                "data" => $order
            ]);
        }

        return   response()->json([
            "data" => 'No Order Found'
        ]);
    }

    public function order_details_update(Request $request , $id){


        $order_details = Order_details::find( $id);
        $order_details->status =  $request->status;
        $order_details->save();



        $this->orderStatus($order_details->order_id);

        return   response()->json([
            "data" => 'Order Details Update'
        ]);
    }
    public function orderStatus( $id)
    {
        $order_de = Order_details::where("order_id", $id)
            ->groupBy('status')
            ->select(DB::raw('status , COUNT(*) as status_count'))
            ->get();
        $order_count = Order_details::where("order_id", $id)->count();
        $i1 = 10 ;
        $ii = 10 ;

        foreach ($order_de as $order_de1) {
            if ($order_de1->status== 'preparing') {
                $order_details = Order::where("id", $id)->update(['status' => 'preparing']);
                break;
            }else if ($order_de1->status == 'done') {
                $ii = 11 ;
            }
            elseif ($order_de1->status == 'pending') {
                $i1 = 11 ;
                }
            else {
                if ($order_de1->status_count  == $order_count) {
                    $order_details = Order::where("id", $id)->update(['status' => 'canceled']);
                }
            }
        }

        if ($i1 >=11  &  $ii>=11) {
            $order_detail = Order::where("id", $id)->update(['status' => 'preparing']);
        }
        elseif ($i1 <= 10  & $ii>=11){
           $order_detail =  Order::where("id", $id)->update(['status' => 'done']);
        }

        $order_des = Order::where( "id" , $id)->get();


        return $order_des ;
    }
}
