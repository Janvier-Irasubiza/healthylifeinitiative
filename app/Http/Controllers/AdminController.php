<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use DB;
use File;
use Carbon\Carbon;
use App\Mail\ApproveOrder;
use App\Mail\DenyOrder;
use App\Mail\CompleteOrder;
use Mail;

class AdminController extends Controller{
    public function dashboard() {
        date_default_timezone_set('Africa/Kigali');

        $categories = DB::table('categories')->orderBy('category', 'ASC')->get();
        $orders =  DB::table('user_requests')->where('progress', '<>', 'Completed')->orderBy('requested_on', 'DESC')->get();
        $spclOrders =  DB::table('special_orders')->where('status', '<>', 'Completed')->get();
      	// $products = [];
        // $sales = [];
        // $orders = [];
        // $spclOrders = [];
      	// $percentageIncrease = [];
      
        // start and end date for last month
        $lastMonthStartDate = Carbon::now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
        $lastMonthEndDate = Carbon::now()->subDay()->endOfDay()->format('Y-m-d H:i:s');

        // start and end date for the current month
        $currentMonthStartDate = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $currentMonthEndDate = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        foreach($categories as $key => $category) {
             $products[] = DB::table('products')->where('category', $category->id)->where('quantity', '>', 0)->get();
             $sales[] = DB::table('user_requests')->where('product_category', $category->id)->where('progress', 'Completed')->whereBetween('completed_on', [$currentMonthStartDate, $currentMonthEndDate])->get();

            // Count completed orders for last month
             $lastMonthCompletedOrdersCount = DB::table('user_requests')
                ->where('category', $category->id)
                ->where('progress', 'Completed')
                ->whereBetween('processed_on', [$lastMonthStartDate, $lastMonthEndDate])
                ->count();

            // Count completed orders for current month
            $currentMonthCompletedOrdersCount = DB::table('user_requests')
                ->where('category', $category->id)
                ->where('progress', 'Completed')
                ->whereBetween('processed_on', [$currentMonthStartDate, $currentMonthEndDate])
                ->count();

            // Calculate the percentage increase
            if ($lastMonthCompletedOrdersCount != 0) {
                $percentageIncrease[] = (($currentMonthCompletedOrdersCount - $lastMonthCompletedOrdersCount) / $lastMonthCompletedOrdersCount) * 100;
            } else {
                // Handle division by zero error if there are no completed orders in last month
                $percentageIncrease[] = 0;
            }
        }

        return view('admin.dashboard', compact('categories', 'products', 'sales', 'orders', 'spclOrders', 'percentageIncrease'));
    }

    public function products () {
        $products = DB::table('products')->whereNull('delete_status')->get();
      	$category = [];
        
        foreach ($products as $key => $product) {
            $category[] = DB::table('categories')
                            ->where('id', $product->category)
                            ->first();
        }
        return view('admin.products', compact('products', 'category'));
    }
  
    public function genUUID($data = null) {

          $data = $data ?? random_bytes(16);
          assert(strlen($data) == 16);
          $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
          $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

          return  vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

      }

