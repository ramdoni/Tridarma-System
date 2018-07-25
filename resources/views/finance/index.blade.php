@extends('layouts.app')

@section('title', 'Dashboard Finance- Tridarma System')

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
                    <li class="active">Home</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
       <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <div class="row row-in">
                        <div class="col-lg-3 col-sm-6 row-in-br">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-danger"><i class="ti-clipboard"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">{{ number_format(total_pendapatan_all()) }}</h3>
                                </li>
                                <li class="col-middle">
                                    <h4>Jumlah Pendapatan</h4>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-info"><i class="ti-wallet"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">{{ number_format(total_biaya_all()) }}</h3>
                                </li>
                                <li class="col-middle">
                                    <h4>Jumlah Biaya-biaya</h4>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-sm-6 row-in-br">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-success"><i class=" ti-wallet"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">{{ number_format(total_pendapatan_all() - total_biaya_all()) }}</h3>
                                </li>
                                <li class="col-middle">
                                    <h4>SHU Sementara</h4>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-sm-6  b-0">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-warning"><i class="fa fa-dollar"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">
                                        {{ number_format((total_pendapatan_all() - total_biaya_all()) * 0.15) }}
                                    </h3>
                                </li>
                                <li class="col-middle">
                                    <h4>Perkiraan Pajak 15 %</h4>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="white-box">
                    <div class="row row-in">
                        <div class="col-lg-3 col-sm-6 row-in-br">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-danger"><i class="ti-clipboard"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">
                                        {{ number_format( ((total_pendapatan_all() - total_biaya_all()) - (total_pendapatan_all() - total_biaya_all()) * 0.15)) }}
                                    </h3>
                                </li>
                                <li class="col-middle">
                                    <h4>SHU Setelah Pajak 15%</h4>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-info"><i class="ti-wallet"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">{{ number_format(total_aktiva_all()) }}</h3>
                                </li>
                                <li class="col-middle">
                                    <h4>Total Activa</h4>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-sm-6 row-in-br">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-success"><i class=" ti-wallet"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">{{ number_format(total_pasiva_all()) }}</h3>
                                </li>
                                <li class="col-middle">
                                    <h4>Total Pasiva</h4>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="white-box">
                    <h3 class="box-title pull-left"> NERACA KOPERASI TRI DHARMA</h3>
                    <a href="" class="btn btn-info btn-xs pull-right"><i class="fa fa-search-plus"></i> DETAIL NERACA</a>
                    <div class="clearfix"></div>
                    <hr />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr style="background: #eee;">
                                    <th>ACTIVA</th>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <th>{{ $year }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="3">A. Harta Lancar</th>
                                </tr>
                                @foreach($aktiva_harta_lancar as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <td><a href="" class="text_edit_aktiva" data-type="text" data-tahun="{{ $year }}" data-pk="{{ $item->id }}" data-title="Enter Nominal">{{ number_format(get_neraca_aktiva($item->id, $year)) }}</a></td>
                                    @endfor
                                </tr>
                                @endforeach

                                 <tr>
                                    <th colspan="3">B. Harta Tetap</th>
                                </tr>
                                @foreach($aktiva_harta_tetap as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <td><a href="" class="text_edit_aktiva" data-type="text" data-tahun="{{ $year }}" data-pk="{{ $item->id }}" data-title="Enter Nominal">{{ number_format(get_neraca_aktiva($item->id, $year)) }}</a></td>
                                    @endfor
                                </tr>
                                @endforeach
                                <tr>
                                    <th>TOTAL AKTIVA</th>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <th>{{ number_format( total_aktiva($year)) }}</th>
                                    @endfor
                                </tr>
                            
                                <tr style="background: #eee;">
                                    <th>PASIVA</th>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <th>{{ $year }}</th>
                                    @endfor
                                </tr>
                                <tr>
                                    <th colspan="3">C. Kewajiban Jangka Pendek</th>
                                </tr>
                                @foreach($pasiva_kewajiban_jangka_pendek as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <td><a href="" class="text_edit_pasiva" data-type="text" data-tahun="{{ $year }}" data-pk="{{ $item->id }}" data-title="Enter Nominal">{{ number_format(get_neraca_pasiva($item->id, $year)) }}</a></td>
                                    @endfor
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3">C. Kewajiban Lainnya</th>
                                </tr>
                                @foreach($pasiva_kewajiban_lainnya as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <td><a href="" class="text_edit_pasiva" data-type="text" data-tahun="{{ $year }}" data-pk="{{ $item->id }}" data-title="Enter Nominal">{{ number_format(get_neraca_pasiva($item->id, $year)) }}</a></td>
                                    @endfor
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3">C. Kewajiban Modal Sendiri</th>
                                </tr>
                                @foreach($pasiva_modal_sendiri as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <td><a href="" class="text_edit_pasiva" data-type="text" data-tahun="{{ $year }}" data-pk="{{ $item->id }}" data-title="Enter Nominal">{{ number_format(get_neraca_pasiva($item->id, $year)) }}</a></td>
                                    @endfor
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>TOTAL PASIVA</th>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <th>{{ number_format(total_pasiva($year)) }}</th>
                                    @endfor
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="white-box">
                    <h3 class="box-title pull-left">PERHITUNGAN HASIL USAHA</h3>
                    <a href="" class="btn btn-info btn-xs pull-right"><i class="fa fa-search-plus"></i> DETAIL HASIL USAHA</a>
                    <div class="clearfix"></div>
                    <hr />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr style="background: #eee;">
                                    <th>A. PENDAPATAN</th>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <th>{{ $year }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendapatan as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                        <th><a href="" class="text_edit_pendapatan" data-type="text" data-tahun="{{ $year }}" data-pk="{{ $item->id }}" data-title="Enter Nominal">{{ number_format(get_value_pendapatan($item->id, $year)) }}</a></th>
                                        @endfor
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Total Pendapatan</th>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <th>{{ number_format( total_pendapatan($year) ) }}</th>
                                    @endfor
                                </tr>
                                <tr  style="background: #eee;">
                                    <th>B. BIAYA-BIAYA</th>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <th>{{ $year }}</th>
                                    @endfor
                                </tr>
                                @foreach($biaya as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                        <th>
                                            <a href="" class="text_edit_biaya" data-type="text" data-tahun="{{ $year }}" data-pk="{{ $item->id }}" data-title="Enter Nominal">{{ number_format(get_value_biaya($item->id, $year)) }}</a>
                                        </th>
                                        @endfor
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Total Biaya - biaya</th>
                                    @for($year = date('Y'); $year > (date('Y') -3); $year--)
                                    <th>{{ number_format( total_biaya($year) ) }}</th>
                                    @endfor
                                </tr>
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
</div>

<style type="text/css">
    .col-in h3 {
        font-size: 20px;
    }
</style>

@section('footer-script')
<script type="text/javascript" src="{{ asset('admin-css/plugins/bower_components/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
<script type="text/javascript">

    $('.text_edit_aktiva').editable({
        type: 'text',
        title: 'Enter nominal',
        validate: function(value) {

            var id      = $(this).attr('data-pk')
            var tahun   = $(this).attr('data-tahun');
            $.ajax({
                url: "{{ route('ajax.submit_value_aktiva') }}", 
                data: {'id' : id, '_token' : '{{csrf_token()}}', 'value' : value, 'tahun' : tahun},
                type: 'POST',
                success: function(result){
                    console.log(result);
                }
            })
        }
    });

    $('.text_edit_pasiva').editable({
        type: 'text',
        title: 'Enter nominal',
        validate: function(value) {

            var id      = $(this).attr('data-pk')
            var tahun   = $(this).attr('data-tahun');
            $.ajax({
                url: "{{ route('ajax.submit_value_pasiva') }}", 
                data: {'id' : id, '_token' : '{{csrf_token()}}', 'value' : value, 'tahun' : tahun},
                type: 'POST',
                success: function(result){
                    console.log(result);
                }
            })
        }
    });


    $('.text_edit_biaya').editable({
        type: 'text',
        title: 'Enter nominal',
        validate: function(value) {

            var id      = $(this).attr('data-pk')
            var tahun   = $(this).attr('data-tahun');
            $.ajax({
                url: "{{ route('ajax.submit_value_biaya') }}", 
                data: {'id' : id, '_token' : '{{csrf_token()}}', 'value' : value, 'tahun' : tahun},
                type: 'POST',
                success: function(result){
                    console.log(result);
                }
            })
        }
    });


    $('.text_edit_pendapatan').editable({
        type: 'text',
        title: 'Enter nominal',
        validate: function(value) {

            var id      = $(this).attr('data-pk')
            var tahun   = $(this).attr('data-tahun');
            $.ajax({
                url: "{{ route('ajax.submit_value_pendapatan') }}", 
                data: {'id' : id, '_token' : '{{csrf_token()}}', 'value' : value, 'tahun' : tahun},
                type: 'POST',
                success: function(result){
                    console.log(result);
                }
            })
        }
    });


</script>
@endsection

@endsection



