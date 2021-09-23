<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
           
            <div class="col-sm-4">
                <b>Email*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="email" class="form-control" value="{{$edit->userData->email}}" name="email" placeholder="Email" required>
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
                        <input type="text" class="form-control" value="{{$edit->first_name}}" name="firstname" placeholder="Name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Last Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->last_name}}" name="lastname" placeholder="lastname" >
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="company" >
                            <option value="{{$edit->id}}">{{$edit->companyData->name}}</option>
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
    <input type="hidden" name="prev_password" value="{{$edit->userData->password}}" >
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    <input type="hidden" name="prev_photo" value="{{$edit->logo}}" >
    <input type="hidden" name="user_id" value="{{$edit->user_id}}" >
</form>
