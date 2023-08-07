@extends('layouts.dashboard')
@section('title','lessons')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>Add new lesson</h2>
                </div>
                <div>
                    <button class="btn btn-primary btn-add">Add</button>
                </div>
            </div>
        </div>
        <table id="myTable" class="table-bordered">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Lesson Name</td>
                    <td>From</td>
                    <td>To</td>
                    <td>Instructor</td>
                    <td>Created</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $item)
                <tr>
                    <td>
                        <a href="/viewlesson/{{$item->id}}">{{$item->id}}</a>
                    </td>
                    <td> {{$item->course_name}}</td>
                    <td> {{$item->from}}</td>
                    <td> {{$item->to}}</td>
                    <td> {{$item->instructor}}</td>
                    <td> {{$item->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal" id="add-lesson-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Record</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="show_success_alert"></div>
                    <form action="" method="post" id="add_form">
                        @csrf
                        <div class="mb-3">
                            <label for="">Course Name</label>
                            <input type="tezt" name="course_name" id="course_name" class="form-control rounded-0" placeholder="Course Name">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="">Starting Date</label>
                            <input type="date" name="from" id="from" class="form-control rounded-0" placeholder="Date From">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="">End Date</label>
                            <input type="date" name="to" id="to" class="form-control rounded-0" placeholder="Date To">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="">Instructor/trainor</label>
                            <input type="text" name="instructor" id="instructor" class="form-control rounded-0" placeholder="Instructor">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 d-grid">
                          <input type="submit" value="Save" class="btn btn-dark rounded-0" id="save_btn">
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
    let table = new DataTable('#myTable');

    $(function(){
        $('.btn-add').on('click', function(){
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
        $('#add_form').submit(function(e){
            e.preventDefault();
            $('#save_btn').prop('disabled',true).val('Please wait..');
            $.ajax({
                url: '{{route ('layouts.lessons') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                    $('#save_btn').prop('disabled',false).val('Save');
                   if(res.status == 400){
                        showError('course_name', res.message.course_name);
                        showError('from', res.message.from);
                        showError('to', res.message.to);
                        showError('instructor', res.message.instructors);
                   }
                   else if(res.status == 200){
                        $('#show_success_alert').html(showMessage('success', res.message))
                        $('#add_form')[0].reset();
                        removeValidationClasses('#add_form');
                        setTimeout(function() { 
                                window.location.reload();
                             }, 2000);
                        
                   }
                }
            });
        });

    });
</script>
@endsection
