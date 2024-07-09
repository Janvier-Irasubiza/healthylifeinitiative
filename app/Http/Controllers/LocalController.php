<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Mail\PlacedOrder;
use App\Mail\NewMessage;
use Mail;

class LocalController extends Controller
{
  
  
    public function generateOrderNumber() {
        $prefix = 'ORD-';
        $date = now()->format('Ymd');
        $day = now()->format('d');
        $month = now()->format('m');
    
        $lastOrder = DB::table('orders')
                ->orderBy('requested_on', 'desc')
                ->first();
        
        if ($lastOrder) {
            $lastOrderNumber = $lastOrder->id;
            $lastOrderSequence = intval(substr($lastOrderNumber, strlen($prefix) + strlen($date)));
            $sequence = $lastOrderSequence + 1;
        } else {
            $sequence = 1;
        }
    
        $sequence = min($sequence, 9999);
        $sequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);
        $year = substr(now()->format('Y'), -2);
        $maxOrderNumberLength = 20 - strlen($prefix) - strlen($date) - strlen($sequence);
        $randomChars = '-' . strtoupper(Str::random($maxOrderNumberLength)) . '-';
        $orderNumber = $prefix . $year . $month .  $day . $randomChars .  $sequence;
    
        return $orderNumber;
    }

  
    public function index () {
        $posters = DB::table('posters') -> get();
        $categories = DB::table('categories') -> get();
        $products = DB::table('products') -> where('order_count', '>', '5') -> where('type', 'main') -> get();

        return view('index', compact('categories', 'products', 'posters'));
    }

    public function market() {
        $products = DB::table('products') -> where('type', 'main') -> get();
        
        return view('market', compact('products'));
    }

    public function product (Request $request) {
        $product = DB::table('products') -> where('uuid', $request -> product) -> first();
      	$ctgr = DB::table('categories') -> where('id', $product -> category) -> first();
        $related = DB::table('products') -> where('category', $product -> category) -> where('id', '!=', $product->id) -> get();
      
      	$Values = explode(', ', $product->added_value);
        $Benefits = explode(', ', $product->life_benefits);

        return view ('product', compact('product', 'ctgr', 'related', 'Values', 'Benefits'));
    }

    public function products (Request $request) {

        $category = DB::table('categories') -> where('uuid', $request -> category) -> first();
        $products = DB::table('products') -> where('category', $category -> id) -> where('type', 'main') -> get();

        return view('products', compact('category', 'products'));
    }

    public function order () {
        return view('purchase-form');
    }

    public function place_order () {
        return view('order');
    }

    public function addItemToCart(Request $request) {

        $product = DB::table('products')->where('id', $request->product)->first();
        $productId = $product->id;

        $productInfo = [
            'id' => $productId,
            'name' => $product->name,
            'image' => $product->poster,
            'pic1' => $product->pic1,
            'pic2' => $product->pic2,
            'pic3' => $product->pic3,
            'pic4' => $product->pic4,
            'pic5' => $product->pic5,
            'pic6' => $product->pic6,
            'quantity' => 1,
            'max_quantity' => $product->quantity,
            'quantity_unit' => $product->quantity_unit,
            'price' => $product->price,
            'promo_price' => $product->promo_price,
            'unit_price' => $product->price,
            'description' => $product->description,
            'motive' => $product->motive,
        ];

        $clientInstance = new ClientController();
        $clientInstance->add_to_cart($productInfo);

        return back();
    }

    public function changeCartItem(Request $request) {

        $product = DB::table('products')->where('id', $request->product)->first();
        $productId = $product->id;

        $productInfo = [
            'id' => $productId,
            'name' => $product->name,
            'image' => $product->poster,
            'pic1' => $product->pic1,
            'pic2' => $product->pic2,
            'pic3' => $product->pic3,
            'pic4' => $product->pic4,
            'pic5' => $product->pic5,
            'pic6' => $product->pic6,
            'quantity' => 1,
            'max_quantity' => $request->quantity,
            'quantity_unit' => $product->quantity_unit,
            'price' => $product->price,
            'promo_price' => $product->promo_price,
            'unit_price' => $product->price,
            'description' => $product->description,
            'motive' => $product->motive,
        ];

        $clientInstance = new ClientController();
        $clientInstance->add_to_cart($productInfo);
        
        return back();
    }

    public function cart (Request $request) {

        $subtotal = 0;
        $cart = [];

        if(Auth::user()) {
            $cart = DB::table('cart')->where('client', Auth::user()->id)->get();
            $subtotal = $cart->sum('price');
        }

        else {
            $cartData = session()->get('cart', []);;

            if($cartData) {
                foreach ($cartData as $name => $value) {
                    $cart[] = Crypt::decrypt($value);
                }
    
                foreach($cart as $item) {
                    $subtotal+= $item['price']; 
                }
            }
        }

        return view('cart', compact('cart', 'subtotal'));
    }

    public function checkout (Request $request) {

        $validData = $request->validate([
            'quantity' => 'required|min:1',
            'price_inpt' => 'required',
            'totalPrice' => 'required',
            'product' => 'required'
        ]);

        $order_data = [];

        if ($request->has('product')) {
            foreach ($request->product as $key => $item) {
                array_push($order_data, [
                    'product' => $item,
                    'quantity' => $request -> quantity[$key],
                ]);
            }
        }

        session()->put('validData', $validData);
        session()->put('order_data', $order_data);

        return to_route('checkout-view');

    }

    public function checkout_view () {
        $cart = [];
        $subtotal = 0;

        $cartData = session()->get('cart', []);;

        if($cartData) {
            foreach ($cartData as $name => $value) {
                $cart[] = Crypt::decrypt($value);
            }

            foreach($cart as $item) {
                $subtotal+= $item['price']; 
            }
        }

        $validData = session()->get('validData', []);
        $order_data = session()->get('order_data', []);

        return view('checkout', compact('cart', 'validData', 'order_data'));
    }

    public function completeOrder(Request $request) {
        
        $validData = $request->validate([
            'prod' => 'required',
            'names' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $orderInfo = [];
		$instance = new AdminController;
      	$order = [];
      
      	do {
            $ordernumber = $this->generateOrderNumber();
        } while (
            DB::table('orders')
                ->where('order_number', $ordernumber)
                ->where('client_email', $request->email)
                ->where('client_phone', $request->phone)
                ->exists()
        );

        if ($request->has('prod')) {
            foreach ($request->prod as $key => $item) {
        		$uuid = $instance->genUUID();
              	$order[] = $uuid;
                array_push($orderInfo, [
                  	'uuid'=>$uuid,
                    'product' => $item,
                  	'order_number' => $ordernumber,
                    'quantity' => $request -> quantity[$key],
                    'client_names' => $request -> names,
                    'client_email' => $request -> email,
                    'client_phone' => $request -> phone,
                    'delivery_mode' => $request -> delivery,
                    'd_city' => $request -> city,
                    'd_sector' => $request -> sector,
                    'd_cell' => $request -> cell,
                    'd_vilage' => $request -> village,
                    'd_desc' => $request -> address_details,
                    'requested_on' => Carbon::now()->format('Y-m-d H:i:s.u'),
          			'due_date' => Carbon::now()->addDays(30)->format('Y-m-d H:i:s.u'),
                ]);
            }
        }

        if(DB::table('orders')->insert($orderInfo)) {
            session()->forget('validData');
            session()->forget('data_order');
            session()->forget('cart');
          
          	$this->sendOrderInvoice($order, $request -> quantity);
          
      		return to_route('payment', ['order'=>implode(',', $order)]);
        }
        else {
            return back()->with('failed', 'Something went wrong, please try again!');
        }

    }

    public function about () {
        return view('about');
    }

    public function special_order (Request $request) {
        $order_data = $request -> validate([
            'product' => ['required'],
            'desc' => ['required'],
            'names' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
        ]);
      
      	$instance = new AdminController;
      	$uuid = $instance->genUUID();

        $order = [
          	'uuid'=>$uuid,
            'product' => $request -> product,
            'description' => $request -> desc,
            'client_names' => $request -> names,
            'client_email' => $request -> email,
            'client_phone' => $request -> phone,
        ];

        DB::table('special_orders') -> insert($order);

        return redirect() -> route('index') -> with('success', 'Your order have been sucessfully received. We will get back to you soon through your email or your phone number!');
    }


    public function add_to_cart($productInfo) {

        if(Auth::user()) {
            if(!DB::table('cart')
                    ->where('client', Auth::user()->id)
                    ->where('product', $productInfo['id'])
                    ->exists()) {
                    DB::table('cart') -> insert([
                        'client' => Auth::user()->id,
                        'product' => $productInfo['id'],
                        'name' => $productInfo['name'],
                        'image' => $productInfo['image'],
                        'quantity' => $productInfo['quantity'],
                        'max_quantity' => $productInfo['max_quantity'],
                        'quantity_unit' => $productInfo['quantity_unit'],
                        'price' => $productInfo['price'],
                        'unit_price' => $productInfo['unit_price'],
                        'promo_price' => $productInfo['promo_price'],
                    ]);
            }
            else {
                DB::table('cart')
                    ->where('client', Auth::user()->id)
                    ->where('product', $productInfo['id'])
                    ->update([
                        'quantity' => $productInfo['quantity'],
                        'price' => $productInfo['price'],
                    ]);
                }
            }
        else {
            $encryptedCart = Crypt::encrypt($productInfo);
            $cart = session()->get('cart');
            $cartData = [];
        
            if(!is_null($cart)) {
                foreach ($cart as $name => $value) {
                    $cartData[] = Crypt::decrypt($value);
                }
            }
        
            $itemExists = false;
            foreach ($cartData as $key => $item) {
                if ($item['id'] == $productInfo['id']) {
                    $cartData[$key]['quantity'] = $productInfo['quantity'];
                    $itemExists = true;
                    break;
                }
            }
        
            if (!$itemExists) {
                $cartData[] = $productInfo;
            }
        
            $encryptedCartData = [];
            foreach ($cartData as $item) {
                $encryptedCartData[] = Crypt::encrypt($item);
            }
            session()->put('cart', $encryptedCartData);
        }
    }

    public function add_a_like(Request $request) {
        $product = DB::table('products') -> where('id', $request->idProduct)->first();

        $likedProducts = session()->get('liked_products', []);
    
        if (in_array($product->id, $likedProducts)) {
            $likedProducts = array_diff($likedProducts, [$product->id]);
            session()->put('liked_products', $likedProducts);
            if(Auth::user()){
                DB::table('liked_products') -> where('liked_by', Auth::user() -> id) -> where('product', $request->idProduct) -> delete();
                DB::table('products') -> where('id', $product->id) -> decrement('like_count');
            }
            else{
                DB::table('liked_products') -> where('liked_session', session()->getId()) -> where('product', $request->idProduct) -> delete();
                DB::table('products') -> where('id', $product->id) -> decrement('like_count');
            }
        } 
        else {
            $likedProducts[] = $product -> id;
            session()->put('liked_products', $likedProducts);
            
            if(Auth::user()) {
                DB::table('liked_products')->insert([
                    'liked_by' => Auth::user() -> id,
                    'product' => $product->id,
                    'liked_on' => now(),
                ]);

                DB::table('products') -> where('id', $product->id) -> increment('like_count');
            }
            
            else{
                DB::table('liked_products')->insert([
                    'liked_session' => session()->getId(),
                    'product' => $product->id,
                    'liked_on' => now(),
                ]);

                DB::table('products') -> where('id', $product->id) -> increment('like_count');
            }
        }
    
        return back()->with('success', 'Thank you for liking our product!');
    
    }

    public function remove_item($productId) {
        $encryptedCart = session()->get('cart', []);

        $cart = [];
        foreach ($encryptedCart as $item) {
            $cart[] = Crypt::decrypt($item);
        }

        foreach ($cart as $key => $item) {
            if ($item['id'] == $productId) {
                unset($cart[$key]);
                break; 
            }
        }

        $updatedEncryptedCart = [];
        foreach ($cart as $item) {
            $updatedEncryptedCart[] = Crypt::encrypt($item);
        }

        session()->put('cart', $updatedEncryptedCart);
    }

    public function confirm_order(Request $request) {

        $request->validate([
            'qty' => 'required|integer|min:1',
            'price_inpt' => 'required|numeric',
        ]);

        $product = DB::table('products')->where('uuid', $request->p)->first();
        $productId = $product->id;
        $category = $product->category;
        $ctgr = DB::table('categories') -> where('id', $category) -> first();
    
        $productInfo = [
            'id' => $productId,
            'name' => $product->name,
            'image' => $product->poster,
            'pic1' => $product->pic1,
            'pic2' => $product->pic2,
            'pic3' => $product->pic3,
            'pic4' => $product->pic4,
            'pic5' => $product->pic5,
            'pic6' => $product->pic6,
            'quantity' => $request->qty,
            'max_quantity' => $product->quantity,
            'quantity_unit' => $product->quantity_unit,
            'price' => $request->price_inpt,
            'promo_price' => $product->promo_price,
            'unit_price' => $product->price,
            'description' => $product->description,
            'motive' => $product->motive,
        ];
    
        $this->add_to_cart($productInfo);
      	$Values = explode(', ', $product->added_value);
        $Benefits = explode(', ', $product->life_benefits);

        return view('purchase-form', compact('productInfo', 'ctgr', 'Values', 'Benefits'));
    }

    public function make_order (Request $request) {

        date_default_timezone_set('Africa/Kigali');

        $order = $request -> validate([
            'names' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'delivery' => 'required',
        ]);
      
      	$instance = new AdminController;
        $uuid = $instance->genUUID();
      
		do {
            $ordernumber = $this->generateOrderNumber();
        } while (
            DB::table('orders')
                ->where('order_number', $ordernumber)
                ->where('client_email', $request->email)
                ->where('client_phone', $request->phone)
                ->exists()
        );

        $data_order = [
          	'uuid' => $uuid,
            'product' => $request -> product_id,
          	'order_number' => $ordernumber,
            'quantity' => $request -> quantity,
            'client_names' => $request -> names,
            'client_email' => $request -> email,
            'client_phone' => $request -> phone,
            'delivery_mode' => $request -> delivery,
            'd_city' => $request -> city,
            'd_sector' => $request -> sector,
            'd_cell' => $request -> cell,
            'd_vilage' => $request -> village,
            'd_desc' => $request -> address_details,
            'requested_on' => Carbon::now()->format('Y-m-d H:i:s.u'),
          	'due_date' => Carbon::now()->addDays(30)->format('Y-m-d H:i:s.u'),
        ];

        if(DB::table('orders') -> insert($data_order)) {

            if(Auth::user()) {
                DB::table('cart') 
                    ->where('client', Auth::user()->id)
                    ->where('product', $request -> product_id)
                    ->delete();
            }

            else {
                $this->remove_item($request -> product_id);
            }
                    
          	DB::table('products')
              ->limit(1)
              ->where('id', $request -> product_id)
              ->increment('order_count', $request->quantity);
        }
      
      	/*
      	$client = $request->names;
      	$product = DB::table('products') -> where('id', $request -> product_id) -> select('name') -> first();
      	$unit = DB::table('products') -> where('id', $request -> product_id) -> select('quantity_unit') -> first();
      	$qty = $request -> quantity;
      	$url = url(route('client.dashboard'));
      
      	Mail::to($request->email) -> send(new PlacedOrder($client, $product->name, $qty, $unit->quantity_unit, $url));
        */ 
      		
      	$this->sendOrderInvoice($uuid, $request -> quantity);
      	
      	return to_route('payment', ['order'=>$uuid]);

        // return to_route('index') -> with('success', 'Your order has been successfully sent to us. Stay alert as we process it, we will get back to you soon.');
    }
  
  	public function sendOrderInvoice($order, $qty) {
       
       	$ids = is_array($order) ? $order : explode(',', $order);

        $orderInfo = DB::table('orders')
            ->whereIn('uuid', $ids)
            ->where('progress', 'Pending')
            ->select(
          		'order_number', 
          		'product', 
          		'quantity', 
          		'client_names', 
          		'client_email', 
          		'client_phone', 
          		'requested_on', 
          		'due_date')
            ->get();

        $client = $orderInfo->first(); 
        $products = []; 
       	$totalDue = 0;

        foreach($orderInfo as $order) {
            $product = DB::table('products')
                ->where('id', $order->product)
                ->select('name', 'price', 'promo_price', 'quantity_unit')
                ->first();
            $products[] = $product;
          
          	if(!is_null($product->promo_price)) {
          		$totalDue += $product->promo_price * $order->quantity;
              }
            else {
              $totalDue += $product->price * $order->quantity;
            }
        }
       
      	$url = url(route('client.dashboard'));
            
      	if(
          Mail::to($client->client_email) 
          	->send(new PlacedOrder(
              		$client, 
                    $product,
                    $products,
                    $orderInfo,
                    $totalDue,
                    $qty, 
                    $url
            ))) {
          
      		return true;
        }
    }
  
     public function genInvoice(Request $request) {
       
       	$ids = is_array($request->order) ? $request->order : explode(',', $request->order);

        $orderInfo = DB::table('orders')
            ->whereIn('uuid', $ids)
            ->where('progress', 'Pending')
            ->select('order_number', 'product', 'quantity', 'client_names', 'client_email', 'client_phone', 'requested_on', 'due_date')
            ->get();

        $client = $orderInfo->first(); 
        $products = []; 
       	$totalDue = 0;

        foreach($orderInfo as $order) {
            $product = DB::table('products')
                ->where('id', $order->product)
                ->select('name', 'price', 'promo_price')
                ->first();
            $products[] = $product;
          
          	if(!is_null($product->promo_price)) {
          		$totalDue += $product->promo_price * $order->quantity;
              }
            else {
              $totalDue += $product->price * $order->quantity;
            }
        }
       
        return view('payment', compact('orderInfo', 'products', 'client', 'totalDue'));
    }
  
  public function sendMessageToMail(
    	$sendTo,
        $senderNames,
        $message,
        $replied,
        $url) {
    
          Mail::to($sendTo)
              ->send(new NewMessage(
                  $senderNames,
                  $message,
                  $replied,
                  $url
              ));

          return true;
      }

}
