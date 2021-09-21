<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected  $table = 'employees';

    public static $mainRules = [
        'email' => 'email|unique:users,email',
        'role' => 'required',
        'first_name' => 'required',
        'password' => 'nullable|between:3,30|confirmed',
        'password_confirmation' => 'same:password',
    ];

    public function userData(){
        return $this->belongsTo('App\Models\Users','user_id','id')->withDefault();
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

}
