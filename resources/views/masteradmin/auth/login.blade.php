@extends('masteradmin.layout')
@section('title', 'Login')
@section('login')
    <div class="master-login">
        <div class="container-fluid home-login">
            <div class="row vh-100 justify-content-center align-items-center">
                <div class="col-11">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-4 col-11 py-1 rounded-5 bg-white">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid mt-3"
                                    style="width: 200px;" alt="Logo">
                                <h5 class="mt-3">Room Managment System</h5>
                            </div>
                            <div class="card-body mt-2">
                                <h4 class="text-dark text-center"><b>Welcome Back! - Login To Continue</b></h4>
                                <div class="mt-3">
                                    <form action="{{ url('master-login') }}" class="form-submit" id="login-user">
                                        <div class="form-group row mb-2">
                                            <div class="col-4"><label for="" class="text-dark fs-5">Username <span
                                                        class="text-danger">*</span></label></div>
                                            <div class="col-8">
                                                <input type="text" class="form-control" placeholder="Username"
                                                    name="username">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-2">
                                            <div class="col-4"><label for="" class="text-dark fs-5">Password <span
                                                        class="text-danger">*</span></label></div>
                                            <div class="col-8">
                                                <input type="password" class="form-control" placeholder="Password"
                                                    name="password">
                                            </div>
                                        </div>

                                        <div class="form-group row mt-4">
                                            <div class="col-4"></div>
                                            <div class="col-8">
                                                <div class="d-flex gap-3 align-items-center">
                                                    <button type="submit" class="btn btn-primary col-6">Login</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
