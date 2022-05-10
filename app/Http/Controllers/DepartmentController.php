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
            "data" => $order_department,
            "grouped" => $grouped,

        ]);;
    } 

    public function order_details($id){

        $order_details = Order_details::find($id);

        return   response()->json([       
            "data" => $order_details
        ]);
    }

    public function order_details_update(Request $request , $id){

    // dd($request->all());

        $order_details = Order_details::where( "id" ,$id)->updateOrCreate(['status'=> $request->status]);

        $order = Order::find( $order_details->order_id);


        // if order_details item one is preparing order status will set preparing 
        if($order->status == 'pending'){
            Order::where( "id" ,  $order_details->order_id )->update(['status'=>'preparing']);
            $table = Table::where( "id" , $order->table_id)->update(['status'=>'reversed']);
        }

        // check all order_detils is done order status will set done 
        $order_details1 = Order_details::where( "order_id" ,$order->id)->get();
        $a =array('done' , 'canceled') ;
        $check = 0 ;
        // dd($order_details1[1]->status);
        for($i=0 ; $i < $order_details1->count() ; $i++){
            if($order_details1[$i]->status == 'done'){
                // dd('s');
                array_push( $a  , $check++);
                // $check++ ;
            }
            else{
                array_push( $a , $check++);
                // $check--;
            }

        }

        
        if( $check == $order_details1->count()){
            Order::where( "id" ,  $order_details->order_id )->updateOrCreate(['status'=>'done']);

        }
        dd($check );

        return $order_details ; 
    }
}
