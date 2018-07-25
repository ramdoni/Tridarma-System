@extends('layouts.app')

@section('title', 'Form Pinjaman -Tridarma System')

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
                <h3 class="box-title m-b-0">Form Pinjaman</h3>
                <br />
                 <form class="form-horizontal" enctype="multipart/form-data" id="form-peminjaman" action="{{ route('pinjaman.store-pinjaman') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="umur" >
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Isi Data Anggota Terlebih Dahulu</label>
                            <input type="text" id="list-anggota" name="nama_anggota" required placeholder="NO ANGGOTA / NAMA ANGGOTA" class="form-control typeahead" name="no_anggota" />
                            <input type="hidden" name="user_id">
                        </div> 
                    </div>
                    <div class="clearfix"></div> 
                    <hr />
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

                    <div class="table_cicilan" style="display: none;">
                        <div class="form-group">
                            <label class="col-md-3">Plafond</label>
                            <label class="col-md-3">Masa (Bulan)</label>
                            <div class="clearfix"></div>
                            <div class="col-md-3">
                                <input type="text" name="nominal" class="form-control" value="{{ old('nominal') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control" name="tenor" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6" style="padding-left: 0;">
                                <div class="col-md-3" style="padding-left: 0;">
                                    <label class="col-md-12">Provisi (%)</label>
                                    <div class="col-md-12">
                                        <input type="number" name="provisi_" class="form-control" value="2">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-md-12">Jasa (%)</label>
                                    <div class="col-md-12">
                                        <input type="number" name="jasa_" class="form-control" value="18">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" name="total_endowment">
                                    <label><input type="checkbox" name="include_endowment" value="1" /> Inlcude Endowment</label>
                                    <input type="text" class="form-control" value="{{ number_format(get_setting('endowment')) }} per 1 Juta" readonly="true" />
                                    <input type="hidden" class="form-control" name="cash_back" placeholder="Cash Back default 1.000.000">
                                </div>
                                <div class="col-md-2">
                                    <label><input type="checkbox" name="include_ajk" value="1" /> Include Premi AJK</label>
                                    <input type="text" class="form-control" name="premi_ajk" value="" readonly="true" />
                                </div>
                            </div>
                        </div>
                        <div class="calculate-form">
                            <br />
                            <table class="table table-border">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sisa Pokok</th>
                                        <th>Angsuran</th>
                                        <th>Pokok</th>
                                        <th>Provisi</th>
                                        <th>Jasa</th>
                                        <th>Sisa Pokok</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <br />
                        <br />
                </div>
                <div class="clearfix"></div>
                <a href="{{ route('anggota.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                <button class="btn btn-sm btn-success waves-effect waves-light m-r-10" onclick="return confirm_()"><i class="fa fa-save"></i> Submit Pinjaman</button>
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

<div class="content_confim" style="display: none;">
    <h4>Berikut Rangkuman Data Peminjam :</h4>
    <table class="table table-border">
        <tr>
            <td>Anggota </td>
            <td class="td-anggota"></td>
        </tr>
        <tr>
            <td>Nominal Peminjaman </td>
            <td class="td-nominal"></td>
        </tr>
        <tr>
            <td>Include Endowment </td>
            <td class="td-endowment"></td>
        </tr>
        <tr>
            <td>Include Premi AJK </td>
            <td class="td-premi-ajk"></td>
        </tr>
    </table>

    <h4>Apakah anda akan proses peminjaman ini ?</h4>
</div>

