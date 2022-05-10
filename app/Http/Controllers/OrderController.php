<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use DB;


use App\Models\Item;
use App\Models\Category;
use App\Models\Table;
use App\Models\Order_details;
use App\Models\Order;
Use \Carbon\Carbon;

use Auth;

class OrderController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //// store Order  Q: 3-a
    public function store( OrderRequest $request)
    {

        try {
            $checkTable = Table::where('status', 'available')->select('id')->first();
            if ($checkTable != null) {

                DB::beginTransaction();

                $newOrder = new Order();
                $newOrder->table_id = $checkTable->id;

                $newOrder->order_date = Carbon::now();
                $newOrder->user_id = Auth::user()->id;
                $newOrder->customer = $request->customer;
                $newOrder->print_count = $request->print_count;
                $newOrder->status = 'reserved';


                if (isset($request->payment_method)) {
                    $newOrder->payment_method = $request->payment_method;
                    $newOrder->payment_state = 1;
                    $newOrder->status = 'paid';
                }

                if (isset($request->notes)) {
                    $newOrder->notes = $request->notes;
                }
                if (isset($request->client_name)) {
                    $newOrder->client_name = $request->client_name;
                }


                $newOrder->save();


                foreach ($request->item as $items) {


                    $item = Item::find($items['id']);
                    $orderDetails2 = new Order_details();

                    $orderDetails2->order_id = $newOrder->id;
                    $orderDetails2->item_id = $items['id'];
                    
                    $orderDetails2->total_price = ($item->sell_price) * $items['count'];
                    $orderDetails2->count = $items['count'];
                    if (isset($items['notes'])) {
                        $orderDetails2->notes = $items['notes'];
                    }

                    $orderDetails2->save();
                }

                $newOrder->settotal_priceAttribute($newOrder->id);
                $newOrder->setconsumption_taxsAttribute();
                $newOrder->setlocal_adminstrationAttribute();
                $newOrder->setrebuild_taxAttribute();
                $newOrder->settotal_after_taxesAttribute();
                $newOrder->settaxesAttribute();
                $newOrder->save();

                $checkTable->status = 'reversed';
                $checkTable->save();

                DB::commit();

                return response()->json([
                    "message" => "order Add"
                ]);
            } else {
                return response()->json([
                    "message" => "No Table Availabe"
                ]);
            }
        }catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                "message" => "Error"
            ]);
        }



    }


    //// get Order Details Q: 3-c 

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
}
