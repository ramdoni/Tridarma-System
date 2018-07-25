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
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Anggota</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-6">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Tagihan 3 sampai 7 Hari</h3>
                    <br />
                     <div class="table-responsive">
                        <table class="table table-hover manage-u-table">
                            <thead>
                                <tr style="background: #eee;">
                                    <th>No</th>
                                    <th>Anggota</th>
                                    <th>Total Angsuran</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; ?>
                                @foreach($cicilan_3_hari as $k =>  $i)
                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $i->pinjaman->user->name }}</td>
                                        <td style="color: red;">{{ !empty($i->tanggal_bayar) ? date('d F Y', strtotime($i->tanggal_bayar)) : '' }}</td>
                                        <th>{{ number_format($i->angsuran) }}</th>
                                        <td>
                                            <label class="btn btn-xs btn-danger" onclick="input_nominal_bayar('{{ route('tagihan.bayar', $i->id) }}', {{ $i->angsuran }}, '{{ $i->pinjaman->user->name }}')"><i class="fa fa-check"></i> Bayar Cicilan</label>
                                        </td>
                                    </tr>
                                    <?php $total += $i->angsuran?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Tagihan Belum Bayar</h3>
                    <br />
                    <div class="table-responsive">
                         <table class="table table-hover manage-u-table">
                            <thead>
                                <tr style="background: #eee;">
                                    <th>No</th>
                                    <th>Anggota</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Total Angsuran</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; ?>
                                @foreach($cicilan_belum_bayar as $k =>  $i)
                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $i->pinjaman->user->name }}</td>
                                        <td style="color: red;">{{ !empty($i->tanggal_bayar) ? date('d F Y', strtotime($i->tanggal_bayar)) : '' }}</td>
                                        <th>{{ number_format($i->angsuran) }}</th>
                                        <td>
                                            <label class="btn btn-xs btn-danger" onclick="input_nominal_bayar('{{ route('tagihan.bayar', $i->id) }}', {{ $i->angsuran }}, '{{ $i->pinjaman->user->name }}')"><i class="fa fa-check"></i> Bayar Cicilan</label>
                                        </td>
                                    </tr>
                                    <?php $total += $i->angsuran?>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background: #eee;">
                                    <th colspan="3" class="text-right">Total Belum Bayar</th>
                                    <th colspan="2">{{ number_format($total) }}</th>
                                </tr>
                            </tfoot>
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

@section('footer-script')
<script type="text/javascript">
    
    function input_nominal_bayar(url, nominal, nama_anggota)
    {

        bootbox.confirm({
            message: "Apakah anda ingin melakukan pembayaran ini :<br /><br /><table class=\"table table-bordered\"><tr><td>Nama Anggota </td><td>"+ nama_anggota +"</td></tr><tr><td> Total Angsuran</td><th style=\"color:red;\"> Rp. "+ numberWithComma(nominal) + '</th></tr></table>Proses pembayaran ini?',
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
                    window.location = url;
            }

        });

        // bootbox.prompt({
        //     title: "Nominal yang harus dibayarkan : Rp. "+ numberWithComma(nominal),
        //     inputType: 'text',
        //     callback: function (result) {
        //         console.log(result);
        //     }
        // });
    }

</script>



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
    $('#data_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

</script>
@endsection

@endsection
