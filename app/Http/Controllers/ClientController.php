<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\AdminController;
use App\Controllers\LocalContoller;
use Carbon\Carbon;

class ClientController extends Controller{
    public function dashboard() {
        $products = DB::table("products") -> get();
        $my_order = DB::table('user_requests') -> where('client_id', Auth::user() -> id) -> whereNull('deletion_status') -> get();
        $cart = DB::table('cart')->where('client', Auth::user() -> id)->get();
        return view('client.dashboard', compact('products', 'my_order', 'cart'));
    }

    public function update_delivery(Request $request) {
        DB::table('orders') -> where('id', $request -> order_id) -> where('client_id', Auth::user()->id) -> update(['delivery_mode' => 'Pick Up']);
        return back() -> with('change_success', 'Your delivery option have been changed to Pick Up sucessfully.');
    }

    public function spcl_orders () {
        $products = DB::table("products") -> get();
        $orders = DB::table('special_orders') -> where('client_id', Auth::user() -> id) -> whereNull('deletion_status') -> get();

        return view('client.spcl-orders', compact('products', 'orders'));
    }

    public function checkoutView() {

        if(Auth::user()) {
            $cart = DB::table('cart')->where('client', Auth::user()->id)->get();
        }
        else {
            $cart = session()->get('cart', []);
        }

        $validData = session()->get('validData', []);
        $data_order = session()->get('data_order', []);

        return view('client.checkout', compact('cart', 'validData', 'data_order'));
    }

    public function checkout (Request $request) {

        $validData = $request->validate([
            'quantity' => 'required|min:1',
            'price_inpt' => 'required',
            'totalPrice' => 'required',
            'product' => 'required'
        ]);

        if(Auth::user()) {

            $client = User::find(Auth::user()->id);        
            $data_order = [];
          
          	$localContInstance = new LocalController;
      
            do {
                $ordernumber = $localContInstance->generateOrderNumber();
            } while (
                DB::table('orders')
                    ->where('order_number', $ordernumber)
                    ->where('client_email', $request->email)
                    ->where('client_phone', $request->phone)
                    ->exists()
            );

            if ($request->has('product')) {
                foreach ($request->product as $key => $item) {
                  	$instance = new AdminController;
        			$uuid = $instance->genUUID();
                    array_push($data_order, [
                      	'uuid'=>$uuid,
                        'product' => $item,
                      	'order_number' => $ordernumber,
                        'quantity' => $request -> quantity[$key],
                        'client_names' => $client -> name,
                        'client_email' => $client -> email,
                        'client_phone' => $client -> phone,
                        'requested_on' => Carbon::now()->format('Y-m-d H:i:s.u'),
          				'due_date' => Carbon::now()->addDays(30)->format('Y-m-d H:i:s.u'),
                        'client_id' => $client -> id
                    ]);
                }
            }
            
            DB::table('orders')->insert($data_order);
            $cart = DB::table('cart')->where('client', Auth::user()->id)->get();
        }
        else {
            $cart = session()->get('cart', []);
        }

        session()->put('validData', $validData);
        session()->put('data_order', $data_order);

        return to_route('client.chckt');
    }

    public function completeOrder(Request $request) {
        
        $validData = $request->validate([
            'prod' => 'required'
        ]);

		$order = [];

        if ($request->has('prod')) {
            foreach ($request->prod as $key => $item) {

                DB::table('orders')
                    ->where('client_id', Auth::user()->id)
                    ->where('product', $item)
                    ->where('progress', 'pending')
                    ->limit(1)
                    ->update([
                        'delivery_mode' => $request -> delivery,
                        'd_city' => $request -> city,
                        'd_sector' => $request -> sector,
                        'd_cell' => $request -> cell,
                        'd_vilage' => $request -> village,
                        'd_desc' => $request -> address_details,
                        'requested_on' => Carbon::now()->format('Y-m-d H:i:s.u'),
          				'due_date' => Carbon::now()->addDays(30)->format('Y-m-d H:i:s.u'),
                    ]);
              	
              	$orderInfo = DB::table('orders')
                              ->where('client_id', Auth::user()->id)
                              ->where('product', $item)
                              ->where('progress', 'pending')
                              ->first();
              
              	$order[] = $orderInfo->uuid;

               	DB::table('cart')->where('client', Auth::user()->id)->where('product', $item)->delete();
            }
        }

        session()->forget('validData');
        session()->forget('data_order');

      	$initializer = new LocalController;
      	$initializer->sendOrderInvoice($order, $request -> quantity);
      
		return to_route('payment', ['order'=>implode(',', $order)]);

        // return to_route('client.dashboard')->with('success', 'Your order have been successfull submitted');
    }

