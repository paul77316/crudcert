@extends('layouts.app')
@section('title','Register')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="fw-bold">Register</h2>
                    </div>
                    <div class="card-body p-5">
                        <div id="show_success_alert"></div>
                        <form action="" method="post" id="register_form">
                            @csrf
                            <div class="mb-3">
                                <input type="name" name="name" id="name" class="form-control rounded-0" placeholder="Name">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" id="email" class="form-control rounded-0" placeholder="Email">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" id="password" class="form-control rounded-0" placeholder="Password">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="cpassword" id="cpassword" class="form-control rounded-0" placeholder="Confirm Password">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3 d-grid">
                              <input type="submit" value="Register" class="btn btn-dark rounded-0" id="register_btn">
                            </div>
                            <div class="text-center text-secondary">
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
        $('#register_form').submit(function(e){
            e.preventDefault();
            $('#register_btn').prop('disabled',true).val('Please wait..');
            $.ajax({
                url: '{{route ('auth.register') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                    $('#register_btn').prop('disabled',false).val('Register');
                   if(res.status == 400){
                        showError('name', res.message.name);
                        showError('email', res.message.email);
                        showError('password', res.message.password);
                        showError('cpassword', res.message.cpassword);
                   }
                   else if(res.status == 200){
                        $('#show_success_alert').html(showMessage('success', res.message))
                        $('#register_form')[0].reset();
                        removeValidationClasses('#register_form');
                        setTimeout(function(){ 
                           window.location.href="/";
                        }, 5000);
                   }
                }
            });
        });
    });
</script>
@endsection
