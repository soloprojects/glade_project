<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Companies;
use App\Models\User;
use App\Models\Roles;
use App\Helpers\Utility;
use Auth;
use Log;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Mail;
use App\Mail\companyMail;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class CompaniesController extends Controller
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
        $mainData =  Companies::paginateAllData();


        if ($request->ajax()) {
            return \Response::json(view::make('Companies.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('Companies.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),Companies::$mainRules);
        if($validator->passes()){

                $dbDATA = [
                    'name' => ucfirst($request->input('name')),
                    'email' => ucfirst($request->input('email')),
                    'password' => Hash::make($request->input('password')),
                    'role_id' => Utility::company,                    
                    'remember_token' => $request->input('_token'),
                ];

                $createUser = User::create($dbDATA);

                $file = $request->file('logo');
                $attatchment = '';

            if($file != ''){
                
                    $file_name = time() . "_" . $file->getClientOriginalName() ."." .  $file->getClientOriginalExtension();

                    $file->move(
                        public_path('img') , $file_name
                    );
                    
                    $attachment =  $file_name;

            }

                $companyDATA = [
                    'name' => ucfirst($request->input('name')),
                    'user_id' => $createUser->id,
                    'website' => $request->input('website'),
                    'logo' => $attachment,
                    'created_by' => Auth::user()->id,             
                ];

                Companies::create($companyDATA);

                $details = [

                    'title' => 'Mail from Glade',
            
                    'body' => 'Your account has been created'
            
                ];
            
               
            
                Mail::to($request->input('email'))->send(new companyMail($details));

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

    public function companyDetail(Request $request)
    {
        //
        
        $Companies = Companies::firstRow('id',$request->input('dataId'));
        
        return view::make('Companies.detail')->with('edit',$Companies);

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
        
        $Companies = Companies::firstRow('id',$request->input('dataId'));
        //print_r($companies->userData->email);exit();
        return view::make('Companies.edit_form')->with('edit',$Companies);

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
        $validator = Validator::make($request->all(),Companies::$mainRulesEdit);
        if($validator->passes()) {

            $photo = $request->get('prev_photo');
            
            $new_password = Hash::make($request->input('password'));
            if($request->get('password') == ""){
                $new_password =  $request->input('prev_password');
            }
            Log::info($new_password);
            $dbDATA = [
                'name' => ucfirst($request->input('name')),
                'email' => ucfirst($request->input('email')),
                'password' => $new_password,
            ];

            User::defaultUpdate('id', $request->input('user_id'), $dbDATA);

            $file = $request->file('logo');
            $attachment = $request->get('prev_photo');

                
                
                if($file != ''){
                    if(file_exists(public_path('img').$request->get('prev_photo')))
                    unlink(public_path('img').$request->get('prev_photo'));

                    $file_name = time() . "_" . $file->getClientOriginalName() .Utility::generateUID(null, 10) . "." .  $file->getClientOriginalExtension();

                    $file->move(
                        public_path() , $file_name
                    );
                    
                    $attachment =  $file_name;

                }

                $companyDATA = [
                    'name' => ucfirst($request->input('name')),
                    'website' => Hash::make($request->input('lastname')),
                    'logo' => $attachment,
                    'updated_by' => Auth::user()->id,
                ];
        
                Companies::defaultUpdate('id', $request->input('edit_id'), $companyDATA);

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

            $getUser = Companies::firstRow('id',$id);
            
            $logo = (empty($getUser->logo)) ? 'logo.jpg' : $getUser->logo;
            if(file_exists(public_path('img').$getUser->logo))
            unlink(public_path('img').$logo);

            User::defaultDelete('id',$getUser->user_id);
            Companies::destroy($id);
            

            
        }

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    

}
