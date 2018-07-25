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
                    <h3 class="box-title m-b-0">Manage Anggota</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NAME</th>
                                    <th>NO ANGGOTA</th>
                                    <th>JENIS KELAMIN</th>
                                    <th>TELEPON</th>
                                    <th>EMAIL</th>
                                    <th>TANGGAL TERDAFTAR</th>
                                    <th>PREMI RGTL</th>
                                    <th>STATUS</th>
                                    <th width="300">MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->no_anggota }}</td>
                                        <td>{{ $item->jenis_kelamin }}</td>
                                        <td>{{ $item->telepon }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                        <td class="text-center">
                                            
                                            @if(!empty($item->expired_term_life))
                                                <label class="btn btn-success btn-xs" onclick="bootbox.alert('Expired date : {{ date('d F Y', strtotime($item->expired_term_life)) }}');"><i class="fa fa-check"></i> Lunas</label><br />
                                            @else
                                                <label class="btn btn-danger btn-xs"><i class="fa fa-close"></i> Belum Lunas</label>
                                            @endif
                                        </td>
                                        <td>
                                            <select name="status" style="height: 30px; font-size: 12px;"  onchange="change_status('{{ route('anggota.inactive', $item->id) }}', '{{ route('anggota.active', $item->id) }}', this)" class="form-control">
                                                @foreach([1 => 'Aktif', 0 => 'Inaktif'] as $k => $i)
                                                <option value="{{ $k }}" {{ $item->status == $k ? 'selected' : '' }}>{{ $i }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <a href="{{ route('anggota.detail', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> detail</button></a>
                                            <form action="{{ route('anggota.destroy', $item->id) }}" onsubmit="return confirm('Hapus data ini?')" method="post" style="float: left;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}                                               
                                                <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i> delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                            <label>Upload / Select File <a href="{{ asset('sample-import-anggota.xlsx') }}" class="btn btn-xs btn-info"><i class="fa fa-download"></i> Sample Import Excel</a></label>
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


@section('footer-script')
<link href="{{ asset('admin-css/plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<script src="{{ asset('admin-css/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<!-- end - This is for export functionality only -->

<script type="text/javascript">

    function change_status(url_inactive, url_active, ini)
    {
        var sel = $(ini);

        if(sel.val() ==0 ){
            bootbox.confirm({
                message: "Apakah anda ingin melakukan Inaktif untuk Anggota ini ?",
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
                        window.location = url_inactive;
                    }else{
                        sel.val(1)
                    }
                }

            });
        }else{
            bootbox.confirm({
                message: "Apakah anda ingin Mengaktifkan Anggota ini ?",
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
                        window.location = url_active;
                    }else{
                        sel.val(0)

                    }
                }
            });
        }
    }

    $('#data_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

</script>
@endsection

@endsection