@section('footer-script')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

    function confirm_()
    {
        // data form
        if($("input[name='nama_anggota']").val() == "" || $("input[name='tenor']").val() == "" || $("input[name='nominal']").val() == "")
        {
            bootbox.alert('Data anda belum lengkap !');

            return false;
        }

        bootbox.confirm({
            message: $('.content_confim').html(),
            buttons: {
                confirm: {
                    label: '<span class="btn btn-success btn-xs"><i class="fa fa-check"></i> Yes</span>',
                    className: 'btn-success'
                },
                cancel: {
                    label: '<span class="btn btn-danger btn-xs"><i class="fa fa-close"></i> No</span>',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result)
                {
                    $("form#form-peminjaman").submit();
                }
            }
        });

        return false;
    }

    var list_anggota = [];

    @foreach($anggota as $item)
        list_anggota.push({id : {{ $item->id }}, value : '{{ $item->no_anggota .' - '. $item->name }}', 'umur': {{ umur($item->tanggal_lahir) }}});
    @endforeach

    $( "#list-anggota" ).autocomplete({
        source: list_anggota,
        select: function( event, ui ) {
            $( "#list-anggota" ).val(ui.item.value);
            $( "input[name='user_id']" ).val(ui.item.id);
            $('.table_cicilan').show(ui.item.value);
            $('.td-anggota').html(ui.item.value);
            $("input[name='umur']").val(ui.item.umur);

            return false;
          }
    });

    $("input[name='tenor'], input[name='nominal'], input[name='provisi_'], input[name='jasa_'], input[name='cash_back']").on('input', function(){
        calculate();
    });

    $("input[name='include_endowment']").on('change', function(){

        if($("input[name='umur']").val() < {{ get_setting('endowment_minimal_umur') }})
        {
            bootbox.alert('Maaf batas minimal Umur Endowment {{ get_setting('endowment_minimall_umur') }} Tahun');

            $(this).prop("checked", false);

            return false;
        }

        if($("input[name='umur']").val() > {{ get_setting('endowment_maksimal_umur') }})
        {
            bootbox.alert('Maaf batas Makimsal Umur Endowment {{ get_setting('endowment_minimall_umur') }} Tahun');

            $(this).prop("checked", false);

            return false;
        }

        calculate();        
    });

    $("input[name='include_ajk']").on('change', function(){

        if($("input[name='umur']").val() < {{ get_setting('endowment_minimal_umur') }})
        {
            bootbox.alert('Maaf batas minimal Umur Premi AJK {{ get_setting('minimal_umur_premi_ajk') }} Tahun');

            $(this).prop("checked", false);

            return false;
        }

        if($("input[name='umur']").val() > {{ get_setting('endowment_maksimal_umur') }})
        {
            bootbox.alert('Maaf batas Makimsal Umur Endowment {{ get_setting('maksimal_umur_premi_ajk') }} Tahun');

            $(this).prop("checked", false);

            return false;
        }

        calculate();        
    });

    function calculate()
    {
        var tenor       = parseInt($("input[name='tenor']").val());
        var pokok       = parseInt($("input[name='nominal']").val());
        var provisi     = parseInt($("input[name='provisi_']").val());
        var jasa        = parseInt($("input[name='jasa_']").val());
        var include_endowment = $("input[name='include_endowment']").prop('checked');
        var include_ajk = $("input[name='include_ajk']").prop('checked');
        var endowment   = 0;
        var premi       = 0;

        $('.td-nominal').html(numberWithComma(pokok));

        if(include_ajk == true)
        {
            $('.td-premi-ajk').html('<span class="btn btn-success btn-xs"><i class="fa fa-check"></i> Yes</span>');

            obj_premi = [];

            @foreach($premi as $item)
                obj_premi.push({ 'persen' : {{ $item->persen }}, 'tahun' : {{ $item->tahun }} });
            @endforeach

            // cek premi AJK
            masa_tahun = Math.floor(tenor / 12);
            rate = 0;

            $(obj_premi).each(function(x, v){

                if(v.tahun == masa_tahun) rate = v.persen

            });

            if(rate != 0)
            {
                premi = parseInt(Math.round((pokok * rate) / 1000));

                $("input[name='premi_ajk']").val(numberWithComma(premi));
            }else{
                bootbox.alert('Batas Minimal dan Maksimal Premi AJK dari {{ $maksimal_ajk}} tahun sampai {{ $minimal_ajk }} tahun');
                $("input[name='include_ajk']").prop('checked', false)
                $("input[name='premi_ajk']").val("");
            }
        }
        else
        {
            $('.td-premi-ajk').html('<span class="btn btn-danger btn-xs"><i class="fa fa-close"></i> No</span>');
        }

        if(isNaN(pokok) || isNaN(tenor))
            return false;

        var total_loop_endowment = 0;

        if(include_endowment == true)
        {
            $("input[name='cash_back']").attr('type', 'input');

            var endowment = {{ get_setting('endowment')}}; 

            var input_cash_back = $("input[name='cash_back']").val() == "" ? 1000000 : $("input[name='cash_back']").val();

            endowment = (parseInt(input_cash_back) / 1000000) * parseInt(endowment); 

            $("input[name='total_endowment']").val(parseInt(endowment));
            
            $('.td-endowment').html('<span class="btn btn-success btn-xs"><i class="fa fa-check"></i> Yes</span>');

            total_loop_endowment = parseInt(Math.floor(pokok / 1000000));
        }
        else
        {
            $("input[name='cash_back']").attr('type', 'hidden');

            $('.td-endowment').html('<span class="btn btn-danger btn-xs"><i class="fa fa-close"></i> No</span>');
        }

        if(pokok == 0 || pokok == "" || tenor == 0 || tenor == "") return false;
       
        var provisi = (( provisi  / 100 ) * pokok) / tenor;  
        var jasa = (( parseInt(jasa)  / 100 ) * pokok) / tenor; 
        
        var cicilan_perbulan = (pokok + (jasa * tenor ) + (provisi * tenor) ) / tenor;
        
        var calculate_form = '';
        var sisa_pokok = pokok + (jasa * tenor ) + (provisi * tenor) ;
        var total_tenor = 0;

        for(var a=1; a <= tenor; a++)
        {
            calculate_form +='<tr>';
            calculate_form +='<td>'+ a +'</td>';
            calculate_form +='<td>'+ numberWithComma(Math.round(sisa_pokok)) +'</td>';
            calculate_form += '<input type="hidden" name="sisa_pokok[]" value="' + Math.round(sisa_pokok) + '" />';

            if(a == 1)
            {
                var angsuran = parseInt(Math.round(cicilan_perbulan+premi));
            }else{
                var angsuran = parseInt(Math.round(cicilan_perbulan));                
            }

            if(include_endowment == true)
            {
                angsuran =  angsuran + parseInt(endowment);    
            }

            var pokok_ = Math.round(cicilan_perbulan  - provisi - jasa);
            
            sisa_pokok -= (cicilan_perbulan);            

            calculate_form +='<td>'+ numberWithComma(angsuran) +'</td>';
            calculate_form +='<td>'+ numberWithComma(pokok_) +'</td>';
            calculate_form +='<td>'+ numberWithComma(Math.round(provisi)) +'</td>';
            calculate_form +='<td>'+ numberWithComma(Math.round(jasa)) +'</td>';
            calculate_form +='<td>'+ numberWithComma(Math.round(sisa_pokok)) +'</td>';
            calculate_form +='</tr>';

            if(a == 1)
            {
                calculate_form += '<input type="hidden" name="angsuran[]" value="' + Math.round(angsuran+premi) + '" />';
            }
            else
            {
                calculate_form += '<input type="hidden" name="angsuran[]" value="' + angsuran + '" />';
            }

            calculate_form += '<input type="hidden" name="pokok[]" value="' + Math.round(cicilan_perbulan) + '" />';
            calculate_form += '<input type="hidden" name="provisi[]" value="' + Math.round(provisi) + '" />';
            calculate_form += '<input type="hidden" name="jasa[]" value="' + Math.round(jasa) + '" />';

            total_tenor++;
        }
        
        total_tenor++;

        if(include_endowment == true)
        {
            if(tenor < 12)
            {
                for(var a=total_tenor; a <= 12; a++)
                {
                    calculate_form +='<tr>';
                    calculate_form +='<td>'+ a +'</td>';
                    calculate_form +='<td>0</td>';

                    var angsuran =  parseInt(endowment);         

                    calculate_form +='<td>'+ numberWithComma(angsuran) +'</td>';
                    calculate_form +='<td>'+ numberWithComma(0) +'</td>';
                    calculate_form +='<td>'+ numberWithComma(Math.round(provisi)) +'</td>';
                    calculate_form +='<td>'+ numberWithComma(Math.round(jasa)) +'</td>';
                    calculate_form +='<td>'+ numberWithComma(Math.round(sisa_pokok)) +'</td>';
                    calculate_form +='</tr>';
                    calculate_form += '<input type="hidden" name="sisa_pokok[]" value="0" />';
                    calculate_form += '<input type="hidden" name="angsuran[]" value="' + angsuran + '" />';
                    calculate_form += '<input type="hidden" name="pokok[]" value="0" />';
                    calculate_form += '<input type="hidden" name="provisi[]" value="0" />';
                    calculate_form += '<input type="hidden" name="jasa[]" value="0" />';

                }
            }
        }

        $('.calculate-form tbody').html(calculate_form);
    }

</script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
