<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\MultiImg;
use App\Models\Page;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Vendor;
use Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Utility\CategoryUtility;

class FrontendController extends Controller
{
    /*=================== Start Index Methoed ===================*/
    public function index(Request $request)
    {
        $products = Product::where('status','=',1)->where('is_featured','=',1)->orderBy('id','DESC')->get();

        // Search Start
        $sort_search =null;
        if ($request->has('search')){
            $sort_search = $request->search;
            $products = $products->where('name_en', 'like', '%'.$sort_search.'%');
            // dd($products);
        }else{
           $products = Product::where('status','=',1)->where('is_featured','=',1)->orderBy('id','DESC')->get();
        }

        // Header Category Start
        $categories = Category::orderBy('name_en','DESC')->where('status','=',1)->limit(5)->get();
        // Header Category End

        // Category Featured all
        $featured_category = Category::orderBy('name_en','DESC')->where('is_featured','=',1)->where('status','=',1)->limit(15)->get();

        //Slider
        $sliders = Slider::where('status',1)->orderBy('id','DESC')->limit(10)->get();
        // Product Top Selling
        $product_top_sellings = Product::where('status',1)->orderBy('id','ASC')->limit(2)->get();
        //Product Trending
        $product_trendings = Product::where('status',1)->orderBy('id','ASC')->skip(2)->limit(2)->get();
        //Product Recently Added
        $product_recently_adds = Product::where('status',1)->latest()->skip(2)->limit(2)->get();

        $product_top_rates = Product::where('status',1)->orderBy('regular_price')->limit(2)->get();
        // Home Banner
        $home_banners = Banner::where('status',1)->where('position',1)->orderBy('id','DESC')->get();

        // Daily Best Sells
        $todays_sale  = OrderDetail::where('created_at', 'like', '%'.date('Y-m-d').'%')->get();
        $todays_sale = $todays_sale->unique('product_id');
        //dd($todays_sale);

        //Home2 featured category
        $home2_featured_categories = Category::where('is_featured', 1)
            ->where('status', 1)
            ->orderBy('name_en', 'DESC')
            ->get();


        foreach ($home2_featured_categories as $home2_featured_category) {
            $fcat_products = [];

            $category_ids = CategoryUtility::children_ids($home2_featured_category->id);
            $category_ids[] = $home2_featured_category->id;

            // Eager load products for the current category
            $fcat_products = Product::whereIn('category_id', $category_ids)
                ->where('status', 1)
                ->limit(10)
                ->latest()
                ->get();

            $home2_featured_category->cat_products = $fcat_products;

        }

        // Hot deals product
        $hot_deals = Product::where('status',1)->where('is_deals',1)->latest()->take(4)->get();
        $home_view = 'frontend.home2';

        return view($home_view, compact('categories','sliders','featured_category','products','product_top_sellings','product_trendings','product_recently_adds','product_top_rates','home_banners','sort_search','todays_sale','home2_featured_categories','hot_deals'));
    } // end method

