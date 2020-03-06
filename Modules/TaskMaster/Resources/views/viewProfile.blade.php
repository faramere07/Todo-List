@extends('taskmaster::layouts.master')

@section('content')


@if(session('success'))
    <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
         <strong>{{ session('success') }}</strong>
    </div>
@endif

   
  <div class="container"  style="margin-top: 100px; ">
        <div class="form-row">
          <div class="col-md-2">
          </div>
          <div class="col-md-8">
            <div class="card" style="width: 100%;">
              <h5 class="card-header">About Me <button type="button" class="btn btn-outline-primary float-right editProfile" id="addBtn"  >Edit profile</button></h5>
              <div class="card-body" style="width: 100%;">
                <div class='form-row container'>
                  <div class="col-md-4">
                    <img class="img-fluid img-thumbnail"  src="{{ asset('images/'.$userDetails->profile_picture) }}" alt="Card image cap">
                  </div>
                  <div class="col-md-8">
                <label>Name:</label>
                <pre>     {{$userDetails->first_name}} {{$userDetails->mid_name}} {{$userDetails->last_name}}</pre>
                <br>

              </div>
                </div>
              </div>
              </div>
            </div>
        </div>

      <br>
  </div>
  



    <!-- Modal for Adding -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form  id="editForm" method="POST"  action="{{ route('editProfileTaskMaster') }}"$ enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
             
              

            </div>

            <div class="modal-footer">
             
                  <input type="hidden" name="date" id="dateAdd">
                  <button type="submit" class="btn btn-outline-primary add">Update Profile</button>
            </div>
          </form>
        </div>
      </div>
    </div>


<script type="text/javascript">
    $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var token = $("input[name='_token']").val();

  $(document).on('click','.editProfile', function(){

    var profId = $(this).attr('id');

    $.ajax({
        url:"<?php echo route('viewEditProfile')?>",
        method:"POST",
        cache: false,
        data:{profId:profId, _token:token},
        success: function(data){
            $('.modal-body').html(data);
            $('#editModal').modal('show');
        }
    });
    
  });

</script>

@endsection
