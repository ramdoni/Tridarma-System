@extends('layouts.login')

@section('content')
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="new-login-register">
      <div class="lg-info-panel" style="z-index: 99;">
              <div class="inner-panel">
                  <a href="javascript:void(0)" class="p-20 di"></a>
                  <div class="lg-content">
                      <img src="{{ asset('koperasi.png') }}" style="width: 200px;">

                      <h2>KPPJ Y TRIDHARMA</h2>
                  </div>
              </div>
      </div>
      <div class="new-login-box">
          <div class="white-box">
              <h3 class="box-title m-b-0">Login System</h3>
              <small>Sign In to and Enter your details below</small>
            <form class="form-horizontal new-lg-form" method="POST" id="loginform" action="{{ route('login') }}">
              
              {{ csrf_field() }}
              
              <div class="form-group  m-t-20">
                <div class="col-xs-12">
                  <label>Email Address</label>
                  <input class="form-control" type="email" required="" name="email" placeholder="Email" value="{{ old('email') }}">
                  @if ($errors->has('email'))
                      <span class="help-block" style="color: #e94600 !important;">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12">
                  <label>Password</label>
                  <input class="form-control" name="password" id="password" type="password" required="" placeholder="Password">
                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
                  <span class="field-icon toggle-password fa fa-fw fa-eye"></span>

                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <div class="checkbox checkbox-info pull-left p-t-0">
                    <input id="checkbox-signup" type="checkbox"  name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="checkbox-signup"> Remember me </label>
                  </div>
                </div>
              </div>
              <div class="form-group text-center m-t-20">
                <div class="col-xs-12">
                  <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Log In</button>
                </div>
              </div>
            </form>
          </div>
      </div>
      
      <div style="background: url('{{ asset('2.jpeg') }}'), url('{{ asset('2.jpeg') }}'), url('{{ asset('2.jpeg') }}');width: 100%;height: 80px;/* z-index: 9999; */position: absolute;bottom: 0;right: 0px;background-size: 320px 82px;">

      </div>
        <!-- 
      <img src="{{ asset('1.jpeg')}}" style="height: 80px;z-index: 9999;position: absolute;bottom: 0;right: 0px;" />          
      <img src="{{ asset('2.jpeg')}}" style="height: 80px;z-index: 9999;position: absolute;bottom: 0;right: 404px;" />          
      <img src="{{ asset('2.jpeg')}}" style="height: 80px;position: absolute;bottom: 0;right: 764px;" /> -->          
</section>
<style type="text/css">
  .field-icon {
    float: right;
    margin-right: 9px;
    margin-top: -28px;
    position: relative;
    z-index: 2;
  }
</style>
@endsection


