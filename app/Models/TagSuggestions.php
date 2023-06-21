<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagSuggestions extends Model
{
    use HasFactory;

    protected $table = 'tag_suggestions';

    public static function generate($tags){
        $count = 0;
        if(is_array($tags)){
            foreach($tags as $tag):
                $tag = strtolower($tag);
                $exits = self::where('name',$tag)->exists();
                if(!$exits){
                    $model = new self();
                    $model->name = trim($tag);
                    $model->save();
                    $count++;
                }
            endforeach;
        }
        return $count;
    }

    public static function increaseHit($tag){
        $check = self::where('name',trim(strtolower($tag)));
        if($check->exists()){
            $model = $check->first();
            $model->hit = $model->hit + 1;
            $model->last_hit_datetime = date("Y-m-d H:i:s");
            $model->save();
        }
    }
}
