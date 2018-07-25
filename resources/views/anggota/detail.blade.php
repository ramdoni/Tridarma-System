@extends('layouts.app')

@section('title', 'Detail Pinjaman -Tridarma System')

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
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">DETAIL DATA ANGGOTA</h3>
                <br />
                 <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('anggota.update', $data->id) }}" method="POST">
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

                    <ul class="nav customtab2 nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Profile</span></a>
                        </li>
                        <li role="presentation">
                            <a href="#tab_ahli_waris" aria-controls="tab_ahli_waris" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Ahli Waris</span></a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#simpanan" aria-controls="simpanan" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Simpanan</span></a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#pinjaman" aria-controls="simpanan" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"> Cicilan </span></a>
                        </li>
                        @if($data->is_endowment == 1)
                        <li role="presentation" class="">
                            <a href="#pinjamanendowment" aria-controls="pinjamanendowment" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"> Cicilan + Endowment</span></a>
                        </li>
                        @endif
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="profile">
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">NIK</label>
                                    <div class="col-md-12">
                                        <input type="text" name="nik" value="{{ $data->nik }}" class="form-control form-control-line"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Nama</label>
                                    <div class="col-md-12">
                                        <input type="text" name="nama" class="form-control form-control-line" value="{{ $data->name }}"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Jenis Kelamin</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="jenis_kelamin" required>
                                            <option value=""> - Jenis Kelamin - </option>
                                            @foreach(['Laki-laki', 'Perempuan'] as $item)
                                                <option {{ $data->jenis_kelamin  == $item ? ' selected' : '' }}>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" value="{{ $data->email }}" class="form-control form-control-line" name="email" id="example-email"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Telepon</label>
                                    <div class="col-md-12">
                                        <input type="text" value="{{ $data->telepon }}" name="telepon" class="form-control form-control-line"> </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Agama</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="agama">
                                            <option value=""> - Agama - </option>
                                            @foreach(agama() as $item)
                                                <option value="{{ $item }}" {{ $data->agama == $item ? 'selected' : '' }}> {{ $item }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Tempat Lahir</label>
                                    <div class="col-md-12">
                                        <input type="text" value="{{ $data->tempat_lahir }}" name="tempat_lahir" class="form-control form-control-line"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Tanggal Lahir</label>
                                    <div class="col-md-3">
                                        <input type="text" value="{{ $data->tanggal_lahir }}"  name="tanggal_lahir" class="form-control form-control-line datepicker"> 
                                    </div>
                                    <div class="col-md-3">
                                        <label>Usia : <span style="color: red;">{{ umur($data->tanggal_lahir) }} Tahun</span></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12">KTP</label>
                                    <div class="col-md-6">
                                        <input type="file" name="file_ktp" class="form-control">
                                    </div>
                                    @if(!empty($data->foto_ktp))
                                        <div class="col-md-6">
                                            <img src="{{ asset('file_ktp/'. $data->id .'/'.  $data->foto_ktp)}}" style="width: 200px;">
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Foto</label>
                                    <div class="col-md-6">
                                        <input type="file" name="file_photo" class="form-control">
                                    </div>
                                    @if(!empty($data->foto))
                                        <div class="col-md-6">
                                            <img src="{{ asset('file_photo/'. $data->id .'/'.  $data->foto)}}" style="width: 200px;">
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Alamat</label>
                                    <div class="col-md-12">
                                        <textarea name="alamat" class="form-control">{{ $data->alamat }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label> <input type="checkbox" name="status" value="1" {{ $data->status == 1 ? ' checked="true"' : '' }} /> Aktif Anggota</label>
                                    </div>
                                </div>
                            </div>
                        <div class="clearfix"></div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_ahli_waris">
                        
                        <label class="btn btn-info btn-sm" id="add_ahli_waris"><i class="fa fa-plus"></i> Tambah Ahli Waris</label>
                        <br />
                        <br />

                        <div class="table-responsive" style="overflow: auto;">
                            <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                                <thead class="custome_font">
                                    <tr>
                                        <td>NO</td>
                                        <td>NAMA</td>
                                        <td>TANGGAL LAHIR</td>
                                        <td>ALAMAT</td>
                                        <td>NIK</td>
                                        <td>HUB. DENGAN TERTANGGUNG</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ahli_waris as $no => $item)
                                    <tr>
                                        <td>{{ $no+1 }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->tanggal_lahir }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td>{{ $item->hubungan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="simpanan">
                        
                        <div class="col-md-2">
                            <h3 style="margin-top: 0;"><small>Simpanan Wajib</small>
                                <br /> Rp. {{ number_format($data->simpanan_wajib) }}
                                @if($data->simpanan_wajib == 0 || $data->simpanan_wajib =="")
                                    <label class="btn btn-info btn-xs" onclick="bayar_simpanan_wajib()"><i class="fa fa-plus"></i> Bayar Simpanan Wajib</label>
                                @endif
                            </h3>
                        </div>
                        <div class="col-md-2">
                            <h3><small>Simpanan Pokok</small><br /> Rp. {{ number_format($data->simpanan_pokok) }}</h3>
                        </div>
                        <div class="col-md-2">
                            <h3><small>Simpanan Sukarela</small><br /> Rp. {{ number_format($data->simpanan_sukarela) }}</h3>
                            <label class="btn btn-info btn-xs" onclick="topup()"><i class="fa fa-plus"></i> Topup</label>
                        </div>
                        <div class="col-md-2">
                            <h3><small>Premi Asuransi Reliance Group Term Life</small><br /> Rp. 50.000</h3>
                            <?php 
                                $expire = strtotime($data->expired_term_life);
                                $today = strtotime("today midnight");
                            ?>
                            @if($today >= $expire)
                                <label class="btn btn-info btn-xs" onclick="bayar_premi_asuransi()"><i class="fa fa-plus"></i>  Bayar Premi Asuransi</label>
                            @else
                                Masa Berlaku sampai <br />
                                <label style="color: #ff1515;">{{ date('d F Y', strtotime($data->expired_term_life)) }}</label>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <br />
                        <div>
                            <div class="col-md-2">
                                <ul class="nav tabs-vertical">
                                    <li class="tab active">
                                        <a data-toggle="tab" href="#tab_simpanan_pokok" aria-expanded="true"> <span class="visible-xs"><i class="ti-home"></i></span> <span class="hidden-xs">Simpanan Pokok</span> </a>
                                    </li>
                                    <li class="tab">
                                        <a data-toggle="tab" href="#tab_simpanan_sukarela" aria-expanded="false"> <span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Simpanan Sukarela</span> </a>
                                    </li>
                                    <li class="tab">
                                        <a data-toggle="tab" href="#tab_transaksi" aria-expanded="false"> <span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Transaksi</span> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-10">
                                <div class="tab-content">
                                    <div id="tab_simpanan_pokok" class="tab-pane active">
                                        <div class="col-md-12">
                                            <div class="table-responsive" style="overflow: auto;">
                                                <table id="data_table4" class="display nowrap" cellspacing="0" width="100%">
                                                    <thead class="custome_font">
                                                        <tr>
                                                            <td>Tahun</td>
                                                            <?php 
                                                            $bulan = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Des'];
                                                            ?>
                                                            @foreach($bulan as $key =>  $b)
                                                                <td>{{ $b }}</td>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(!empty($data->tanggal_aktivasi))
                                                            <?php $k = 0; ?>
                                                            @for($tahun=date('Y', strtotime($data->tanggal_aktivasi)); $tahun <= date('Y'); $tahun++)
                                                                <tr>
                                                                    <td style="font-size: 14px;">{{ $tahun }}</td>
                                                                    @foreach($bulan as $key =>  $b)
                                                                    <td>
                                                                        @if($k == 0)
                                                                            @if(date('m', strtotime($data->tanggal_aktivasi)) < $key) 
                                                                                {!! status_simpanan_pokok($key, $data->id, $tahun, $b) !!}
                                                                            @endif
                                                                        @else
                                                                            {!! status_simpanan_pokok($key, $data->id, $tahun, $b) !!}
                                                                        @endif
                                                                    </td>
                                                                    @endforeach
                                                                    <?php $k++; ?>
                                                                </tr>
                                                            @endfor
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="tab_simpanan_sukarela" class="tab-pane">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="data_table2" class="display nowrap" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nominal</th>
                                                            <th>Tanggal Topup</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($deposit as $key => $item)
                                                            <tr>
                                                                <td>{{ ($key+1) }}</td>
                                                                <td>{{ number_format($item->nominal) }}</td>
                                                                <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tab_transaksi" class="tab-pane">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="data_table3" class="display nowrap" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Jenis Transaksi</th>
                                                            <th>Nominal</th>
                                                            <th>Tanggal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php($total_transaksi = 0)
                                                        @foreach($transaksi as $key => $item)
                                                            <tr>
                                                                <td>{{ ($key+1) }}</td>
                                                                <td>{{ $item->jenis_transaksi }}</td>
                                                                <td>{{ number_format($item->nominal) }}</td>
                                                                <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                                            </tr>
                                                            @php($total_transaksi += $item->nominal)
                                                        @endforeach 
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="2" style="text-align: right">Total</th>
                                                            <th colspan="2">{{ number_format($total_transaksi) }}</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <br />
                        <br class="clearfix" />
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="pinjaman">
                        @foreach($pinjaman as $item)
                            <div class="media">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <td style="border-top: 0;"><h2>Plafond</h2></td>
                                            <td style="border-top: 0;"><h2>Rp. {{ number_format($item->nominal) }}</h2></td>
                                        </tr>
                                        <tr>
                                            <td>Masa (Bulan)</td>
                                            <td>{{ $item->tenor }}</td>
                                        </tr>
                                        <tr>
                                            <td>Provisi</td>
                                            <td>{{ $item->provisi }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Jasa</td>
                                            <td>{{ $item->jasa }}%</td>
                                        </tr>
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
                                        @foreach($item->cicilan as $k =>  $i)
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
                                                        <small class="text-muted">{{ date('d F Y', strtotime($item->tanggal_lunas)) }}</small> 
                                                    @else
                                                        <label class="btn btn-xs btn-warning"><i class="fa fa-close"></i> Belum Lunas</label>
                                                        <a href="{{ route('anggota.bayar', $i->id) }}" onclick="return confirm('Bayar cicilan?')" class="btn btn-xs btn-danger"><i class="fa fa-check"></i> Bayar</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                               </table>
                               <hr />
                            </div>
                        @endforeach
                       
                       <br />
                       <br />
                       <a href="{{ route('pinjaman.add') }}" class="btn btn-sm btn-info pull-right"><i class="fa fa-plus"></i> Tambah Pinjaman</a>
                       <br />
                       <br />
                    </div>

                    @if($data->is_endowment == 1)
                    <div role="tabpanel" class="tab-pane fade" id="pinjamanendowment">
                        @foreach($pinjaman_endowment as $item)
                            <div class="media">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <td style="border-top: 0;"><h2>Plafond</h2></td>
                                            <td style="border-top: 0;"><h2>Rp. {{ number_format($item->nominal) }}</h2></td>
                                        </tr>
                                        <tr>
                                            <td>Masa (Bulan)</td>
                                            <td>{{ $item->tenor }}</td>
                                        </tr>
                                        <tr>
                                            <td>Provisi</td>
                                            <td>{{ $item->provisi }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Jasa</td>
                                            <td>{{ $item->jasa }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Total Endowment</td>
                                            <td>Rp. {{ number_format($item->total_endowment) }}</td>
                                        </tr>
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
                                        @foreach($item->cicilan as $k =>  $i)
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
                                                        <small class="text-muted">{{ date('d F Y', strtotime($item->tanggal_lunas)) }}</small> 
                                                    @else
                                                        <label class="btn btn-xs btn-warning"><i class="fa fa-close"></i> Belum Lunas</label>
                                                        <a href="{{ route('anggota.bayar', $i->id) }}" onclick="return confirm('Bayar cicilan?')" class="btn btn-xs btn-danger"><i class="fa fa-check"></i> Bayar</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                               </table>
                               <hr />
                            </div>
                        @endforeach
                       
                       <br />
                       <br />
                       <a href="{{ route('anggota.add-pinjaman', $data->id) }}" class="btn btn-sm btn-info pull-right"><i class="fa fa-plus"></i> Tambah Pinjaman</a>
                       <br />
                       <br />
                    </div>
                    @endif
                </div>

                <div class="clearfix"></div>
                <a href="{{ route('anggota.index') }}" class="btn btn-default waves-effect waves-light m-r-10 btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10  btn-sm"><i class="fa fa-save"></i> Simpan Perubahan</button>
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


<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Topup</h4> </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('topup') }}">
                    
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="number" name="nominal" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">Submit Topup</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- sample modal content -->
<div id="modal_ahli_waris" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Ahli Waris</h4>
            </div>
            <div class="modal-body">
                <form method="POST" class="form_ahli_waris" action="{{ route('topup') }}">
                    
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ $data->id }}">
                    
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" />
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="text" class="form-control datepicker" name="tanggal_lahir" />
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="number" class="form-control" name="nik" />
                    </div>
                    <div class="form-group">
                        <label>HUB. DENGAN TERTANGGUNG</label>
                        <textarea class="form-control" name="hubungan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success waves-effect" id="simpan_ahli_waris">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<style type="text/css">
    .custome_font tr td {
        font-size: 14px;
    }
</style>

<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@section('footer-script')
<!-- Date picker plugins css -->
<link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Date Picker Plugin JavaScript -->
<script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

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

    $("#simpan_ahli_waris").click(function(){

        var form = $('.form_ahli_waris').serialize();

         $.ajax({
            url: "{{ route('ajax.submit_ahli_waris') }}", 
            data: form,
            type: 'POST',
            success: function(res)
            {
                if(res.message == 'success')
                {
                    if(window.location.hash) {
                        location.reload();
                    } else {
                        window.location = '{{ route('anggota.detail', ['id' => $data->id, '#tab_ahli_waris']) }}';
                    }
                }
                else
                {
                    bootbox.alert(res.data);
                }
            }
        })
    });

    if (window.location.hash)
    {
        $('a[data-toggle=tab][href="' + window.location.hash + '"]').tab('show');
    }

    $('#add_ahli_waris').click(function(){

        $('#modal_ahli_waris').modal('show');

    });

    function bayar_premi_asuransi()
    {
        var confirm = bootbox.confirm({
                message: "Apakah anda ingin Membayar Premi Asuransi Sebesar <strong>Rp. {{ number_format(get_setting('premi_asuranransi_reliance_term_life')) }}</strong> ?",
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
                        confirm.find('.bootbox-body').html('<p><i class="fa fa-spin fa-spinner"></i> Silahkan tunggu beberapa saat ...</p>');

                        setTimeout(function(){
                             $.ajax({
                                url: "{{ route('ajax.submit_premi_asuransi') }}", 
                                data: {'_token' : '{{csrf_token()}}', 'user_id' : {{ $data->id }}, 'nominal' : {{ get_setting('premi_asuranransi_reliance_term_life') }} },
                                type: 'POST',
                                success: function(res)
                                {
                                    if(res.message == 'success')
                                    {
                                        confirm.modal('hide');
                                        
                                        bootbox.alert("Anda berhasil melakukan pembayaran Premi Asuransi Reliance Group Term Life !", function() {
                                            reload_page();
                                        });

                                    }else{
                                        confirm.find('.bootbox-body').html('<p><i class="fa fa-times-octagon"></i> '+ res.data +'</p>');
                                        confirm.modal('hide');
                                        bootbox.alert(res.data);
                                    }
                                }
                            })
                        }, 2000);

                        return false;
                    }
                }
            });
    }

    function topup()
    {
        var pr = bootbox.prompt({
                title: "Topup Simpanan Sukarela ",
                inputType: 'number',
                callback: function (nominal) 
                {
                    if(nominal != null)
                    {
                        var confirm = bootbox.confirm({
                            message: "Apakah anda ingin Topup Simpanan Sukarela ?",
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
                                    confirm.find('.bootbox-body').html('<p><i class="fa fa-spin fa-spinner"></i> Silahkan tunggu beberapa saat ...</p>');

                                    setTimeout(function(){
                                         $.ajax({
                                            url: "{{ route('ajax.submit_simpanan_sukarela') }}", 
                                            data: {'_token' : '{{csrf_token()}}', 'user_id' : {{ $data->id }}, 'nominal' : nominal },
                                            type: 'POST',
                                            success: function(res)
                                            {
                                                if(res.message == 'success')
                                                {
                                                    confirm.modal('hide');
                                                    
                                                    bootbox.alert("Anda Berhasil Topup Simpanan Sukarela sebesar <strong>Rp. "+ numberWithComma(nominal) +"</strong>", function() {
                                                        reload_page();
                                                    });

                                                }else{
                                                    confirm.find('.bootbox-body').html('<p><i class="fa fa-times-octagon"></i> '+ res.data +'</p>');
                                                }
                                            }
                                        })
                                    }, 2000);

                                    return false;
                                }
                            }
                        });
                    }
                }
            });
    }

    function bayar_simpanan_wajib()
    {
        var confirm = bootbox.confirm({
            message: "Apakah anda ingin membayar Simpanan Wajib ?",
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
                    confirm.find('.bootbox-body').html('<p><i class="fa fa-spin fa-spinner"></i> Silahkan tunggu beberapa saat ...</p>');

                    setTimeout(function(){
                         $.ajax({
                            url: "{{ route('ajax.submit_simpanan_wajib') }}", 
                            data: {'_token' : '{{csrf_token()}}', 'user_id' : {{ $data->id }}, 'nominal' : {{ get_setting('simpanan_wajib') }}},
                            type: 'POST',
                            success: function(res)
                            {
                                if(res.message == 'success')
                                {
                                    confirm.modal('hide');
                                    
                                    bootbox.alert("Anda Berhasil Melakukan Pembayaran Simpanan Wajib !", function() {
                                       reload_page();
                                    });

                                }else{
                                    confirm.find('.bootbox-body').html('<p><i class="fa fa-times-octagon"></i> '+ res.data +'</p>');
                                }
                            }
                        })
                    }, 2000);

                    return false;
                }
            }
        });
    }

    function reload_page()
    {
        if(window.location.hash) {
            location.reload();
        } else {
            window.location = '{{ route('anggota.detail', ['id' => $data->id, '#simpanan']) }}';
        }
    }

    function bayar_simpanan_pokok(user_id, bulan, tahun, bulan_str)
    {
        var confirm = bootbox.confirm({
                message: "Apakah anda ingin melakukan pembayaran Simpanan Pokok untuk bulan "+ bulan_str +" ?",
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
                        confirm.find('.bootbox-body').html('<p><i class="fa fa-spin fa-spinner"></i> Silahkan tunggu beberapa saat ...</p>');

                         $.ajax({
                            url: "{{ route('ajax.submit_simpanan_pokok') }}", 
                            data: {'_token' : '{{csrf_token()}}', 'bulan' : bulan, 'tahun' : tahun, 'user_id' : user_id, 'nominal' : 10000},
                            type: 'POST',
                            success: function(result)
                            {
                                if(result.message == 'success')
                                {
                                    confirm.modal('hide');
                                    
                                    bootbox.alert("Anda Berhasil Melakukan Pembayaran Simpanan Pokok, sebesar <strong>Rp. 10.000</strong>", function() {
                                        reload_page();
                                    });

                                }else{
                                    confirm.find('.bootbox-body').html('<p><i class="fa fa-times-octagon"></i> '+ result.data +'</p>');
                                }
                            }
                        })

                         return false;
                    }
                }
        });
    }

    function confirm_baya_simpanan_pokok()
    {
        bootbox.confirm({
            message: "Apakah anda ingin melakukan pembayaran simpanan pokok untuk bulan ini?",
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
                console.log('This was logged in the callback: ' + result);
            }
        });
    }

    $('#data_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        bInfo: false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
        paging: false,//Dont want paging                
        bPaginate: false,//Dont want paging 
    });

    $('#data_table2').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        bInfo: false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
        paging: false,//Dont want paging                
        bPaginate: false,//Dont want paging 
    });

    $('#data_table3').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        //bInfo: false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
        //paging: false,//Dont want paging                
        //bPaginate: false,//Dont want paging 
    });

     $('#data_table4').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        bInfo: false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
        paging: false,//Dont want paging                
        bPaginate: false,//Dont want paging 
    });

    $("input[name='status']").change(function(){

        var ck = $(this);
        if(ck.is(':checked'))
        {
            bootbox.confirm({
                message: "Apakah anda ingin Aktivasi Anggota ini ?",
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
        }else{
            bootbox.confirm({
                message: "Apakah anda ingin Inaktif Anggota ini ?",
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
