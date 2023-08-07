@extends('layouts.dashboard')
@section('title','view lesson')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="/lessons">
                        <button class="btn btn-sm btn-primary"><- Back </button>&nbsp;
                    </a>
                    <h6 class="m-0 font-weight-bold text-primary">Details</h6>
                </div>
                <div>
                    <button class="btn btn-sm btn-info btn-cert-complete">Complete Lesson</button>
                    <button class="btn btn-sm btn-primary btn-edit">Edit</button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="{{$arr['id']}}">Delete</button>
                </div>
            </div>
            </div>
            <div class="card-body">
                <div class="row">
                   <div class="col-2">
                        <label for="">Course</label>
                   </div>
                   <div class="col-8">
                    <label for=""> {{$arr['course_name']}}</label>
                   </div>
               </div>
               <div class="row">
                    <div class="col-2">
                        <label for="">Date From</label>
                    </div>
                    <div class="col-8">
                        <label for=""> {{$arr['from']}}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <label for="">Date To</label>
                    </div>
                    <div class="col-8">
                        <label for=""> {{$arr['to']}}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <label for="">Instructor</label>
                    </div>
                    <div class="col-8">
                        <label for=""> {{$arr['instructor']}}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="add-lesson-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Record</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="show_success_alert"></div>
                    <form action="" method="post" id="edit_form">
                        @csrf
                        <div class="mb-3">
                            <label for="">Course Name</label>
                            <input type="tezt" name="course_name" id="course_name" value="{{$arr['course_name']}}" class="form-control rounded-0" placeholder="Course Name">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="">Starting Date</label>
                            <input type="date" name="from" id="from" value="{{$arr['from']}}" class="form-control rounded-0" placeholder="Date From">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="">End Date</label>
                            <input type="date" name="to" id="to" value="{{$arr['to']}}" class="form-control rounded-0" placeholder="Date To">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="">Instructor/trainor</label>
                            <input type="text" name="instructor" id="instructor" value="{{$arr['instructor']}}" class="form-control rounded-0" placeholder="Instructor">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 d-grid">
                            <input type="hidden" name="id"  value="{{$arr['id']}}" class="form-control rounded-0">
                            <input type="hidden" name="type"  value="edit" class="form-control rounded-0">
                            <input type="submit" value="Save" class="btn btn-dark rounded-0" id="save_btn">
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal" id="modal-delete-warning" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Record</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label for=""> Are you sure you want to delete this record?</label>
                </div>
                <form action="" method="post" id="delete_form">
                    @csrf
                    <input type="hidden" name="id"  value="{{$arr['id']}}" class="form-control rounded-0">
                    <input type="hidden" name="type"  value="delete" class="form-control rounded-0">
                    
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm btn-confirm-delete">Yes</button>
                <button class="btn btn-info btn-sm close-btn">No</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal" id="modal-cert-complete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Certificate Completed</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="" method="post" id="cert_form">
                        @csrf
                        <div class="mb-3">
                            <label for="">Date Completed</label>
                            <input type="date" name="date_completed" id="date_completed" value="" class="form-control rounded-0" placeholder="Date Completed">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 d-grid">
                            <input type="hidden" name="lesson_id"  value="{{$arr['id']}}" class="form-control rounded-0">
                            <input type="hidden" name="user_id" value="{{request()->session()->get('loggedInUser')['userid']}}">
                            <input type="hidden" name="type"  value="gen_cert" class="form-control rounded-0">
                            <input type="submit" value="Save" class="btn btn-dark rounded-0" id="submit_btn">
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('script')
<script>
    $(function(){
        $('.btn-edit').on('click', function(){
            $('#add-lesson-modal').modal('show');  
        });

        $('#from').on('change', function(){
            var from = $(this).val();
            $('#to').attr('min', from)
            
        });
        $('#to').on('change', function(){
            var from = $('#from').val();
           if(from == ''){
            $(this).val('');
           }
            
        });
        $('.close').on('click', function(){
            $('.modal').modal('hide'); 
        });
        $('.btn-delete').on('click', function(){
            $('#modal-delete-warning').modal('show');
        })
        $('#edit_form').submit(function(e){
            e.preventDefault();
            $('#save_btn').prop('disabled',true).val('Please wait..');
            $.ajax({
                url: '{{route ('layouts.viewlesson') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                    $('#save_btn').prop('disabled',false).val('Save');
                   if(res.status == 400){
                        showError('course_name', res.message.course_name);
                        showError('from', res.message.from);
                        showError('to', res.message.to);
                        showError('instructor', res.message.instructor);
                   }
                   else if(res.status == 200){  
                        $('#show_success_alert').html(showMessage('success', res.message))
                        $('#edit_form')[0].reset();
                        window.location.reload();
                        removeValidationClasses('#edit_form');
                   }
                }
            });
        });
        $('.btn-confirm-delete').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr("data-id");
            $('#save_btn').prop('disabled',true).val('Please wait..');
            $.ajax({
                url: '{{route ('layouts.viewlesson') }}',
                method: 'post',
                data: $('#delete_form').serialize(),
                dataType: 'json',
                success: function(res){
                    window.location.href='/lessons';
                }
            });

        });
        $('.close-btn').on('click', function(e){
            e.preventDefault();
            $('#modal-delete-warning').modal('hide');
        });
        $('.btn-cert-complete').on('click', function(){
            $('#modal-cert-complete').modal('show');
        });
        $('#cert_form').submit(function(e){
            e.preventDefault();
            $('#submit_btn').prop('disabled',true).val('Generating Certificate.Please wait..');
            $.ajax({
                url: '{{route ('layouts.viewlesson') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                    $('#submit_btn').prop('disabled',false).val('Save');
                    if(res.status == 200){  
                        $('#show_success_alert').html(showMessage('success', res.message))
                        setTimeout(function() { 
                           window.location.href='/certificates';
                        }, 5000);
                   }
                }
            });
        });
        
    });
</script>
@endsection
