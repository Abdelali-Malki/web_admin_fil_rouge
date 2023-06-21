<?php

namespace App\Http\Controllers;

use App\Models\Collections;
use App\Models\Products;
use Illuminate\Http\Request;

use App\Components\Reports;

class AjaxController extends Controller
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

    

    public function viewline(Request $request){
        

        $report = new Reports;


        $chart = [];
        $chart['chart'] = ['type'=>'area', 'height'=>350];
        $chart['dataLabels'] = ['enabled'=>false];

        $chart['series'][] = [
            'name'=>'View',
            'data'=>$report->genViewLine($request->chart_data_type, $request->from_date, $request->to_date)
        ];
        $chart['series'][] = [
            'name'=>'Download',
            'data'=>$report->genDownloadLine($request->chart_data_type, $request->from_date, $request->to_date)
        ];
        $chart['markers']=[
            "size"=>[0]
        ];
        $chart['xaxis'] = [
            'categories'=>$report->genDay($request->chart_data_type, $request->from_date, $request->to_date)
        ];
        return response()->json($chart);
    }
}