    public function addItems(Request $request) {

        $product = DB::table('products')
                        ->where('id', $request->product)
                        ->first();

        $quantity = $product->quantity + $request->quantity;

        DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'quantity' => $quantity
            ]);
        return back();
    }

    public function promote(Request $request) {

        DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'promo_price' => $request->promo_price
            ]);
        return back();
    }

    public function unPromote(Request $request) {

        DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'promo_price' => null
            ]);
        return back();
    }

    public function new_product (Request $request) {
        $categories = DB::table('categories')->orderBy('category', 'ASC')->get();
        return view('admin.new-product', ['selecetdCategory' => $request->category], compact('categories'));
    }

    public function postNewProduct(Request $request) {
        $product = $request -> validate([
            'name' => 'required',
            'slag' => 'required',
            'category' => 'required',
            'quantity' => 'required',
            'quantity_unit' => 'required',
            'price' => 'required',
            'description' => 'required',
            'motive' => 'required',
          	'added_value' => 'required',
          	'life_benefits' => 'required',
            'poster' => 'required',
            'pic1' => 'required',
            'pic2' => 'required',
            'pic3' => 'required',
            'pic4' => 'required',
            'pic5' => 'required',
            'pic6' => 'required',
        ]);

            $poster = $request -> file('poster') -> getClientOriginalName();
            $pic1 = $request -> file('pic1') -> getClientOriginalName();
            $pic2 = $request -> file('pic2') -> getClientOriginalName();
            $pic3 = $request -> file('pic3') -> getClientOriginalName();
            $pic4 = $request -> file('pic4') -> getClientOriginalName();
            $pic5 = $request -> file('pic5') -> getClientOriginalName();
            $pic6 = $request -> file('pic6') -> getClientOriginalName();

            $request -> file('poster') -> move(public_path('images/products/'), $poster);
            $request -> file('pic1') -> move(public_path('images/products/'), $pic1);
            $request -> file('pic2') -> move(public_path('images/products/'), $pic2);
            $request -> file('pic3') -> move(public_path('images/products/'), $pic3);
            $request -> file('pic4') -> move(public_path('images/products/'), $pic4);
            $request -> file('pic5') -> move(public_path('images/products/'), $pic5);
            $request -> file('pic6') -> move(public_path('images/products/'), $pic6);

			$uuid = $this->genUUID();
      
            $productInfo = [
              	'uuid'=>$uuid,
                'name' => $request->name,
                'slag' => $request->slag,
                'category' => $request->category,
                'quantity' => $request->quantity,
                'quantity_unit' => $request->quantity_unit,
                'price' => $request->price,
                'description' => $request->description,
                'motive' => $request->motive,
              	'added_value' => $request->added_value,
              	'life_benefits' => $request->life_benefits,
                'poster' => $poster,
                'pic1' => $pic1,
                'pic2' => $pic2,
                'pic3' => $pic3,
                'pic4' => $pic4,
                'pic5' => $pic5,
                'pic6' => $pic6,
            ];

            DB::table('products')->insert($productInfo);

            return to_route('admin.dashboard')->with('success', $request->pname.' successfully added!');
    }

    public function newCategory (Request $request) {
        return view('admin.new-category');
    }

    public function edit_product (Request $request) {
        $product = DB::table('products')->where('uuid', $request->product)->first();
        $categories = DB::table('categories')->orderBy('category', 'ASC')->get();
        return view('admin.edit-product', ['product'=>$product, 'categories'=>$categories]);
    }

    public function editProductInfo(Request $request) {
        
        $product = $request -> validate([
            'name' => 'required',
            'slag' => 'required',
            'category' => 'required',
            'quantity' => 'required',
            'quantity_unit' => 'required',
            'price' => 'required',
            'description' => 'required',
            'motive' => 'required',
            'added_value' => 'required',
            'life_benefits' => 'required',
        ]);

        $poster = '';
        $banner ='';
        $pic1 = '';
        $pic2 ='';
        $pic3 = '';
        $pic4 = '';
        $pic5 = '';
        $pic6 = '';

        $productInfo = DB::table('products')->where('id', $request->product)->first();

        if($request->hasFile('poster')) {
            $poster = $request -> file('poster') -> getClientOriginalName();
            if (File::exists(public_path('images/products/'.$productInfo -> poster))) {
                File::delete(public_path('images/products/'.$productInfo -> poster));
                $request -> file('poster') -> move(public_path('images/products/'), $poster);
            }
            else {
                $request -> file('poster') -> move(public_path('images/products/'), $poster);
            }
            DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'poster' =>  $poster,
            ]);
        }

        if($request->hasFile('pic1')) {
            $pic1 = $request -> file('pic1') -> getClientOriginalName();
            if (File::exists(public_path('images/products/'.$productInfo -> pic1))) {
                File::delete(public_path('images/products/'.$productInfo -> pic1));
                $request -> file('pic1') -> move(public_path('images/products/'), $pic1);
            }
            else{
                $request -> file('pic1') -> move(public_path('images/products/'), $pic1);
            }

            DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'pic1' =>  $pic1,
            ]);

        }

        if($request->hasFile('pic2')) {
            $pic2 = $request -> file('pic2') -> getClientOriginalName();
            if (File::exists(public_path('images/products/'.$productInfo -> pic2))) {
                File::delete(public_path('images/products/'.$productInfo -> pic2));
                $request -> file('pic2') -> move(public_path('images/products/'), $pic2);
            }
            else {
                $request -> file('pic2') -> move(public_path('images/products/'), $pic2);
            }
            DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'pic2' =>  $pic2,
            ]);
        }

        if($request->hasFile('pic3')) {
            $pic3 = $request -> file('pic3') -> getClientOriginalName();
            if (File::exists(public_path('images/products/'.$productInfo -> pic3))) {
                File::delete(public_path('images/products/'.$productInfo -> pic3));
                $request -> file('pic3') -> move(public_path('images/products/'), $pic3);
            }
            else {
                $request -> file('pic3') -> move(public_path('images/products/'), $pic3);
            }

            DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'pic3' =>  $pic3,
            ]);
        }

        if($request->hasFile('pic4')) {
            $pic4 = $request -> file('pic4') -> getClientOriginalName();
            if (File::exists(public_path('images/products/'.$productInfo -> pic4))) {
                File::delete(public_path('images/products/'.$productInfo -> pic4));
                $request -> file('pic4') -> move(public_path('images/products/'), $pic4);
            }
            else {
                $request -> file('pic4') -> move(public_path('images/products/'), $pic4);
            }
            DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'pic4' =>  $pic4,
            ]);
        }

        if($request->hasFile('pic5')) {
            $pic5 = $request -> file('pic5') -> getClientOriginalName();
            if (File::exists(public_path('images/products/'.$productInfo -> pic5))) {
                File::delete(public_path('images/products/'.$productInfo -> pic5));
                $request -> file('pic5') -> move(public_path('images/products/'), $pic5);
            }
            else {
                $request -> file('pic5') -> move(public_path('images/products/'), $pic5);
            }
            DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'pic5' =>  $pic5,
            ]);
        }

        if($request->hasFile('pic6')) {
            $pic6 = $request -> file('pic6') -> getClientOriginalName();
            if (File::exists(public_path('images/products/'.$productInfo -> pic6))) {
                File::delete(public_path('images/products/'.$productInfo -> pic6));
                $request -> file('poster') -> move(public_path('images/products/'), $pic6);
            }
            else {
                $request -> file('pic6') -> move(public_path('images/products/'), $pic6);
            }
            DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'pic6' =>  $pic6,
            ]);
        }

        if($request->hasFile('banner')) {
            $banner = $request -> file('banner') -> getClientOriginalName();
            if (File::exists(public_path('images/products/'.$productInfo -> banner))) {
                File::delete(public_path('images/products/'.$productInfo -> banner));
                $request -> file('banner') -> move(public_path('images/products/'), $banner);
            }
            else {
                $request -> file('banner') -> move(public_path('images/products/'), $banner);
            }
            DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'banner' =>  $banner,
            ]);
        }

        DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update([
                'name' =>  $request->name,
                'slag' =>  $request->slag,
                'category' =>  $request->category,
                'quantity' =>  $request->quantity,
                'quantity_unit' =>  $request->quantity_unit,
                'price' =>  $request->price,
                'description' =>  $request->description,
                'motive' =>  $request->motive,
              	'added_value' => $request->added_value,
            	'life_benefits' => $request->life_benefits,
            ]);

        return back()->with('success', 'successfully edited '.$productInfo->name. ' info');;
    }

    public function orders () {
        $orders =  DB::table('user_requests')->orderBy('requested_on', 'ASC')->get();
        $spclOrders =  DB::table('special_orders')->get();
        $inProcessOrders =  DB::table('user_requests')->where('progress', 'In Process')->get();

        return view ('admin.orders', compact('orders', 'spclOrders', 'inProcessOrders'));
    }

    public function orderInfo (Request $order) {
        $order = DB::table('user_requests')->where('order_uuid', $order->order)->first();
        return view('admin.order', ['order' => $order]); 
    }

    public function approveOrder(Request $request) {
        DB::table('orders')
            ->limit(1)
            ->where('id', $request->order)
            ->update([
                'progress'=>'In process'
            ]);
      
      	$orderInfo = DB::table('orders') -> where('id', $request -> order) -> first();
      	$clientName = $orderInfo -> client_names;
      	$status = $orderInfo -> progress;
      	$productOrdered = DB::table('products') -> where('id', $orderInfo -> product) -> select('name') -> first();
      	$prodName = $productOrdered -> name;
      	$url = url(route('client.dashboard'));
      
      	Mail::to($orderInfo -> client_email) -> send(new ApproveOrder($clientName, $status, $url, $prodName));
      
      
        return back();
    }

    public function orderApprove(Request $request) {
        DB::table('orders')
            ->limit(1)
            ->where('id', $request->order)
            ->update([
                'progress'=>'In process', 
                'd_desc' => $request->address
        ]);
      
      	$orderInfo = DB::table('orders') -> where('id', $request -> order) -> first();
      	$clientName = $orderInfo -> client_names;
      	$status = $orderInfo -> progress;
      	$productOrdered = DB::table('products') -> where('id', $orderInfo -> product) -> select('name') -> first();
      	$prodName = $productOrdered -> name;
      	$url = url(route('client.dashboard'));
      
      	Mail::to($orderInfo -> client_email) -> send(new ApproveOrder($clientName, $status, $url, $prodName));
      
        return back();
    }

    public function completeOrder(Request $request) {
        date_default_timezone_set('Africa/Kigali');

        DB::table('orders')
            ->limit(1)
            ->where('id', $request->order)
            ->update([
                'progress'=>'Completed', 
                'completed_on' => now()->format('Y-m-d H:i:s.u'),
        ]);
      
      	$orderInfo = DB::table('orders') -> where('id', $request -> order) -> first();
      	$clientName = $orderInfo -> client_names;
      	$status = $orderInfo -> progress;
      	$productOrdered = DB::table('products') -> where('id', $orderInfo -> product) -> select('name') -> first();
      	$prodName = $productOrdered -> name;
      	$url = url(route('client.dashboard'));
      
      	Mail::to($orderInfo -> client_email) -> send(new CompleteOrder($clientName, $status, $url, $prodName));
      
        return back();
    }

    public function completeSpecialOrder(Request $request) {
        date_default_timezone_set('Africa/Kigali');

        DB::table('special_orders')
            ->limit(1)
            ->where('id', $request->order)
            ->update([
                'status'=>'Completed', 
                'completed_on' => now()->format('Y-m-d H:i:s.u'),
        ]);
      
      	$orderInfo = DB::table('special_orders') -> where('id', $request -> order) -> first();
      	$clientName = $orderInfo -> client_names;
      	$status = $orderInfo -> status;
      	$prodName = $orderInfo->product;
      	$url = url(route('client.dashboard'));
      
      	Mail::to($orderInfo -> client_email) -> send(new CompleteOrder($clientName, $status, $url, $prodName));
      
        return back();
    }

    public function spclOrderApprove(Request $request) {
        DB::table('special_orders')
            ->limit(1)
            ->where('id', $request->order)
            ->update([
                'status'=>'In process', 
                'notes' => $request->notes
        ]);
      
      	$orderInfo = DB::table('special_orders') -> where('id', $request -> order) -> first();
      	$clientName = $orderInfo -> client_names;
      	$status = $orderInfo -> status;
      	$prodName = $orderInfo->product;
      	$note = $request->notes;
      	$url = url(route('client.dashboard'));
            
      	Mail::to($orderInfo -> client_email) 
          		-> send(new ApproveOrder(
                  				$clientName, 
                  				$status, 
                  				$url, 
                  				$prodName, 
                  				$note));
      
        return back();
    }

    public function denyOrder(Request $request) {
        DB::table('orders')
            ->limit(1)
            ->where('id', $request->order)
            ->update([
                'progress'=>'Denied', 
                'reason_to_deny'=>$request->deny_reason
            ]);
      
      	$orderInfo = DB::table('orders') -> where('id', $request -> order) -> first();
      	$clientName = $orderInfo -> client_names;
      	$status = $orderInfo -> progress;
      	$productOrdered = DB::table('products') -> where('id', $orderInfo -> product) -> select('name') -> first();
      	$prodName = $productOrdered -> name;
      	$reason = $request -> deny_reason;
      	$url = url(route('client.dashboard'));
      
      	Mail::to($orderInfo -> client_email) -> send(new DenyOrder($clientName, $status, $url, $prodName, $reason));
      
        return back();
    }

    public function denySpclOrder(Request $request) {
        DB::table('special_orders')
            ->limit(1)
            ->where('id', $request->order)
            ->update([
                'status'=>'Denied', 
                'notes' => $request->deny_reason
            ]);
      
      	$orderInfo = DB::table('special_orders') -> where('id', $request -> order) -> first();
      	$clientName = $orderInfo -> client_names;
      	$status = $orderInfo -> status;
      	$prodName = $orderInfo->product;
      	$reason = $request -> deny_reason;
      	$url = url(route('client.dashboard'));
      
      	Mail::to($orderInfo -> client_email) -> send(new DenyOrder($clientName, $status, $url, $prodName, $reason));
      
        return back();
    }

    public function undoDenyOrder(Request $request) {
        DB::table('orders')
            ->limit(1)
            ->where('id', $request->order)
            ->update([
                'progress'=>'Pending', 
                'reason_to_deny'=>null
            ]);
        return back();
    }

    public function undoDenySpclOrder(Request $request) {
        DB::table('special_orders')
            ->limit(1)
            ->where('id', $request->order)
            ->update([
                'status'=>'pending', 
                'notes'=>null
            ]);
        return back();
    }

    public function deleteProduct(Request $request) {
        $product = DB::table('products')
            ->where('id', $request->product)
            ->first();

        DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update(['delete_status' => 'deleted']);
        return back()->with(['success' => $product->name.' successfully deleted', 'undo' => 'yes', 'product'=>$product->id]);
    }

    public function undoDeleteProduct(Request $request) {
        $product = DB::table('products')
            ->where('id', $request->product)
            ->first();

        DB::table('products')
            ->limit(1)
            ->where('id', $request->product)
            ->update(['delete_status' => null]);
        return back()->with(['success' => $product->name.' successfully recovered']);;
    }

    public function special_order_info (Request $request) {
        $order = DB::table('special_orders')
            ->where('uuid', $request->order)
            ->first();
        return view('admin.special-order', ['order' => $order]); 
    }

    public function clients () {
        $pendingClients = DB::table('user_requests')
                ->select('*', DB::raw('count(*) as orders_count'))
                ->whereNotNull('client_id')
                ->where('progress', 'Pending')
                ->groupBy('client_id')
                ->get();

        $ServedClients = DB::table('user_requests')
                        ->select('*', DB::raw('count(*) as orders_count'))
                        ->whereNotNull('client_id')
                        ->where('progress', 'Completed')
                        ->groupBy('client_id')
                        ->get();

        return view('admin.clients', compact('pendingClients', 'ServedClients'));
    }

    public function client (Request $request) {
        $client = User::find($request->client);
        $orders = DB::table('user_requests')
                ->where('client_id', $request->client)
                ->get();

        return view('admin.client', compact('client', 'orders'));
    }

    public function messages () { 
        $messages = DB::table('chats')
                    ->select('*', DB::raw('MAX(sent_at) as latest_message_date'))
                    ->whereIn('id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                              ->from('chats')
                              ->groupBy('sender');
                    })
                    ->groupBy('sender')
                    ->orderBy('sent_at', 'desc')
                    ->get();
        return view('admin.messages', compact('messages'));
    }

    public function getAllMessages($userId) {
        $user = User::find($userId);
        $userMessages = DB::table('chats')
                        ->where('sender', $userId)
                        ->orderBy('sent_at', 'asc')
                        ->get(['id', 'message', 'reply', 'sent_at']);

        $lastMessage = $userMessages->last();

        DB::table('messages')
                ->where('sender_id', $userId)
                ->where('id', $lastMessage->id)
                ->limit(1)
                ->update(['is_read' => 'yes',]);

        return view('partials.messages', compact('userMessages', 'user'));
    }

    public function latestMessages() {
        $messages = DB::table('chats')
                    ->select('*', DB::raw('MAX(sent_at) as latest_message_date'))
                    ->whereIn('id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                            ->from('chats')
                            ->groupBy('sender');
                    })
                    ->groupBy('sender')
                    ->orderBy('sent_at', 'desc')
                    ->get();
        return response()->json($messages);
    }

    public function loadNewMessages() {
        $newMessages = DB::table('chats')
            ->where('sent_at', '>', Carbon::now()->subSeconds(1))
            ->get();
        return response()->json($newMessages);
    }

    public function reply(Request $request) {

        date_default_timezone_set('Africa/Kigali');

        $messages = DB::table('chats')
                    ->where('sender', $request->sender)
                    ->orderBy('sent_at', 'desc')
                    ->first();

        $reply = is_null($messages->reply) ? $request->message : $messages->reply . '::;;'.$request->message;

        DB::table('messages')
            ->limit(1)
            ->where('id', $messages->id)
            ->where('sender_id', $messages->sender)
            ->update([
                'reply' => $reply,
                'replied_at' => now()->format('Y-m-d H:i:s.u'),
            ]);
      
      	$url = url(route('client.messages'));
      	$message = $request->message;
      	$sendTo = $messages->email;
        $senderNames = 'Healthy Life Initiative Ltd.';
		$replied = true;
      
      	$init = new LocalController;
      	$init->sendMessageToMail(
          			$sendTo,
          			$senderNames,
          			$message,
          			$replied,
          			$url
        		);

        return response()->json(['success' => true, 'message' => 'Message sent successfully']);
    }

    public function profile () {
        return view('admin.profile');
    }

    public function posting () {
        $posters = DB::table('posters') 
                    -> get();
        $slogans = DB::table('slogan')
                    ->get();

        return view('admin.posting', ['posters'=>$posters, 'slogans'=>$slogans]);
    }

    public function new_poster () {
        return view('admin.new-poster');
    }

    public function editPoster (Request $request) {
        $poster = DB::table('posters')
                        ->where('id', $request->poster)
                        ->first();
        return view('admin.edit-poster', ['poster' => $poster]);
    }

    public function create_poster (Request $request) {
        $new_poster = $request -> validate ([
            'img' => 'required',
            'name' => 'required',
            'desc' => 'required',
        ]);

        $photo = $request -> file('img') -> getClientOriginalName();

        $poster = [
            'photo' => $photo,
            'name' => $request -> name,
            'description' => $request -> desc,
            'created_on' => now()->format('Y-m-d H:i:s.u'),
        ];

        if(DB::table('posters') -> insert($poster)){
            $request -> file('img') -> move(public_path('images/posters/'), $photo);
        }
        
        return redirect() -> route('admin.posting') -> with('success', 'Poster successfully created.');
    }

    public function editPosterInfo (Request $request) {
        $new_poster = $request -> validate ([
            'name' => 'required',
            'desc' => 'required',
        ]);

        $posterInfo = DB::table('posters')->where('id', $request->poster)->first();
        $poster = [];
      
        if($request -> hasFile('img')) {

            $photo = $request -> file('img') -> getClientOriginalName();
            if (File::exists(public_path('images/posters/'.$posterInfo->photo))) {
                File::delete(public_path('images/posters/'.$posterInfo->photo));
            }

            $request -> file('img') -> move(public_path('images/posters/'), $photo);

            $poster = [
                'photo' => $photo,
                'name' => $request -> name,
                'description' => $request -> desc,
                'created_on' => now()->format('Y-m-d H:i:s.u'),
            ];
        }

        else {
            $poster = [
                'name' => $request -> name,
                'description' => $request -> desc,
                'created_on' => now()->format('Y-m-d H:i:s.u'),
            ];
        }

        DB::table('posters')
            ->limit(1)
          	->where('id', $request->poster)
            ->update($poster);
        
        return redirect() -> route('admin.posting') -> with('success', $request -> name.' Poster successfully edited.');
    }

    public function del_poster (Request $request) {
        DB::table('posters') 
            ->limit(1)
            ->delete($request -> poster_id);

        return back() -> with('success', 'Poster was deleted sucessfully.');
    }

    public function editSlogan (Request $request) {
        $slogan = DB::table('slogan')
                        ->where('id', $request->slogan)
                        ->first();
        return view('admin.edit-slogan', ['slogan' => $slogan]);
    }

    public function editSloganInfo (Request $request) {
        $request -> validate ([
            'headline' => 'required',
            'desc' => 'required',
        ]);

        $slogan = DB::table('slogan')
                    ->limit(1)
                    ->where('id', $request->slogan)
                    ->update([
                        'headline' => $request->headline,
                        'description' => $request->desc,
                    ]);
                
        return to_route('admin.posting')->with('success', 'Slogan successfully updated');
    }

    
    public function createCategory (Request $request) {
        $product = $request -> validate([
            'category' => 'required',
            'slag' => 'required',
            'poster' => 'required',
            'banner' => 'required',
        ]);

        $poster = $request -> file('poster') -> getClientOriginalName();
        $banner = $request -> file('banner') -> getClientOriginalName();

        $request -> file('poster') -> move(public_path('images/products/categories/'), $poster);
        $request -> file('banner') -> move(public_path('images/products/categories/'), $banner);
      
		$uuid = $this->genUUID();

        DB::table('categories')->insert([
            'uuid'=>$uuid,
            'category' => $request->category,
            'slag' => $request->slag,
            'poster' => $poster,
            'banner' => $banner,
        ]);

        return to_route('admin.dashboard')->with('success', $request->category.' category successfully added');
    }

    public function EditCategory (Request $request) {
        $product = $request -> validate([
            'category' => 'required',
            'slag' => 'required',
        ]);

        $category = DB::table('categories')
                        ->where('id', $request->id)
                        ->first();

        $categoryInfo = [];

        if($request -> hasFile('poster') && $request -> hasFile('banner')) {

            $poster = $request -> file('poster') -> getClientOriginalName();
            $banner = $request -> file('banner') -> getClientOriginalName();

            if (File::exists(public_path('images/products/categories/'.$category -> poster))) {
                File::delete(public_path('images/products/categories/'.$category -> poster));
            }
            if (File::exists(public_path('images/products/categories/'.$category -> banner))) {
                File::delete(public_path('images/products/categories/'.$category -> banner));
            }
            $request -> file('banner') -> move(public_path('images/products/categories/'), $banner);
            $request -> file('poster') -> move(public_path('images/products/categories/'), $poster);

            $categoryInfo = [
                'category' => $request->category,
                'slag' => $request->slag,
                'poster' => $poster,
                'banner' => $banner,
            ];
        }

        elseif($request -> hasFile('poster')) {
            $poster = $request -> file('poster') -> getClientOriginalName();
            if (File::exists(public_path('images/products/categories/'.$category -> poster))) {
                File::delete(public_path('images/products/categories/'.$category -> poster));
            }
            $request -> file('poster') -> move(public_path('images/products/categories/'), $poster);

            $categoryInfo = [
                'category' => $request->category,
                'slag' => $request->slag,
                'poster' => $poster,
            ];
        }

        elseif ($request -> hasFile('banner')) {
            $banner = $request -> file('banner') -> getClientOriginalName();

            if (File::exists(public_path('images/products/categories/'.$category -> banner))) {
                File::delete(public_path('images/products/categories/'.$category -> banner));
            }
            $request -> file('banner') -> move(public_path('images/products/categories/'), $banner);

            $categoryInfo = [
                'category' => $request->category,
                'slag' => $request->slag,
                'banner' => $banner,
            ];
        }

        else{
            $categoryInfo = [
                'category' => $request->category,
                'slag' => $request->slag,
            ];
        }
        
        DB::table('categories')
            ->limit(1)
            ->where('id', $category->id)
            ->update($categoryInfo);

        return to_route('admin.dashboard')->with('success', 'Category successfully edited');
    }

    public function CategoryForm (Request $request) {
        $category = DB::table('categories')
                        ->where('uuid', $request->c)
                        ->first();
        return view('admin.edit-category', ['category'=>$category]);
    }
}
