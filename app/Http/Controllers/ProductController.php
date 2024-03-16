<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    public function view()
    {
        return view('product');
    }

    public function get_price($portID)
    {
        $product=DB::Table('download_product')->where('id',$portID)->first();
        return $product;
    }


    public function adddata(Request $request)
    {
        dd($request->all());
    }
}
