<table class="table table-bordered table-hover table-striped tbl_order" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
    @if($data->role == 1  || Auth::user()->id == $data->id)
    @else
    <tr>
        <td scope="row">
            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

        </td>
        <td>
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_user_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>
            @if($data->active_status == 1)
            <a href="#">{{$data->title}}&nbsp;{{$data->firstname}}&nbsp;{{$data->othername}}&nbsp;{{$data->lastname}}</a>
            @else
                <a href="#">
                    <span class="alert-warning">{{$data->title}}&nbsp;{{$data->firstname}}&nbsp;{{$data->othername}}&nbsp;{{$data->lastname}}</span>
                </a>
            @endif
        </td>
        
        <td>{{$data->email}}</td>                           
        <td>{{$data->roles->role_name}}</td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->updated_at}}</td>
        <td>
            @if($data->sign != '')
            <img src="{{ asset('images/'.$data->sign) }}" width="72" height="60" alt="User" />
            @else
            No signature yet
            @endif
        </td>
        <td><img src="{{ asset('images/'.$data->photo) }}"  alt="User" /></td>

        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

    </tr>
    @endif
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>

