<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Products;



class ShareController extends Controller

{

    public $productFolder;

    public function __construct()

    {

        $this->productFolder = public_path('images/products');

        if(!file_exists($this->productFolder)){

            mkdir($this->productFolder);
        }

    }

    public function index($id)

    {

        $model = Products::findOrFail($id);

        return view('share.index', compact('model'));

    }

}

