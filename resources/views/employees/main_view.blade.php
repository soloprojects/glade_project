@extends('layouts.layout')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create Employee</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                
                                <div class="col-sm-4">
                                    <b>Email*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Password</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" class="form-control " value="" name="password" placeholder="Password" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Password Confirm</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" class="form-control " value="" name="password_confirmation" placeholder="Confirm Password" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                           
                            <div class="row clearfix">
                                
                                <div class="col-sm-4">
                                    <b>First Name*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="firstname" placeholder="Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Last Name*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="lastname" placeholder="lastname" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="company" >
                                                <option value="">Company</option>
                                                @foreach($companies as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                     </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_employee'); ?>','reload_data',
                            '<?php echo url('employee'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" style="height:500px; overflow:scroll;" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_employee'); ?>','reload_data',
                            '<?php echo url('employee'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Employees
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('employee'); ?>',
                                    '<?php echo url('delete_employee'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                      
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                              
                            </ul>
                        </li>

                    </ul>
                </div>

                <div class="body ">
                    
                <div class=" table-responsive" id="reload_data" >
                    <table class="table table-bordered table-hover table-striped tbl_order" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />
                    
                            </th>
                            <th>Manage</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                       
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />
                    
                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_employee_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>Edit</a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>                   
                                    <a href="#">
                                        <span class="alert-warning">{{$data->first_name}}</span>
                                    </a>
                            </td>
                            <td>                   
                                <a href="#">
                                    <span class="alert-warning">{{$data->last_name}}</span>
                                </a>
                            </td>
                            
                            <td>{{$data->userData->email}}</td>   
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>
                            
                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                    
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class=" pagination pull-right">
                        {!! $mainData->render() !!}
                    </div>

                </div>
              </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getData(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getData(page);
        //location.hash = page;
    });

    function getData(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

    <script>
        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            //page = window.location.hash.replace('#','');
            //getSearchData(page);
        });

        $(document).on('click','.search .pagination a', function(event){
            event.preventDefault();

            var page=$(this).attr('href').split('page=')[1];
            getSearchData(page);
            //location.hash = page;
        });

        function getSearchData(page){
            var searchVar = $('#search_user').val();

            $.ajax({
                url: '<?php echo url('search_user'); ?>?page=' + page +'&searchVar='+ searchVar
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

    </script>

    <script>
        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

@endsection