@extends('layouts.app')

@section('title', 'Anggota -Tridarma System')

@section('sidebar')

@endsection

@section('content')

<!-- ============================================================== -->
<!-- Page Content -->
<!-- ============================================================== -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form Anggota</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Anggota</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
    <div class="row">
        <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('anggota.store') }}" method="POST">
            <div class="col-md-6">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Data Anggota</h3>
                    <br />
                
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif

                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-md-12">NIK</label>
                                <div class="col-md-12">
                                    <input type="number" name="nik" value="{{ old('nik')}}" class="form-control form-control-line"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Nama</label>
                                <div class="col-md-12">
                                    <input type="text" name="nama" class="form-control form-control-line" value="{{ old('nama')}}"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Jenis Kelamin</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value=""> - Jenis Kelamin - </option>
                                        @foreach(['Laki-laki', 'Perempuan'] as $item)
                                            <option>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-email" class="col-md-12">Email</label>
                                <div class="col-md-12">
                                    <input type="email" value="{{ old('email') }}" class="form-control form-control-line" name="email" id="example-email"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Telepon</label>
                                <div class="col-md-12">
                                    <input type="number" value="{{ old('telepon') }}" name="telepon" class="form-control form-control-line"> </div>
                            </div>
                           <div class="form-group">
                                <label class="col-md-12">Agama</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="agama">
                                        <option value=""> - Agama - </option>
                                        @foreach(agama() as $item)
                                            <option value="{{ $item }}"> {{ $item }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           
                        <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="white-box form-horizontal">
                    <div class="form-group">
                        <label class="col-md-12">Tempat Lahir</label>
                        <div class="col-md-12">
                            <input type="text" value="{{ old('tempat_lahir') }}" name="tempat_lahir" class="form-control form-control-line"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Tanggal Lahir</label>
                        <div class="col-md-12">
                            <input type="text" value="{{ old('tanggal_lahir') }}"  name="tanggal_lahir" class="form-control form-control-line datepicker"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">KTP</label>
                        <div class="col-md-6">
                            <input type="file" name="file_ktp" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Foto</label>
                        <div class="col-md-6">
                            <input type="file" name="file_photo" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Alamat</label>
                        <div class="col-md-12">
                            <textarea name="alamat" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label> <input type="checkbox" name="status" value="1" /> Aktif Anggota</label>
                        </div>
                    </div>

                    <a href="{{ route('anggota.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                    <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Simpan Data Anggota</button>
                    <button type="reset" class="btn btn-sm btn-default waves-effect waves-light m-r-10">Reset</button>
                    <br style="clear: both;" />
                    <div class="clearfix"></div>
                </div>
            </div>    
        </form>                    
    </div>
    <!-- /.row -->
    <!-- ============================================================== -->
</div>
    <!-- /.container-fluid -->
    @extends('layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@section('footer-script')
<!-- Date picker plugins css -->
<link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Date Picker Plugin JavaScript -->
<script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $("input[name='status']").change(function(){

        var ck = $(this);
        if(ck.is(':checked'))
        {
            bootbox.confirm({
                message: "Apakah anda ingin Aktivasi Anggota ?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result)
                    {
                        ck.attr('checked', true);
                    }else{
                        ck.attr('checked', false);
                    }
                }

            });
        }
    });

    jQuery('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });
</script>
@endsection

@endsection
