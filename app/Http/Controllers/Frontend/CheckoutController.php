<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\Address;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\SmsTemplate;
use App\Utility\SmsUtility;
use App\Utility\SendSMSUtility;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\ProductStock;
use App\Models\AccountHead;
use App\Models\AccountLedger;
use App\Http\Controllers\Frontend\PublicSslCommerzPaymentController;
use App\Models\Shipping;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!guest_checkout() && !auth()->check()){
            return redirect()->route('login');
        }
        $addresses = Address::where('status', 1)->get();
        $shippings = Shipping::where('status', 1)->get();

        $carts = Cart::content();
        $cartTotal = Cart::total();

        // dd($cartTotal);

        return view('frontend.checkout.index',compact('addresses','shippings', 'carts', 'cartTotal'));
    } // end method



    public function shippingAjax($shipping_id){
        $shipping = Shipping::find($shipping_id);
        return json_encode($shipping);
    }

    /* ============== Start GetCheckoutProduct Method ============= */
    public function getCheckoutProduct(){
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal,
        ));

    } //end method
    /* ============= End GetCheckoutProduct Method ============== */



    /* ============= Start getdivision Method ============== */
    public function getdivision($division_id){
        $division = District::where('division_id', $division_id)->orderBy('district_name_en','ASC')->get();

        return json_encode($division);
    }
    /* ============= End getdivision Method ============== */


    /* ============= Start getupazilla Method ============== */
    public function getupazilla($district_id){
        $upazilla = Upazilla::where('district_id', $district_id)->orderBy('name_en','ASC')->get();

        return json_encode($upazilla);
    }
    /* ============= End getupazilla Method ============== */



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
        $payment_info = json_decode(Session::get('payment_details'));
        $data = $request->validate([
            'name' => 'required|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'required|digits:11',
            'address' => 'required|max:10000',
            'payment_option'=>'required',
            'comment' => 'nullable|max:2000',
            'shipping_id' => 'required',
        ]);
        $carts = Cart::content();
        //dd($carts);

        if($carts->isEmpty()){
            $notification = array(
                'message' => 'Your cart is empty.',
                'alert-type' => 'error'
            );
            return redirect()->route('home')->with($notification);
        }

        // dd($request->all());
        if(Auth::check()){
            $user_id = Auth::id();
            $type = 1;
        }else{
            $user_id = 1;
            $type = 2;
        }

        if($request->payment_option == 'cod'){
            $payment_status = 'unpaid';
        }else{
            $payment_status = 'paid';
        }

        $invoice_data = Order::orderBy('id','desc')->first();
        if($invoice_data){
            $lastId = $invoice_data->id;
            $id = str_pad($lastId + 1, 2, 0, STR_PAD_LEFT);
            $invoice_no = $id;
        }else{
            $invoice_no = "01";
        }

        // order add //
        $order = Order::create([
            'user_id' => $user_id,
            'name' => $request->name,
            'sub_total' => $request->sub_total,
            'grand_total' => $request->grand_total,
            'shipping_charge' => $request->shipping_charge,
            'shipping_name' => $request->shipping_name,
            'shipping_type' => $request->shipping_type,
            'payment_method' => $request->payment_option,
            'payment_status' => $payment_status,
            'invoice_no' => $invoice_no,
            'delivery_status' => 'pending',
            'phone' => $request->phone,
            'email' => $request->email,
            'division_id' => $request->division_id ?? 0,
            'district_id' => $request->district_id ?? 0,
            'upazilla_id' => $request->upazilla_id ?? 0,
            'address' => $request->address,
            'comment' => $request->comment,
            'trxID' =>$payment_info->trxID ?? NULL,
            'type' => $type,
            //'created_by' => Auth::guard('admin')->user()->id,
        ]);

        if(get_setting('otp_system')){
            $sms_template = SmsTemplate::where('name','order_message')->where('status',1)->first();
            if($sms_template){
                $sms_body       = $sms_template->body;
                $sms_body       = str_replace('[[order_code]]', $order->invoice_no, $sms_body);
                $sms_body       = str_replace('[[order_amount]]', $order->grand_total, $sms_body);
                $sms_body       = str_replace('[[site_name]]', env('APP_NAME'), $sms_body);

                if($order->pay_status == 1){
                    $payment_info = json_decode($order->payment_info);
                    $sms_body     = str_replace('[[payment_details]]', 'পেমেন্ট স্ট্যাটাসঃ paid'.', ট্রান্সেকশন আইডিঃ '.$order->transaction_id.', মাধ্যমঃ '.$order->payment_method.' ', $sms_body);
                }else{
                    $sms_body       = str_replace('[[payment_details]]', '', $sms_body);
                }

                if(substr($order->phone,0,3)=="+88"){
                    $phone = $order->phone;
                }elseif(substr($order->phone,0,2)=="88"){
                    $phone = '+'.$order->phone;
                }else{
                    $phone = '+88'.$order->phone;
                }
                SendSMSUtility::sendSMS($phone, $sms_body);
            }
        }


        // order details add //
        foreach ($carts as $cart) {
            // dd($cart);
            $product = Product::find($cart->id);
            if($cart->options->vendor == 0){
                $vendor_comission = 0.00;
                $vendor = 0;
                //dd($vendor_comission);
            }
            else {
                $vendor = Vendor::where('user_id', $cart->options->vendor)->select('vendors.commission','user_id')->first();
                $vendor_comission = ($cart->price * $vendor->commission)/100;
                //dd($vendor_comission);
            }
            if($cart->options->is_varient == 1){
                $variations = array();
                for($i=0; $i<count($cart->options->attribute_names); $i++){
                    $item['attribute_name'] = $cart->options->attribute_names[$i];
                    $item['attribute_value'] = $cart->options->attribute_values[$i];
                    array_push($variations, $item);
                }
                OrderDetail::insert([
                    'order_id' => $order->id,
                    'product_id' => $cart->id,
                    'product_name' => $cart->name,
                    'is_varient' => 1,
                    'vendor_id' => $vendor->user_id ?? 0,
                    'v_comission' => $vendor_comission,
                    'variation' => json_encode($variations, JSON_UNESCAPED_UNICODE),
                    'qty' => $cart->qty,
                    'price' => $cart->price,
                    'tax' => $cart->tax,
                    'created_at' => Carbon::now(),
                ]);

                // stock calculation //
                $stock = ProductStock::where('varient', $cart->options->varient)->first();
                // dd($cart);
                if($stock){
                    // dd($stock);
                    $stock->qty = $stock->qty - $cart->qty;
                    $stock->save();
                }

            }else{
                OrderDetail::insert([
                    'order_id' => $order->id,
                    'product_id' => $cart->id,
                    'product_name' => $cart->name,
                    'is_varient' => 0,
                    'vendor_id' => $vendor->user_id ?? 0,
                    'v_comission' => $vendor_comission,
                    'qty' => $cart->qty,
                    'price' => $cart->price,
                    'tax' => $cart->tax,
                    'created_at' => Carbon::now(),
                ]);
            }

            $product->stock_qty = $product->stock_qty - $cart->qty;
            $product->save();
        }

        Cart::destroy();

        //OrderStatus Entry
        $orderstatus = OrderStatus::create([
            'order_id' => $order->id,
            'title' => 'Order Placed',
            'comments' => '',
            'created_at' => Carbon::now(),
        ]);

        $orderstatus = OrderStatus::create([
            'order_id' => $order->id,
            'title' => 'Payment Status: '.$payment_status,
            'comments' => '',
            'created_at' => Carbon::now(),
        ]);

        $orderstatus = OrderStatus::create([
            'order_id' => $order->id,
            'title' => 'Delevery Status: Pending',
            'comments' => '',
            'created_at' => Carbon::now(),
        ]);

        //Ledger Entry
        $ledger = AccountLedger::create([
            'account_head_id' => 2,
            'particulars' => $cart->name,
            'credit' => $order->grand_total,
            'order_id' => $order->id,
            'type' => 2,
        ]);
        $ledger->balance = get_account_balance() + $order->grand_total;
        $ledger->save();

        $amount = 0;

        foreach($order->order_details as $order_detail){
            $product_purchase_price = $order_detail->product->purchase_price;
            $amount+=$order_detail->product->purchase_price * $order_detail->qty;
        }

        $order->pur_sub_total = $amount;
        //dd($order);
        $order->save();
        $notification = array(
            'message' => 'Your order has been placed successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('checkout.success', $order->invoice_no)->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('invoice_no', $id)->first();

        $notification = array(
            'message' => 'Your Order Successfully.',
            'alert-type' => 'success'
        );

        return view('frontend.order.order_confirmed', compact('order'))->with($notification);
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

    // public function Myorders(){

    //     $orders = Order::where('user_id',Auth::id())->orderBy('id','DESC')->get();
    //     return view('frontend.user.order.order_view',compact('orders'));

    // }

    public function payment(Request $request){
        //dd($request->all());
        if($request->payment_option == 'cod'){
            $checkout = new CheckoutController;
            return $checkout->store($request);
        }

        Session::put('checkout_request', $request->all());

        $payment_method = $request->payment_option;
        $total_amount = $request->grand_total;
        $last_order = Order::orderBy('id','DESC')->first();
        $order_id = $last_order->id+1;
        $invoice_no = date('YmdHi').$order_id;
        Session::put('invoice_no', $invoice_no);

        if($request->payment_option == 'cod'){
            return redirect()->route('checkout.store');
        }else{
            Session::put('payment_method', $request->payment_option);
            Session::put('payment_type', 'cart_payment');
            Session::put('payment_amount', $total_amount);
            if($request->payment_option == 'nagad'){
                $nagad = new NagadController;
                return $nagad->getSession();
            }else if($request->payment_option == 'bkash'){
                $bkash = new BkashController;
                return $bkash->pay($request);
            }elseif ($request->payment_option == 'sslcommerz') {
                $sslcommerz = new PublicSslCommerzPaymentController;
                return $sslcommerz->index($request);
            }elseif($payment_method =='aamarpay'){
                //dd($request);
                $aamarpay = new AamarpayController;
                return $aamarpay->index($request);
            }
        }

        return view('frontend.checkout.payment', compact('payment_method', 'total_amount', 'invoice_no'));
    }

    public function success($orderId, $json){
        dd(json_decode($json));
    }
}
