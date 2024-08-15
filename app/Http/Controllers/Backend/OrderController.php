<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\Address;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\Shipping;
use Session;
use PDF;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date;
        $delivery_status = null;
        $payment_status = null;
        $shipping_type = null;
        $ordersQuery = Order::where('order_by', 0);
        $dateRange = explode(" - ", $date);
        $startDate = date('Y-m-d', strtotime($dateRange[0]));
        if (isset($dateRange[1])) {
            $endDate = date('Y-m-d', strtotime($dateRange[1]));
        } else {
            $endDate = date('Y-m-d');
        }
        if ($request->filled(['delivery_status', 'payment_status', 'date', 'shipping_type'])) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status)
                ->where('payment_status', $request->payment_status)
                ->where('shipping_type', $request->shipping_type);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status)
                ->where('payment_status', $request->payment_status)
                ->where('shipping_type', $request->shipping_type);
            }
        }elseif ($request->filled(['delivery_status', 'payment_status', 'date']) && $request->shipping_type == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status)
                ->where('payment_status', $request->payment_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status)
                ->where('payment_status', $request->payment_status);
            }
        } elseif ($request->filled(['delivery_status', 'date', 'shipping_type']) && $request->payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status)
                ->where('shipping_type', $request->shipping_type);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status)
                ->where('shipping_type', $request->shipping_type);
            }
        } elseif ($request->filled(['payment_status', 'date', 'shipping_type']) && $request->delivery_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('payment_status', $request->payment_status)
                ->where('shipping_type', $request->shipping_type);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('payment_status', $request->payment_status)
                ->where('shipping_type', $request->shipping_type);
            }
        } elseif ($request->filled(['delivery_status', 'date']) && $payment_status == null && $shipping_type == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status);
            }
        } elseif ($request->filled(['payment_status', 'date']) && $delivery_status == null && $shipping_type == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('payment_status', $request->payment_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('payment_status', $request->payment_status);
            }
        } elseif ($request->filled(['shipping_type', 'date']) && $delivery_status == null && $payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('shipping_type', $request->shipping_type);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('shipping_type', $request->shipping_type);
            }
        } elseif ($request->filled(['date']) && $delivery_status == null && $payment_status == null && $shipping_type == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
        }else {
            $ordersQuery->orderBy('id', 'desc');
        }
        $orders = $ordersQuery->orderBy('created_at', 'desc')->get();
        return view('backend.sales.all_orders.index', compact('orders', 'delivery_status', 'date', 'payment_status', 'shipping_type'));
    }


    public function indexPos(Request $request)
    {
        $date = $request->date;
        $delivery_status = null;
        $payment_status = null;
        $shipping_type = null;
        $ordersQuery = Order::where('order_by', 1);
        $dateRange = explode(" - ", $date);
        $startDate = date('Y-m-d', strtotime($dateRange[0]));
        if (isset($dateRange[1])) {
            $endDate = date('Y-m-d', strtotime($dateRange[1]));
        } else {
            $endDate = date('Y-m-d');
        }

        if ($request->filled(['delivery_status', 'payment_status', 'date', 'shipping_type'])) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status)
                ->where('payment_status', $request->payment_status)
                ->where('shipping_type', $request->shipping_type);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status)
                ->where('payment_status', $request->payment_status)
                ->where('shipping_type', $request->shipping_type);
            }
        }elseif ($request->filled(['delivery_status', 'payment_status', 'date']) && $request->shipping_type == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status)
                ->where('payment_status', $request->payment_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status)
                ->where('payment_status', $request->payment_status);
            }
        } elseif ($request->filled(['delivery_status', 'date', 'shipping_type']) && $request->payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status)
                ->where('shipping_type', $request->shipping_type);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status)
                ->where('shipping_type', $request->shipping_type);
            }
        } elseif ($request->filled(['payment_status', 'date', 'shipping_type']) && $request->delivery_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('payment_status', $request->payment_status)
                ->where('shipping_type', $request->shipping_type);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('payment_status', $request->payment_status)
                ->where('shipping_type', $request->shipping_type);
            }
        } elseif ($request->filled(['delivery_status', 'date']) && $payment_status == null && $shipping_type == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status);
            }
        } elseif ($request->filled(['payment_status', 'date']) && $delivery_status == null && $shipping_type == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('payment_status', $request->payment_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('payment_status', $request->payment_status);
            }
        } elseif ($request->filled(['shipping_type', 'date']) && $delivery_status == null && $payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('shipping_type', $request->shipping_type);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('shipping_type', $request->shipping_type);
            }
        } elseif ($request->filled(['date']) && $delivery_status == null && $payment_status == null && $shipping_type == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
        }else {
            $ordersQuery->orderBy('id', 'desc');
        }
        $orderIds = OrderDetail::where('vendor_id', '=', 0)->pluck('order_id')->toArray();
        $orders = $ordersQuery->whereIn('id', $orderIds)->orderBy('created_at', 'desc')->paginate(15);
       // return $orders;
       return view('backend.sales.all_orders.posOrder', compact('orders', 'orderIds', 'delivery_status', 'date','payment_status','shipping_type'));
    }
    public function AllvendorSellView(Request $request)
    {
        $date = $request->date;
        $delivery_status = null;
        $payment_status = null;
        $vendor_id = null;
        $ordersQuery = Order::where('order_by', 0);
        $dateRange = explode(" - ", $date);
        $startDate = date('Y-m-d', strtotime($dateRange[0]));
        if (isset($dateRange[1])) {
            $endDate = date('Y-m-d', strtotime($dateRange[1]));
        } else {
            $endDate = date('Y-m-d');
        }
        if ($request->filled(['delivery_status', 'payment_status', 'date'])) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status)
                    ->where('payment_status', $request->payment_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status)
                    ->where('payment_status', $request->payment_status);
            }
        } elseif ($request->filled(['delivery_status', 'date',]) && $request->payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status);
            }
        } elseif ($request->filled(['payment_status', 'date']) && $request->delivery_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('payment_status', $request->payment_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('payment_status', $request->payment_status);
            }
        } elseif ($request->filled(['delivery_status', 'date']) && $payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status);
            }
        } elseif ($request->filled(['payment_status', 'date']) && $delivery_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('payment_status', $request->payment_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('payment_status', $request->payment_status);
            }
        } elseif ($request->filled(['date']) && $delivery_status == null && $payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
        } elseif ($request->filled(['date']) && $delivery_status == null && $payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
        } else {
            $ordersQuery->orderBy('id', 'desc');
        }
        $vendors = Vendor::pluck('user_id')->toArray();
        $users = User::where('role', 2)->latest()->get();
        $orderIds = OrderDetail::whereIn('vendor_id', $vendors)->pluck('order_id');
        $orders = $ordersQuery->whereIn('id', $orderIds)->orderBy('created_at', 'desc')->get();
        return view('backend.sales.all_orders.all_vendor_sale_index', compact('orders', 'orderIds', 'vendors', 'delivery_status', 'date', 'payment_status', 'users'));
    }


    public function vendorSellView(Request $request)
    {
        $date = $request->date;
        $delivery_status = null;
        $payment_status = null;
        $vendor_id = null;
        $ordersQuery = Order::where('order_by', 0);
        $dateRange = explode(" - ", $date);
        $startDate = date('Y-m-d', strtotime($dateRange[0]));
        if (isset($dateRange[1])) {
            $endDate = date('Y-m-d', strtotime($dateRange[1]));
        } else {
            $endDate = date('Y-m-d');
        }
        if ($request->filled(['delivery_status', 'payment_status', 'date'])) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status)
                ->where('payment_status', $request->payment_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status)
                ->where('payment_status', $request->payment_status);
            }
        } elseif ($request->filled(['delivery_status', 'date',]) && $request->payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status);
            }
        } elseif ($request->filled(['payment_status', 'date']) && $request->delivery_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('payment_status', $request->payment_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('payment_status', $request->payment_status);
            }
        } elseif ($request->filled(['delivery_status', 'date']) && $payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('delivery_status', $request->delivery_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('delivery_status', $request->delivery_status);
            }
        } elseif ($request->filled(['payment_status', 'date']) && $delivery_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate)->where('payment_status', $request->payment_status);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate])->where('payment_status', $request->payment_status);
            }
        } elseif ($request->filled([ 'date']) && $delivery_status == null && $payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
        } elseif ($request->filled(['date']) && $delivery_status == null && $payment_status == null) {
            if ($startDate === $endDate) {
                $ordersQuery->whereDate('created_at', $startDate);
            } else {
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
        }else {
            $ordersQuery->orderBy('id', 'desc');
        }
        $orderIds = Order::latest()->pluck('id')->toArray();
        if (Auth::guard('admin')->user()->role == '2') {
            $vendor = Vendor::where('user_id', Auth::guard('admin')->user()->id)->first();
            $vendorIds = OrderDetail::where('vendor_id', $vendor->user_id)->pluck('order_id')->toArray();
            //$orders = Order::whereIn('id', $vendorIds)->paginate(15);
            $orders = $ordersQuery->whereIn('id', $vendorIds)->orderBy('created_at', 'desc')->paginate(15);
        }
        else {
            $orders = [];
        }
    	return view('backend.sales.all_orders.vendor_sale_index', compact('orders', 'orderIds','delivery_status', 'date','payment_status'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $shippings = Shipping::where('status', 1)->get();

        return view('backend.sales.all_orders.show', compact('order', 'shippings'));
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
        $this->validate($request,[
            'payment_method' => 'required',
        ]);
        $order = Order::findOrFail($id);

        $order->payment_method = $request->payment_method;
        $order->address = $request->address;

        $discount_total = ($order->sub_total - $request->discount);
        $total_ammount = ($discount_total + $request->shipping_charge);

        Order::where('id', $id)->update([
            'shipping_charge'   => $request->shipping_charge,
            'discount'          => $request->discount,
            'grand_total'       => $total_ammount,
        ]);

        $order->save();

        Session::flash('success','Admin Orders Information Updated Successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        $notification = array(
            'message' => 'Order Deleted Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    /*================= Start update_payment_status Methoed ================*/
    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status = $request->status;
        $order->save();

        $order_detail = OrderDetail::where('order_id', $order->id)->get();
        foreach($order_detail as $item){
            // dd($item);
            $item->payment_status = $request->status;
            $item->save();
        }

        // dd($order);

        $orderstatus = OrderStatus::create([
            'order_id' => $order->id,
            'title' => 'Payment Status: '.$request->status,
            'comments' => '',
            'created_at' => Carbon::now(),
        ]);

        return response()->json(['success'=> 'Payment status has been updated']);

    }

    /*================= Start update_delivery_status Methoed ================*/
    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_status = $request->status;
        $order->save();

        $order_detail = OrderDetail::where('order_id', $order->id)->get();
        foreach($order_detail as $item){
            $item->delivery_status = $request->status;
            $item->save();
        }

        $orderstatus = OrderStatus::create([
            'order_id' => $order->id,
            'title' => 'Delevery Status: '.$request->status,
            'comments' => '',
            'created_at' => Carbon::now(),
        ]);

        return response()->json(['success'=> 'Delivery status has been updated']);

    }



    /*================= Start admin_user_update Methoed ================*/
    public function admin_user_update(Request $request, $id)
    {
        $user = Order::where('id',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // dd($user);

        Session::flash('success','Customer Information Updated Successfully');
        return redirect()->back();
    }

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

    public function invoice_download($id)
    {
        $order = Order::findOrFail($id);
        $pdf = PDF::loadView('backend.invoices.invoice', compact('order'))->setPaper('a4');
        return $pdf->download('invoice.pdf');
    } // end method


    public function invoice_print_download($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.invoices.invoice_print', compact('order'));
    } // end method

}
