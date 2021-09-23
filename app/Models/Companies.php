<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $guarded = [];
    

    protected  $table = 'companies';

    public static $mainRules = [
        'email' => 'email|unique:users,email',
        'name' => 'required',
        'logo' => 'sometimes|image|mimes:jpeg,jpg,png,bmp,gif,dimensions:min_width=100,min_height=100',
        'password' => 'required|between:3,30|confirmed',
        'password_confirmation' => 'required|same:password',
    ];

    public static $mainRulesEdit = [
        'email' => 'email',
        'name' => 'required',
        'logo' => 'sometimes|image|mimes:jpeg,jpg,png,bmp,gif,dimensions:min_width=100,min_height=200',
        'password' => 'nullable|between:3,30|confirmed',
        'password_confirmation' => 'sometimes|same:password',
    ];

    public function userData(){
        return $this->belongsTo('App\Models\User','user_id','id')->withDefault();
    }

    public function userCreateData(){
        return $this->belongsTo('App\Models\User','created_by','id')->withDefault();
    }

    public function userUpdateData(){
        return $this->belongsTo('App\Models\User','updated_by','id')->withDefault();
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
        return static::where($column, $post)->first();

    }

    public static function defaultUpdate($column, $postId, $arrayDataUpdate=[])
    {

        return static::where($column , $postId)->update($arrayDataUpdate);

    }

    public static function defaultDelete($column, $postId)
    {

        return static::where($column , $postId)->delete();

    }

}
