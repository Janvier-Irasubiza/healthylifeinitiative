<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    public function search (Request $request) {
        
        $searchQuery = $request->input('searchQuery');

        $results = DB::table('products') 
                        ->where('name', 'LIKE', "%$searchQuery%") 
                        ->orWhere('slag', 'LIKE', "%$searchQuery%") 
                        ->orWhere('description', 'LIKE', "%$searchQuery%") 
                        ->orWhere('motive', 'LIKE', "%$searchQuery%") 
                        ->get();
        return view('search-result', compact('results', 'searchQuery'));
    }
}
