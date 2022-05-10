<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Models\Itemsr;
use App\Models\Category;
use App\Models\Table;
use App\Models\Order_details;
use App\Models\Order;
Use \Carbon\Carbon;

use Auth;

class OrderController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items= Category::with('items')->get();

        return $items;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkTable = Table::where('status' , 'available')->select('id')->first();
        if($checkTable != null){

            $newOrder = new Order(); 
            $newOrder->table_id = $checkTable->id;
            
            $newOrder->order_date = Carbon::now();

            if(isset($request->payment_method)){
                $newOrder -> payment_method =$request->payment_method;
                $newOrder -> payment_state = 1 ;
                $newOrder -> status = 'reserved' ;
            }

            if(isset($request->notes)){
                $newOrder -> notes =$request->notes;
            }
            if(isset($request->client_name)){
                $newOrder -> client_name =$request->client_name;
            }

            $newOrder -> user_id = Auth::user()->id ;
            $newOrder -> customer = $request->customer ;
            $newOrder -> print_count = $request->print_count ;
            $newOrder->save();


            foreach( $request->item as $items){
                $item = Itemsr::find($items['id']);
               
                $orderDetails2 = new Order_details(); 
                $orderDetails2->order_id = $newOrder->id;
                $orderDetails2->item_id  = $items['id'];
                $orderDetails2->	total_price = ($item -> sell_price)*$items['count'];
                $orderDetails2->	count =  $items['count'];
               
                $orderDetails2->save();  
            }

            $newOrder -> settotal_priceAttribute($newOrder->id) ;
            $newOrder -> setconsumption_taxsAttribute() ;
            $newOrder -> setlocal_adminstrationAttribute()  ;
            $newOrder -> setrebuild_taxAttribute() 	 ;
            $newOrder -> settotal_after_taxesAttribute()   ;
            $newOrder -> settaxesAttribute()  ;
            $newOrder->save();

            $checkTable->status = 'reversed';
            $checkTable->save();
        }
        else{
            return   response()->json([   
                "message" => "No Table Availabe"
            ]);
        }
        return   response()->json([       
            "message" => "order Add"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
