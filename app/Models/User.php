<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected  $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $mainRules = [
        'email' => 'email|unique:users,email',
        'name' => 'required',
        'password' => 'nullable|between:3,30|confirmed',
        'password_confirmation' => 'same:password',
    ];

    public static $mainRulesEdit = [
        'email' => 'email',
        'name' => 'required',
        'password' => 'nullable|between:3,30|confirmed',
        'password_confirmation' => 'same:password',
    ];

    public function roles(){
        return $this->belongsTo('App\Models\Roles','role_id','id')->withDefault();
    }

    public static function paginateAllData()
    {
        return static::where('role_id', 2)->orderBy('id','DESC')->paginate(10);
        //return Utility::paginateAllData(self::table());

    }

    public static function getAllData()
    {
        return static::where('role_id', 2)->orderBy('id','DESC')->get();

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
