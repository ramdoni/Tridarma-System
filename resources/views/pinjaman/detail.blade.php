@extends('layouts.app')

@section('title', 'Pinjaman -Tridarma System')

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
                    <li class="active">Pinjaman</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">DETAIL DATA PINJAMAN</h3>
                <br />
                 <form class="form-horizontal" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="_method" value="PUT">
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

                    <div class="media">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <td style="border-top: 0;"><h2>Plafond</h2></td>
                                    <td style="border-top: 0;">
                                        <h2 class="pull-left">Rp. {{ number_format($data->nominal) }}</h2>
                                        <label class="btn btn-success btn-sm pull-right" style="margin-top: 12px;">{{ $data->status == 1 ? 'Aktif' : 'Lunas' }}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Masa (Bulan)</td>
                                    <td>{{ $data->tenor }}</td>
                                </tr>
                                <tr>
                                    <td>Provisi</td>
                                    <td>{{ $data->provisi }}%</td>
                                </tr>
                                <tr>
                                    <td>Jasa</td>
                                    <td>{{ $data->jasa }}%</td>
                                </tr>
                                @if($data->include_endowment == 1)
                                <tr>
                                    <td>Total Endowment</td>
                                    <td>Rp. {{ number_format($data->total_endowment) }}</td>
                                </tr>
                                <tr>
                                    <td>Cash Back</td>
                                    <td>Rp . {{ number_format($data->cash_back) }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="clear"></div>
                        <h4>Rincian Cicilan Perbulan</h4>
                        <table class="table table-hover manage-u-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sisa Pokok</th>
                                    <th>Angsuran</th>
                                    <th>Pokok</th>
                                    <th>Provisi</th>
                                    <th>Jasa</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->cicilan as $k =>  $i)
                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ number_format($i->sisa_pokok) }}</td>
                                        <td>{{ number_format($i->angsuran) }}</td>
                                        <td>{{ number_format($i->pokok) }}</td>
                                        <td>{{ number_format($i->provisi) }}</td>
                                        <td>{{ number_format($i->jasa) }}</td>
                                        <td>{{ !empty($i->tanggal_bayar) ? date('d F Y', strtotime($i->tanggal_bayar)) : '' }}</td>
                                        <td>
                                            @if($i->status == 1)
                                                <label class="btn btn-xs btn-success"><i class="fa fa-check"></i> Lunas</label><br />
                                                <small class="text-muted">{{ date('d F Y', strtotime($i->tanggal_lunas)) }}</small> <br />
                                                <a href="{{ route('kwitansi', $i->id) }}" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-print"></i> Kwitansi</a>
                                            @else
                                                <label class="btn btn-xs btn-warning"><i class="fa fa-close"></i> Belum Lunas</label>
                                                <span onclick="confirm_bayar('{{ route('pinjaman.bayar', $i->id) }}', {{ $i->angsuran }}, '{{ $i->pinjaman->user->name }}')" class="btn btn-xs btn-danger"><i class="fa fa-check"></i> Bayar</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                       </table>
                       <hr />
                    </div>

                <div class="clearfix"></div>
                <a href="{{ route('pinjaman.index') }}" class="btn btn-default waves-effect waves-light m-r-10 btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
                <br style="clear: both;" />
            </form>
          </div>
        </div>                        
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
<script type="text/javascript">
    function confirm_bayar(url, nominal, nama_anggota)
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
    }

</script>
@endsection
@endsection
