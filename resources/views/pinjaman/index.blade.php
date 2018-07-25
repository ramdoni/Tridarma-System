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
                <a href="{{ route('pinjaman.add') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> TAMBAH PINJAMAN</a>
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
                    <h3 class="box-title m-b-0">Manage Pinjaman</h3>
                    <br />
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead class="bold_tapi_kecil">
                                <tr>
                                    <td width="70" class="text-center">NO</td>
                                    <td>ANGGOTA</td>
                                    <td>PINJAMAN</td>
                                    <td>TENOR (BULAN)</td>
                                    <td>TANGGAL AKTIVASI</td>
                                    <td>JATUH TEMPO</td>
                                    <td>ANGSURAN (Rp)</td>
                                    <td style="{{ (isset($_GET['include_endowment']) and $_GET['include_endowment'] == 1) ? 'background: #53e69d; color: white;' : '' }}"> <input type="checkbox" value="1" class="include_endowment" {{ (isset($_GET['include_endowment']) and $_GET['include_endowment'] == 1) ? ' checked="true"' : '' }} /> ENDOWMENT</td>

                                    <td style="{{ (isset($_GET['include_premi_ajk']) and $_GET['include_premi_ajk'] == 1) ? 'background: #53e69d; color: white;' : '' }}"><input type="checkbox" value="1" class="include_premi_ajk"  {{ (isset($_GET['include_premi_ajk']) and $_GET['include_premi_ajk'] == 1) ? ' checked="true"' : '' }}  />  AJK</td>
                                    <td>STATUS</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pinjaman as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>Rp. {{ number_format($item->nominal) }}</td>
                                        <td class="text-right">{{ $item->tenor }}</td>                                        
                                        <td>

                                            <a href="" class="edit_tanggal" data-type="text" data-pk="{{ $item->id }}" data-title="Tanggal Aktivasi">
                                                {{ date('Y-m-d', strtotime($item->created_at)) }}
                                            </a>
                                        </td>
                                        <td>{{ tanggal_pertama_cicil($item->id) }}</td>
                                        <td>{{ number_format(last_cicilan_angsuran($item->id)) }}</td>
                                        <td style="text-align: center;">
                                            @if($item->include_endowment == 1)
                                                <label class="btn btn-info btn-xs"><i></i> Yes</label>
                                            @else
                                                <label class="btn btn-default btn-xs">No</label>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            @if($item->include_premi_ajk == 1)
                                                <label class="btn btn-info btn-xs">Yes</label>
                                            @else
                                                <label class="btn btn-default btn-xs">No</label>
                                            @endif
                                        </td>
                                        <td>{!! status_pinjaman($item->status) !!}</td>
                                        <td>
                                            <a href="{{ route('pinjaman.detail', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-search-plus"></i> Detail</a>
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
<style type="text/css">
    .bold_tapi_kecil {
        font-weight: bold;
        font-size: 12px;
    }
</style>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->

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
<script type="text/javascript" src="{{ asset('admin-css/plugins/bower_components/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
<script type="text/javascript">

    $('.include_endowment, .include_premi_ajk').on('change', function(){
        
        var include_endowment = $('.include_endowment');
        var include_premi = $('.include_premi_ajk');

        if(include_endowment.prop('checked') == true)
        {
            include_endowment = 1
        }else{
            include_endowment = 0
        }

        if(include_premi.prop('checked') == true)
        {
            include_premi = 1
        }else{
            include_premi = 0
        }

        window.location = '{{ route('pinjaman.index') }}?include_endowment='+include_endowment+'&include_premi_ajk='+ include_premi ;
    });


   
    $('.edit_tanggal').editable({
        validate: function(value) {
            
            var now = moment();
            var id      = $(this).attr('data-pk');

            $.ajax({
                url: "{{ route('ajax.submit_cicilan_active') }}", 
                data: {'id' : id, '_token' : '{{csrf_token()}}', 'value' : value},
                type: 'POST',
                success: function(result)
                {
                    location.reload();
                }
            })
        }
    });  

    $('#data_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

</script>
@endsection

@endsection
