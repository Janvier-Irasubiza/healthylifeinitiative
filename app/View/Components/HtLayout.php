<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HtLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {

        if(Auth::user()) {
            $cart = DB::table('cart')->where('client', Auth::user()->id)->get();
        }

        else {
            $cart = session()->get('cart', []);
        }

        $slogans = DB::table('slogan')->get();

        return view('layouts.ht', ['cart'=>$cart, 'slogans'=>$slogans]);
    }
}
