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
                <h3 class="box-title m-b-0">Pinjaman</h3>
                <br />
                 <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('anggota.submitpinjaman') }}" method="POST">
                    <input type="hidden" name="user_id" value="{{ $id }}">
                    
                    {{ csrf_field() }}
                    
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
                    <div class="form-group">
                        <label class="col-md-3">Plafond</label>
                        <label class="col-md-3">Masa (Bulan)</label>
                        <div class="clearfix"></div>
                        <div class="col-md-3">
                            <input type="number" name="nominal" class="form-control" value="{{ old('nominal') }}">
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
                            <div class="col-md-3" style="padding-left: 0;">
                                <label class="col-md-12">Jasa (%)</label>
                                <div class="col-md-12">
                                    <input type="number" name="jasa_" class="form-control" value="18">
                                </div>
                            </div>
                            <div class="col-md-6" style="padding-right:0">
                                <input type="hidden" name="total_endowment">
                                <label><input type="checkbox" name="include_endowment" {{ $user->is_endowment == 1 ? ' checked="true"' : '' }}  value="1" /> Inlcude Endowment</label>
                                <input type="text" class="form-control" value="85.000 per 1 Juta" readonly="true" />
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
                <div class="clearfix"></div>
                <a href="{{ route('anggota.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Submit Pinjaman</button>
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
@section('footer-script')
<script type="text/javascript">

    $("input[name='tenor']").on('input', function(){
        calculate();
    }); 

    $("input[name='nominal']").on('input', function(){
        calculate();
    });

    $("input[name='provisi_'], input[name='jasa_']").on('input', function(){
        calculate();
    });

    $("input[name='include_endowment']").on('change', function(){
        calculate();        
    });

    function calculate()
    {
        var tenor       = parseInt($("input[name='tenor']").val());
        var pokok       = parseInt($("input[name='nominal']").val());
        var provisi     = parseInt($("input[name='provisi_']").val());
        var jasa        = parseInt($("input[name='jasa_']").val());
        var include_endowment = $("input[name='include_endowment']").prop('checked');
        var endowment   = 0;

        if(isNaN(pokok) || isNaN(tenor)) 
            return false;

        if(include_endowment == true)
        {
            endowment = (8.5 * pokok) / 100; 

            $("input[name='total_endowment']").val(parseInt(endowment));
        }

        if(pokok == 0 || pokok == "" || tenor == 0 || tenor == "") return false;
        
        var cicilan_perbulan = (pokok + parseInt(endowment)) / tenor;
        var provisi = (( provisi  / 100 ) * pokok) / tenor;  
        var jasa = (( jasa  / 100 ) * pokok) / tenor;  
        var calculate_form = '';
        var sisa_pokok = pokok;

        for(var a=1; a <= tenor; a++)
        {
            calculate_form +='<tr>';
            calculate_form +='<td>'+ a +'</td>';
            calculate_form +='<td>'+ numberWithComma(Math.round(sisa_pokok)) +'</td>';
            calculate_form += '<input type="hidden" name="sisa_pokok[]" value="' + Math.round(sisa_pokok) + '" />';
            calculate_form +='<td>'+ numberWithComma(Math.round(cicilan_perbulan+provisi+jasa)) +'</td>';
            calculate_form +='<td>'+ numberWithComma(Math.round(cicilan_perbulan)) +'</td>';
            calculate_form +='<td>'+ numberWithComma(Math.round(provisi)) +'</td>';
            calculate_form +='<td>'+ numberWithComma(Math.round(jasa)) +'</td>';
            sisa_pokok -= (cicilan_perbulan);            
            calculate_form +='<td>'+ numberWithComma(Math.round(sisa_pokok)) +'</td>';
            calculate_form +='</tr>';

            calculate_form += '<input type="hidden" name="angsuran[]" value="' + Math.round(cicilan_perbulan+provisi+jasa) + '" />';
            calculate_form += '<input type="hidden" name="pokok[]" value="' + Math.round(cicilan_perbulan) + '" />';
            calculate_form += '<input type="hidden" name="provisi[]" value="' + Math.round(provisi) + '" />';
            calculate_form += '<input type="hidden" name="jasa[]" value="' + Math.round(jasa) + '" />';

        }

        $('.calculate-form tbody').html(calculate_form);
    }

</script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
