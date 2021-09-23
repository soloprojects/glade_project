<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employees;
use App\Models\Companies;
use App\Models\User;
use App\Models\Roles;
use App\Helpers\Utility;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class EmployeesController extends Controller
{

    public function __construct()

    {

        $this->middleware(['auth']);

    }
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData =  Employees::paginateAllData();
        $companies =  Companies::getAllData();


        if ($request->ajax()) {
            return \Response::json(view::make('Employees.reload',array('mainData' => $mainData,'companies' => $companies))->render());

        }else{
            return view::make('Employees.main_view')->with('mainData',$mainData)->with('companies',$companies);
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
        $validator = Validator::make($request->all(),Employees::$mainRules);
        if($validator->passes()){

                $dbDATA = [
                    'email' => ucfirst($request->input('email')),
                    'password' => Hash::make($request->input('password')),
                    'role_id' => Utility::employee,                    
                    'remember_token' => $request->input('_token'),
                ];

                $createUser = User::create($dbDATA);

               
                $employeeDATA = [
                    'user_id' => $createUser->id,
                    'first_name' => $request->input('firstname'),
                    'last_name' => $request->input('lastname'),
                    'company_id' => $request->input('company'),                    
                    'phone' => $request->input('phone'),
                ];

                Employees::create($employeeDATA);

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
        $companies = Companies::getAllData();
        $Employees = Employees::firstRow('id',$request->input('dataId'));
        return view::make('Employees.edit_form')->with('edit',$Employees)->with('companies',$companies);

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
        $validator = Validator::make($request->all(),Employees::$mainRulesEdit);
        if($validator->passes()) {

            $photo = $request->get('prev_photo');
            
            $new_password = Hash::make($request->input('password'));
            if($request->get('password') == ""){
                $new_password =  $request->input('prev_password');
            }
            
            $dbDATA = [
                'email' => ucfirst($request->input('email')),
                'password' => $new_password,
            ];

            User::defaultUpdate('id', $request->input('user_id'), $dbDATA);

            $file = $request->file('logo');
            $attatchment = $request->get('prev_photo');

                
                
                if($file != ''){

                    if(file_exists(public_path('img').$request->get('prev_photo')))
                    unlink(public_path('img').$request->get('prev_photo'));
                    
                    $file_name = time() . "_" . $file->getClientOriginalName() .Utility::generateUID(null, 10) . "." .  $file->getClientOriginalExtension();

                    $file->move(
                        public_path('img') , $file_name
                    );
                    
                    $attachment =  $file_name;

                }

                $employeeDATA = [
                    'first_name' => $request->input('firstname'),
                    'last_name' => $request->input('lastname'),
                    'company_id' => $request->input('company'),                    
                    'phone' => $request->input('phone'),
                ];
        
                Employees::defaultUpdate('id', $request->input('edit_id'), $employeeDATA);

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

            $getUser = Employees::firstRow('id',$id);
            
            User::defaultDelete('id',$getUser->user_id);
            Employees::destroy($id);
        }

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    

}
