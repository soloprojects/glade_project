<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected  $table = 'employees';

    public static $mainRules = [
        'email' => 'email|unique:users,email',
        'firstname' => 'required',
        'lastname' => 'required',
        'password' => 'required|between:3,30|confirmed',
        'password_confirmation' => 'same:password'
    ];

    public static $mainRulesEdit = [
        'email' => 'email',
        'firstname' => 'required',
        'lastname' => 'required',
        'password' => 'nullable|between:3,30|confirmed',
        'password_confirmation' => 'same:password'
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

    public function companyData(){
        return $this->belongsTo('App\Models\Companies','company_id','id')->withDefault();
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

    public static function defaultDelete($column, $postId)
    {

        return static::where($column , $postId)->delete();

    }

}
