<?php

namespace App\Models;

use App\Models\Collections;
use App\Models\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{

    use HasFactory;

    use SoftDeletes;

    protected $table = 'products';

    public static function genCollectionName($ids)
    {

        if ($ids != '') {

            $ids = explode(',', $ids);

            $msg = [];

            foreach ($ids as $id):

                if ($f = Collections::find(trim($id))) {
                    $msg[] = $f->name;
                }

            endforeach;

            if (count($msg) > 0) {

                $msg = implode(', ', $msg);

            } else {

                $msg = "-";

            }

            return $msg;

        }

        return '';

    }

    public static function genColorName($ids)
    {

        if ($ids != '') {

            $ids = explode(',', $ids);

            $msg = [];

            foreach ($ids as $id):

                if ($f = Color::find(trim($id))) {
                    $msg[] = $f->title;
                }

            endforeach;

            if (count($msg) > 0) {

                $msg = implode(', ', $msg);

            } else {

                $msg = "-";

            }

            return $msg;

        }

        return '';

    }

    public static function genTagName($tags)
    {

        if ($tags != '') {

            $tags = explode(',', $tags);

            $msg = [];

            foreach ($tags as $tag):

                $msg[] = $tag;

            endforeach;

            if (count($msg) > 0) {

                $msg = implode(', ', $msg);

            } else {

                $msg = "";

            }

            return $msg;

        }

        return '';

    }

}