    public function index2(Request $request)
    {

        //Product All Status Active
        $products = Product::where('status',1)->orderBy('id','DESC')->get();

        // Search Start
        $sort_search =null;
        if ($request->has('search')){
            $sort_search = $request->search;
            $products = $products->where('name_en', 'like', '%'.$sort_search.'%');
            // dd($products);
        }else{
            $products = Product::where('status',1)->orderBy('id','DESC')->get();
        }
        // $products = $products->paginate(15);
        // Search Start

        // Header Category Start
        $categories = Category::orderBy('name_en','DESC')->where('status','=',1)->limit(5)->get();
        // Header Category End

        // Category Featured all
        $featured_category = Category::orderBy('name_en','DESC')->where('is_featured','=',1)->where('status','=',1)->limit(15)->get();

        //Slider
        $sliders = Slider::where('status',1)->orderBy('id','DESC')->limit(10)->get();
        // Product Top Selling
        $product_top_sellings = Product::where('status',1)->orderBy('id','ASC')->limit(2)->get();
        //Product Trending
        $product_trendings = Product::where('status',1)->orderBy('id','ASC')->skip(2)->limit(2)->get();
        //Product Recently Added
        $product_recently_adds = Product::where('status',1)->latest()->skip(2)->limit(2)->get();

        $product_top_rates = Product::where('status',1)->orderBy('regular_price')->limit(2)->get();
        // Home Banner
        $home_banners = Banner::where('status',1)->where('position',1)->orderBy('id','DESC')->get();

        // Daily Best Sells
        //dd(date('Y-m-d'));
        $todays_sale  = OrderDetail::where('created_at', 'like', '%'.date('Y-m-d').'%')->get();
        // dd($todays_sale);

        //Home2 featured category
        $home2_featured_categories = Category::orderBy('name_en','DESC')->where('is_featured','=',1)->where('status','=',1)->get();
        // Hot deals product
        $hot_deals = Product::where('status',1)->where('is_deals',1)->latest()->take(4)->get();

        return view('frontend.home2', compact('categories','sliders','featured_category','products','product_top_sellings','product_trendings','product_recently_adds','product_top_rates','home_banners','sort_search','todays_sale','home2_featured_categories','hot_deals'));
    } // end method

    /* ========== Start ProductDetails Method ======== */
    public function productDetails($slug){

        $product = Product::where('slug', $slug)->first();
        if($product){
            if($product->id){
                $multiImg = MultiImg::where('product_id',$product->id)->get();
            }

            /* ================= Product Color Eng ================== */
            $color_en = $product->product_color_en;
            $product_color_en = explode(',', $color_en);

            /* ================= Product Size Eng =================== */
            $size_en = $product->product_size_en;
            $product_size_en = explode(',', $size_en);

            /* ================= Realted Product =============== */
            $cat_id = $product->category_id;
            $relatedProduct = Product::where('category_id',$cat_id)->where('id','!=',$product->id)->orderBy('id','DESC')->get();

            $categories = Category::orderBy('name_en','ASC')->where('status','=',1)->limit(5)->get();
            $new_products = Product::orderBy('name_en')->where('status','=',1)->limit(3)->latest()->get();

            return view('frontend.product.product_details', compact('product','multiImg','categories','new_products','product_color_en','product_size_en','relatedProduct'));
        }

        return view('frontend.product.productNotFound');
    }