    public function product (Request $request) {
        $product = DB::table('products') -> where('uuid', $request -> product) -> first();
        $products = DB::table("products") -> get();
      	
      	$Values = explode(', ', $product->added_value);
        $Benefits = explode(', ', $product->life_benefits);
      
        return view ('client.product', compact('product', 'products', 'Values', 'Benefits'));
    }

    public function order (Request $request) {
        $product = DB::table('products') -> where('slag', $request -> slag) -> first();
        return view('client.purchase-form', compact('product'));
    }

    public function place_order (Request $request) {
        return view('client.order');
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

                    return back() -> with('success', 'This product is already in your cart!');
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
    
    public function remove_item($productId) {
        $encryptedCart = session()->get('cart', []);

        if(Auth::user()){
            DB::table('cart') -> where('id', $productId) -> where('client', Auth::user() -> id) -> limit(1) -> delete();
            return back() -> with(['success_rm' => 'The product was removed from cart successfully!', 'item_id' => $productId]);
        }

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

        return back() -> with(['success_rm' => 'The product was removed from cart successfully!', 'item_id' => $productId]);
    }

    public function remove_item_from_cart(Request $request) {
        $product = $request -> product_id;
        $this->remove_item($product);
        return back();
    }

    public function confirm_order(Request $request) {

        $request->validate([
            'qty' => 'required|integer|min:1',
            'price_inpt' => 'required|numeric',
        ]);

        $product = DB::table('products')->where('uuid', $request->p)->first();
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

        return view('client.purchase-form', compact('productInfo'));
    }
    
    public function make_order (Request $request) {

        date_default_timezone_set('Africa/Kigali');

        $order = $request -> validate([
            'delivery' => 'required',
        ]);

        $client = User::find($request -> client);

      	$instance = new AdminController;
        $uuid = $instance->genUUID();
      	$localContInstance = new LocalController;
      
      	do {
            $ordernumber = $localContInstance->generateOrderNumber();
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
            'client_names' => $client -> name,
            'client_email' => $client -> email,
            'client_phone' => $client -> phone,
            'delivery_mode' => $request -> delivery,
            'd_city' => $request -> city,
            'd_sector' => $request -> sector,
            'd_cell' => $request -> cell,
            'd_vilage' => $request -> village,
            'd_desc' => $request -> address_details,
            'requested_on' => Carbon::now()->format('Y-m-d H:i:s.u'),
          	'due_date' => Carbon::now()->addDays(30)->format('Y-m-d H:i:s.u'),
            'client_id' => $client -> id
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
      
      	$initializer = new LocalController;
      	$initializer->sendOrderInvoice($uuid, $request -> quantity);

      	return to_route('payment', ['order'=>$uuid]);
      
        // return to_route('client.dashboard') -> with('success', 'Your order has been successfully sent to us. Stay alert as we process it, we will get back to you soon.');
    }

    public function special_order (Request $request) {
        $client = DB::table('users') -> where('id', Auth::user() -> id) -> first();

        $order_data = $request -> validate([
            'product' => ['required'],
            'desc' => ['required'],
        ]);
      
      	$instance = new AdminController;
      	$uuid = $instance->genUUID();

        $order = [
          	'uuid'=>$uuid,
            'product' => $request -> product,
            'description' => $request -> desc,
            'client_names' => $client -> name,
            'client_email' => $client -> email,
            'client_phone' => $client -> phone,
            'client_id' => Auth::user() -> id,
        ];

        DB::table('special_orders') -> insert($order);
        return redirect() -> route('client.dashboard', compact('client')) -> with('sucess_order', 'Your order have been sucessfully received. We will get back to you soon through your email or your phone number!');

    }

    public function messages () {
        $messages = DB::table('messages') -> where('sender_id', Auth::user() -> id) -> get();

        return view('client.messages', compact('messages'));
    }

    public function profile () {
        return view('client.profile');
    }

    public function market_place (Request $request) {
        $products = DB::table('products') -> where('type', 'main') -> get();
        $categories = DB::table('categories') -> get();

        return view('client.market', compact('products', 'categories'));
    }

    public function market_sort (Request $request) {
        $products = DB::table('products') -> where('category', $request -> ctgr) -> get();
        $categories = DB::table('categories') -> get();
        $categorie = DB::table('categories') -> where('id', $request -> ctgr) -> first();

        return view('client.market-sort', compact('products', 'categories', 'categorie'));
    }

    public function address (Request $request) {
        $order = DB::table('orders') -> where('id', $request -> order_id) -> first();

        return view('client.address', compact('order'));
    }



    public function offload_order (Request $request) {
        DB::table('orders') -> where('id', $request -> order_id) -> where('client_id', Auth::user() -> id) -> update(['deletion_status' => 'Requested']);

        return back() -> with(['deletion_sucess' => 'Your order have been successfully deleted.', 'order_id' => $request -> order_id]);
    }

    public function offload_spcl (Request $request) {
        DB::table('special_orders') -> where('id', $request -> order_id) -> update(['deletion_status' => 'Requested']);

        return back() -> with(['deletion_success' => 'Your order have been successfully deleted.', 'order_id' => $request -> order_id]);
    }

    public function undo_delete (Request $request) {
        DB::table('orders') -> where('id', $request -> order_id) -> where('client_id', Auth::user() -> id) -> update(['deletion_status' => null]);

        return back() -> with('deletion_sucess', 'Your order have been successfully recovered.');
    }

    public function undo_spcl (Request $request) {
        DB::table('special_orders') -> where('id', $request -> order_id) -> where('client_id', Auth::user() -> id) -> update(['deletion_status' => null]);

        return back() -> with('deletion_success', 'Your order have been successfully recovered.');
    }

    public function update_order (Request $request) {
        date_default_timezone_set('Africa/Kigali');
        $delivery_address = $request -> validate([
            'city' => 'required',
            'sector' => 'required',
            'cell' => 'required',
            'village' => 'required',
            'address_details' => 'required',
        ]);

        DB::table('orders') -> where('id', $request -> order_id) -> update(['delivery_mode' => 'Door Step', 'd_city' => $request -> city, 'd_sector' => $request -> sector, 'd_cell' => $request -> cell, 'd_vilage' => $request -> village, 'd_desc' => $request -> address_details, 'updated_on' => now()->format('Y-m-d H:i:s.u')]);

        return redirect() -> route('client.dashboard') -> with('change_success', 'Your delivery option have been changed to Door Step sucessfully.');
    }

    public function client_message (Request $request) {
      
        $instance = new AdminController;
        $uuid = $instance->genUUID();

        $msg = [
            'uuid' => $uuid,
            'sender_id' => Auth::user() -> id,
            'message' => $request -> message,
            'sent_at' => now()->format('Y-m-d H:i:s.u'),
        ];

        DB::table('messages') -> insert([$msg]);
      	
      	$sender = User::find(Auth::user() -> id);
      	$url = url(route('messages.get', ['userId'=>Auth::user() -> id]));
      	$message = $request->message;
      	$sendTo = 'healthylifeinitiative2024@gmail.com';
        $senderNames = $sender->name;
		$replied = false;
      
      	$init = new LocalController;
      	$init->sendMessageToMail(
          			$sendTo,
          			$senderNames,
          			$message,
          			$replied,
          			$url
        		);

        return back();
    }

    public function remove_item_from_wishlist(Request $request) {
        $product = DB::table('products')->where('id', $request->idProduct)->first();
        $likedProducts = session()->get('liked_products', []);
    
        if (in_array($product->id, $likedProducts)) {
            $likedProducts = array_diff($likedProducts, [$product->id]);
            session()->put('liked_products', $likedProducts);
    
            if (Auth::user()) {
                DB::table('liked_products')
                    ->where('liked_by', Auth::user()->id)
                    ->where('product', $request->idProduct)
                    ->delete();
            } else {
                DB::table('liked_products')
                    ->where('liked_session', session()->getId())
                    ->where('product', $request->idProduct)
                    ->delete();
            }
            
            return back()->with('success', 'Product removed from your wishlist successfully!');
        }
    }

    public function products (Request $request) {

        $category = DB::table('categories') -> where('slag', $request -> category) -> first();
        $products = DB::table('products') -> where('category', $category -> id) -> where('type', 'main') -> get();

        return view('client.products', compact('category', 'products'));
    }
    }
