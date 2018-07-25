@extends('layouts.app')

@section('title', 'Anggota - Tridarma System')

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
                <h4 class="page-title">Dashboard</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{ route('anggota.create') }}" class="btn btn-sm btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> TAMBAH ANGGOTA</a>
                <a  alt="default" data-toggle="modal" data-target="#modalImport"  class="btn btn-sm btn-info pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-upload"></i> IMPORT</a>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Anggota</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Preview Import Data Anggota</h3>
                    <br />
                    <div class="table-responsive">
                        <table class="table table-bordered display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAMA</th>
                                    <th>EMAIL</th>
                                    <th>TEMPAT LAHIR</th>
                                    <th>TANGGAL LAHIR</th>
                                    <th>JENIS KELAMIN</th>
                                    <th>ALAMAT</th>
                                    <th>NO TELEPON</th>
                                    <th>AGAMA</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->tempat_lahir }}</td>
                                        <td>{{ $item->tanggal_lahir }}</td>
                                        <td>{{ $item->jenis_kelamin }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->telepon }}</td>
                                        <td>{{ $item->agama }}</td>
                                        <td>
                                            <a href="{{ route('anggota.delete-temp', ['id' => $item->id]) }}" onclick="return confirm('Hapus data temporary ini ?')"> <button class="btn btn-danger btn-xs m-r-5"><i class="fa fa-trash"></i> delete</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <a href="{{ route('anggota.import-ok') }}" class="btn btn-info btn-sm" onclick="return confirm('Import semua data ini ?')"><i class="fa fa-check"></i> Proses Import</a>
                    </div>
                </div>
            </div>                        
        </div>
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
   @include('layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->

<div id="modalImport" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Import Data Anggota</h4> 
            </div>
            <form method="POST" action="{{ route('anggota.submit-import') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                        <div class="form-group">
                            <label>Upload / Select File</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Import Data</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection
