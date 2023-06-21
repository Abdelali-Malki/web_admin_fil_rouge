<?php
namespace App\Components;

use App\Models\Products;
use App\Models\Statisics;
use DB;

class Reports{

    public function __construct()
    {

    }

    public function genDay($chart_data_type, $from_date, $to_date){
        $d=[];
        if($chart_data_type=='custom'){

            $begin = new \DateTime( date("Y-m-d", strtotime($from_date)) );
            $end   = new \DateTime( date("Y-m-d", strtotime($to_date)) );

            for($i = $begin; $i <= $end; $i->modify('+1 day')){
                $d[]=$i->format("d-m-Y");
            }

        }else if($chart_data_type=='year'){
            for($i=1; $i<=12; $i++): 
                $d[]=date("F",strtotime("2020-{$i}-1"));
            endfor;
        }else{
            for($i=1; $i<=date('t'); $i++): 
                $d[]=$i;
            endfor;
        }
        
        return $d;
    }

    public function genViewLine($chart_data_type, $from_date, $to_date){
        $days = $this->genDay($chart_data_type, $from_date, $to_date);
        $data = [];
        foreach($days as $day):
            if($chart_data_type=='custom')
                $data[] = $this->getProductCountByType(date("Y-m-d", strtotime($day)), '', 'Product-View');
            else if($chart_data_type=='month')
                $data[] = $this->getProductCountByType(date("Y-m-{$day}"), '', 'Product-View');
            else{
                $dd = \date_parse($day)['month'];
                $data[] = $this->getProductCountByType(date("Y-{$dd}-01"), date("Y-{$dd}-t"), 'Product-View');
            }
        endforeach;
        return $data;
    }

    public function genDownloadLine($chart_data_type, $from_date, $to_date){
        $days = $this->genDay($chart_data_type, $from_date, $to_date);
        $data = [];
        foreach($days as $day):
            if($chart_data_type=='custom')
                $data[] = $this->getProductCountByType(date("Y-m-d", strtotime($day)), '', 'Product-Download', 'Set-Wallpaper', 'Set-Lock-Screen', 'Set-Both');
            else if($chart_data_type=='month')
                $data[] = $this->getProductCountByType(date("Y-m-{$day}"), '', 'Product-Download', 'Set-Wallpaper', 'Set-Lock-Screen', 'Set-Both');
            else{
                $dd = \date_parse($day)['month'];
                $data[] = $this->getProductCountByType(date("Y-{$dd}-01"), date("Y-{$dd}-t"), 'Product-Download', 'Set-Wallpaper', 'Set-Lock-Screen', 'Set-Both');
            }
        endforeach;
        return $data;
    }

    public function getProductCountByType($from, $to, ...$params){

        $from = date("Y-m-d 00:00:00",strtotime($from));
        if($to!='')
            $to = date("Y-m-d 23:59:59",strtotime($to));
        else
            $to = date("Y-m-d 23:59:59",strtotime($from));

        $q = DB::table('statistics')
        ->where(function($query) use ($params){
            foreach($params as $param):
                $query->orWhere('action_type', 'LIKE', '%'.$param.'%');
            endforeach;
        })
        ->whereBetween('created_at', [$from, $to])
        ->count();

        return $q;
    }

}