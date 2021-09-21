<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected  $table = 'roles';

    public static function paginateAllData()
    {
        return static::orderBy('id','DESC')->paginate(10);
        //return Utility::paginateAllData(self::table());

    }

    public static function getAllData()
    {
        return static::orderBy('id','DESC')->get();

    }

    public static function firstRow($column, $post)
    {
        return static::where($column, '=',$post)->first();

    }

    public static function defaultUpdate($column, $postId, $arrayDataUpdate=[])
    {

        return static::where($column , $postId)->update($arrayDataUpdate);

    }

}
