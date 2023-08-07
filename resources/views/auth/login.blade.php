@extends('layouts.app')
@section('title','Login')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="fw-bold">Login</h2>
                    </div>
                    <div class="card-body p-5">
                        <div id="login_alert"></div>
                        <form action="" method="post" id="login_form">
                            @csrf
                            <div class="mb-3">
                                <input type="email" name="email" id="email" class="form-control rounded-0" placeholder="Email">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" id="password" class="form-control rounded-0" placeholder="Password">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3 d-grid">
                              <input type="submit" value="Login" class="btn btn-dark rounded-0" id="login_btn">
                            </div>
                            <div class="text-center text-secondary">
                                <div>
                                    Don't have an account? <a href="/register" class="text-decoration-none">Register Here</a>
                                </div>
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
        $('#login_form').submit(function(e){
            e.preventDefault();
            $('#login_btn').prop('disabled',true).val('Please wait..');
            $.ajax({
                url: '{{route ('auth.login') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                    $('#login_btn').prop('disabled',false).val('Login');
                   if(res.status == 400){
                        showError('email', res.message.email);
                        showError('password', res.message.password);
                   }
                   else if(res.status == 401){
                    $('#login_alert').html(showMessage('danger', res.message));
                   }
                   else{
                        if(res.status == 200 && res.message == 'success'){
                            window.location = '{{route('layouts.dashboard')}}';
                        }
                   }
                }
            });
        });
    });
</script>
    
@endsection
