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
                <b>Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name}}" name="name" placeholder="Name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Website</b>
                <div class="form-group">
                    <div class="form-line">
                    <input type="text" class="form-control" value="{{$edit->website}}" name="website" placeholder="website" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Logo</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="file" class="form-control" name="logo" placeholder="logo" >
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
