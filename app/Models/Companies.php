<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected  $table = 'companies';

    public static $mainRules = [
        'email' => 'email|unique:users,email',
        'user_id' => 'required',
        'name' => 'required',
        'logo' => 'sometimes|image|mimes:jpeg,jpg,png,bmp,gif',
        'password' => 'nullable|between:3,30|confirmed',
        'password_confirmation' => 'same:password',
    ];

    public function userData(){
        return $this->belongsTo('App\Models\User','user_id','id')->withDefault();
    }

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
