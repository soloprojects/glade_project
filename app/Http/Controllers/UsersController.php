<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Roles;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class UsersController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData =  User::paginateAllData();


        if ($request->ajax()) {
            return \Response::json(view::make('users.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('users.main_view')->with('mainData',$mainData);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),User::$mainRules);
        if($validator->passes()){

                $dbDATA = [
                    'email' => ucfirst($request->input('email')),
                    'password' => Hash::make($request->input('lastname')),
                    'role' => 2,                    
                    'remember_token' => $request->input('_token'),
                ];
                User::create($dbDATA);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);
        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $roles = Roles::getAllData();
        $user = User::firstRow('id',$request->input('dataId'));
        return view::make('users.edit_form')->with('edit',$user)->with('roles',$roles);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $validator = Validator::make($request->all(),User::$mainRules);
        if($validator->passes()) {

            $new_password = Hash::make($request->input('password'));
            if($request->get('password') == ""){
                $new_password =  $request->input('prev_password');
            }
            
            $dbDATA = [
                'email' => ucfirst($request->input('email')),
                'password' => $new_password,
            ];
        
                User::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
       
        foreach($idArray as $id){
            User::destroy($id);
        }

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    

}
