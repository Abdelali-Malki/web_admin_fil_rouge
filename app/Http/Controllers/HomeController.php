<?php

namespace App\Http\Controllers;

use App\Models\Collections;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cat = count(Collections::all());
        $products = count(Products::all());
        $active_cat = count(Collections::where("status",1)->get());
        $inactive_active_cat = count(Collections::where("status",0)->get());
        $total_view = Products::pluck("total_view_count")->toArray();
        $total_download = Products::pluck("total_download_count")->toArray();
        $total_favourite = Products::pluck("total_heart_count")->toArray();

        $tv=array_sum($total_view);
        $td = array_sum($total_download);
        $tf = array_sum($total_favourite);

        return view('home',compact('cat','products','active_cat','inactive_active_cat','tv','td','tf'));
    }
}