    /* ========== Start CatWiseProduct Method ======== */
    public function CatWiseProduct(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();
        $sort_by = $request->input('sort_by');
        $brand_id = $request->brand_id;

        $conditions = ['status' => 1];

        if($brand_id != null){
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        // Start building the query with conditions
        $products = Product::where($conditions);

        // Apply category filtering
        $category_ids = CategoryUtility::children_ids($category->id);
        $category_ids[] = $category->id;
        $products = $products->whereIn('category_id', $category_ids);

        // Apply price filtering
        $min_price = $request->get('filter_price_start');
        $max_price = $request->get('filter_price_end');

        if ($min_price != null && $max_price != null) {
            $products = $products->whereBetween('regular_price', [$min_price, $max_price]);
        }

        // Apply sorting
        switch ($sort_by) {
            case 'newest':
                $products = $products->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $products = $products->orderBy('created_at', 'asc');
                break;
            case 'price-asc':
                $products = $products->orderBy('regular_price', 'asc');
                //dd($products);
                break;
            case 'price-desc':
                $products = $products->orderBy('regular_price', 'desc');
                break;
            default:
                $products = $products->orderBy('id', 'desc');
                break;
        }


        // Apply pagination and append query parameters
        $products = $products->paginate(32)->appends(request()->query());

        // Fetch categories and subcategories for the view
        $categories = Category::orderBy('name_en', 'ASC')->where('status', '=', 1)->get();
        $subcategories = Category::orderBy('name_en', 'ASC')->where('status', 1)->where('parent_id', $category->id)->get();

        // Return the view with all necessary data
        return view('frontend.product.category_view', compact('products', 'categories', 'category', 'sort_by', 'brand_id', 'subcategories'));
    }// end method
    /* ========== End CatWiseProduct Method ======== */

     /* ========== Start CatWiseProduct Method ======== */
    public function VendorWiseProduct(Request $request,$slug){

        $vendor = Vendor::where('slug', $slug)->first();
        // dd($category);

        $products = Product::where('status', 1)->where('vendor_id',$vendor->id)->orderBy('id','DESC')->paginate(20);
        // Price Filter
        if ($request->get('filter_price_start')!== Null && $request->get('filter_price_end')!== Null ){
            $filter_price_start = $request->get('filter_price_start');
            $filter_price_end = $request->get('filter_price_end');

            if ($filter_price_start>0 && $filter_price_end>0) {
                $products = Product::where('status','=',1)->where('vendor_id',$vendor->id)->whereBetween('regular_price',[$filter_price_start,$filter_price_end])->paginate(20);
                // dd($products);
            }

        }

        $categories = Category::orderBy('name_en','ASC')->where('status','=',1)->get();
        // dd($products);

        return view('frontend.product.vendor_view',compact('products','categories','vendor'));
    } // end method
    /* ========== End CatWiseProduct Method ======== */

    /* ================= Start ProductViewAjax Method ================= */
    public function ProductViewAjax($id){
        $product = Product::with('category','brand')->findOrFail($id);
        // dd($product);
        $attribute_values = json_decode($product->attribute_values);
        $attributes = new Collection;
        if($attribute_values){
            foreach($attribute_values as $key => $attribute_value){
                $attr = Attribute::select('id','name')->where('id',$attribute_value->attribute_id)->first();
                // $attribute->name = $attr->name;
                // $attribute->id = $attr->id;
                $attr->values = $attribute_value->values;
                $attributes->add($attr);
            }
        }

        return response()->json(array(
            'product' => $product,
            'attributes' => $attributes,
        ));
    }
    /* ================= END PRODUCT VIEW WITH MODAL METHOD =================== */
    public function pageAbout($slug){
        $page = Page::where('slug', $slug)->first();
        return view('frontend.settings.page.about',compact('page'));
    }

    public function privacyPolicy(){
        return view('frontend.settings.page.privacy_policy');
    }

    public function returnPolicy(){
        return view('frontend.settings.page.return_policy');
    }

    public function refundPolicy(){
        return view('frontend.settings.page.refund_policy');
    }

    public function termcondition(){
        return view('frontend.settings.page.term_condition');
    }

    public function orderTracking()
    {
        return view('frontend.settings.page.order_tracking');
    }

    public function CareerPage()
    {
        return view('frontend.settings.page.career');
    }

    public function CareerExecutiveApply()
    {
        return view('frontend.settings.page.career-executive-from');
    }

    public function orderTrack(Request $request)
    {
        $this->validate($request,[
            'invoice_no' => 'required',
            'phone' => 'required',
        ]);
        $order = Order::where('invoice_no', $request->invoice_no)->where('phone', $request->phone)->first();
        if(!$order){
            $notification = array(
                'message' => 'Required Data Not Found.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        // dd($order);
        return view('frontend.settings.page.track',compact('order'));
    }

    public function BrandWiseProduct(Request $request, $slug)
    {
        $brands = Brand::where('slug', $slug)->first();
        $conditions = ['status' => 1];
        $products = Product::where($conditions);
        if ($brands) {
            $products = $products->where('brand_id', $brands->id);
        }

        $min_price = $request->get('filter_price_start');
        $max_price = $request->get('filter_price_end');

        if ($min_price != null && $max_price != null) {
            $products = $products->whereBetween('regular_price', [$min_price, $max_price]);
        }

        $products = $products->paginate(32)->appends(request()->query());
        return view('frontend.product.brand_view', compact('products', 'brands'));
    }

    /* ================= Start Product Search =================== */
    public function ProductSearch(Request $request){
        $sort_by = $request->sort_by;
        $brand_id = $request->brand;

        $conditions = ['status' => 1];

        if($brand_id != null){
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        $products_sort_by = Product::where($conditions);

        switch ($sort_by) {
            case 'newest':
                $products_sort_by->orderBy('created_at', 'desc')->paginate(10);
                break;
            case 'oldest':
                $products_sort_by->orderBy('created_at', 'asc')->paginate(10);
                break;
            case 'price-asc':
                $products_sort_by->orderBy('regular_price', 'asc')->paginate(10);
                break;
            case 'price-desc':
                $products_sort_by->orderBy('regular_price', 'desc')->paginate(10);
                break;
            default:
                $products_sort_by->orderBy('id', 'desc')->paginate(10);
                break;
        }

        $item = $request->search;
        $category_id = $request->searchCategory;
        $categories = Category::orderBy('name_en','DESC')->where('status', 1)->get();
        if($category_id == 0){
            $products = Product::where('name_en','LIKE',"%$item%")->where('status'
            , 1)->latest()->get();
        }else{
            $products = Product::where('name_en','LIKE',"%$item%")->where('category_id', $category_id)->where('status'
            , 1)->latest()->get();
        }

        $attributes = Attribute::orderBy('name', 'DESC')->where('status', 1)->latest()->get();

        return view('frontend.product.search',compact('products','categories','attributes','sort_by','brand_id'));

    } // end method

    /* ================= End Product Search =================== */

    /* ================= Advance Product Search Start =================== */
    public function advanceProduct(Request $request) {
        $request->validate(["search" => "required"]);
        $item = $request->search;
        $category_id = $request->category;
        $categories = Category::orderBy('name_en', 'DESC')->where('status', 1)->get();
        $brand = Brand::where('name_en', 'LIKE', "%$item%")->first();
        $products = [];
        $brands = [];
        $attributes = Attribute::orderBy('name', 'DESC')->where('status', 1)->latest()->get();

        if ($brand) {
            if ($category_id == 0) {
                $brands = Brand::where('name_en', 'LIKE', "%$item%")->where('status', 1)->latest()->get();
            }
            return view('frontend.product.brand_advance_search', compact('brands', 'categories', 'attributes'));
        }

        if ($category_id == 0) {
            $products = Product::where('name_en', 'LIKE', "%$item%")->where('status', 1)->latest()->get();
        } else {
            $products = Product::where('name_en', 'LIKE', "%$item%")->where('category_id', $category_id)->where('status', 1)->latest()->get();
        }

        return view('frontend.product.advance_search', compact('products', 'categories', 'attributes'));
    }
    /* ================= End Advance Product Search =================== */

    /* ================= Start Hot Deals Page Show =================== */
    public function hotDeals(Request $request){

        $sort_by = $request->sort_by;
        $brand_id = $request->brand;

        $conditions = ['status' => 1];

        if($brand_id != null){
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        $products_sort_by = Product::where($conditions);

        switch ($sort_by) {
            case 'newest':
                $products_sort_by->orderBy('created_at', 'desc')->paginate(10);
                break;
            case 'oldest':
                $products_sort_by->orderBy('created_at', 'asc')->paginate(10);
                break;
            case 'price-asc':
                $products_sort_by->orderBy('regular_price', 'asc')->paginate(10);
                break;
            case 'price-desc':
                $products_sort_by->orderBy('regular_price', 'desc')->paginate(10);
                break;
            default:
                $products_sort_by->orderBy('id', 'desc')->paginate(10);
                break;
        }
        // Hot deals product
        $products = Product::where('status',1)->where('is_deals',1)->paginate(5);

        // Category Filter Start
        if ($request->get('filtercategory')){

            $checked = $_GET['filtercategory'];
            // filter With name start
            $category_filter = Category::whereIn('name_en', $checked)->get();
            $catId = [];
            foreach($category_filter as $cat_list){
                array_push($catId, $cat_list->id);
            }
            // filter With name end

            $products = Product::whereIn('category_id', $catId)->where('status', 1)->where('is_deals',1)->latest()->paginate(10);
            // dd($products);
        }
        // Category Filter End

        $attributes = Attribute::orderBy('name', 'DESC')->where('status', 1)->latest()->get();
        // End Shop Product //
        return view('frontend.deals.hot_deals',compact('attributes','products','sort_by','brand_id'));

    } // end method
}
