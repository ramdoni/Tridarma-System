<?php 

/**
 * [agama description]
 * @return [type] [description]
 */
function agama()
{
	return ['Muslim', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
}

/**
 * [status_endowment description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function status_endowment($id)
{
	$data = \App\Pinjaman::where('user_id', $id)->orderBy('id', 'DESC')->first();

	if($data)
	{
		return '<label class="btn btn-xs btn-info">'. ($data->include_endowment == 0 ? 'No' : 'Yes' ).'</label>';
	}
	else
	{
		return '<label class="btn btn-xs btn-info">No</label>';
	}
}

/**
 * [get_setting description]
 * @param  [type] $key [description]
 * @return [type]      [description]
 */
function get_setting($key)
{
	$setting = \App\Setting::where('key', $key)->first();

	if($setting)
		return $setting->value;
	else
		return '';
}

/**
 * [umur description]
 * @param  [type] $birthday [description]
 * @return [type]           [description]
 */
function umur($birthday)
{

	// Convert Ke Date Time
	$biday = new \DateTime($birthday);
	$today = new \DateTime();
	
	$diff = $today->diff($biday);

	if($diff->m >= 6) 
		$tambahan = 1;
	else
		$tambahan = 0;

	return $diff->y + $tambahan;
}

/**
 * [status_simpanan_pokok description]
 * @param  [type] $bulan   [description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function status_simpanan_pokok($bulan, $user_id, $tahun = 0, $bulan_str = '')
{

	// Default tahun sekarang jika tahun tidak diisi
	if($tahun == 0) $tahun = date('Y');

	$data = \App\Transaksi::where('bulan', $bulan)->where('user_id', $user_id)->where('tahun', $tahun)->where('jenis_transaksi', 'Simpanan Pokok')->first();

	if($data)
	{
		return '<label class="btn btn-success btn-xs"><i class="fa fa-check"></i>  Lunas</label>';
	}
	else
	{
		return '<label class="btn btn-danger btn-xs" onclick="bayar_simpanan_pokok('. $user_id .', '. $bulan .', '. $tahun .', \''. $bulan_str .'\')"><i class="fa fa-usd"></i> Bayar </label>';
	}
}

/**
 * [tanggal_pertama_cicil description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function tanggal_pertama_cicil($id)
{
	$data = \App\Cicilan::where('pinjaman_id', $id)->where('status', 0)->orderBy('id', 'ASC')->first();

	if($data)
	{
		return $data->tanggal_bayar;
	}
	else
	{	
		$data = \App\Cicilan::where('pinjaman_id', $id)->orderBy('id', 'ASC')->first();
		
		if($data)
		{
			return $data->tanggal_bayar;
		}
		else
		{
			return '';
		}
	}
}

/**
 * [tanggal_jatuh_tempo description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function tanggal_jatuh_tempo($id)
{
	$data = \App\Cicilan::where('tanggal_bayar', '>=', date('Y-m-d'))->where('pinjaman_id', $id)->orderBy('id', 'ASC')->first();

	if($data)
		return $data->tanggal_bayar;
	else{
		
		$data = \App\Cicilan::where('pinjaman_id', $id)->orderBy('id', 'ASC')->first();

		if($data)
		{
			return $data->tanggal_bayar;
		}
		else
		{
			return '';			
		}
	}
}

/**
 * [last_cicilan_angsuran description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function last_cicilan_angsuran($id)
{

	$data = \App\Pinjaman::where('id', $id)->orderBy('id', 'ASC')->first();

	if(isset($data))
	{
		foreach($data->cicilan as $item)
		{
			if($item->status == 1) continue;

			return $item->angsuran;
		}
	}
	else
		return '0';
}
	
/**
 * [last_cicilan description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function last_cicilan($id)
{
	$data = \App\Cicilan::where('id', $id)->orderBy('id', 'ASC')->first();

	return $data;
}
/**
 * [kekata description]
 * @param  [type] $x [description]
 * @return [type]    [description]
 */
function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = kekata($x/10)." puluh". kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x <1000) {
        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
    }     
        return $temp;
}
 
/**
 * [terbilang description]
 * @param  [type]  $x     [description]
 * @param  integer $style [description]
 * @return [type]         [description]
 */
function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }     
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }     
    return $hasil;
}

/**
 * [format_int_ description]
 * @param  [type] $number [description]
 * @return [type]         [description]
 */
function hapus_angka_koma($number)
{
	$number = str_replace(',', '', $number);
	$number = str_replace('.', '', $number);

	return $number;
}

/**
 * [status_pinjaman description]
 * @param  [type] $status [description]
 * @return [type]         [description]
 */
function status_pinjaman($status)
{
	$html = '';

	switch($status)
	{
		case 1:
			$html = '<span class="btn btn-xs btn-warning"><i class="fa fa-spinner"></i> Aktif</span>'; 
		break;

		case 2:
			$html = '<span class="btn btn-xs btn-warning"><i class="fa fa-check"></i> Selesai</span>'; 
		break;
	}

	return $html;
}	

/**
 * [get_aktiva description]
 * @param  [type] $aktiva_id [description]
 * @param  [type] $tahun     [description]
 * @return [type]            [description]
 */
function get_neraca_aktiva($id, $tahun)
{
	$aktiva = App\NeracaAktiva::where('aktiva_id', $id)->where('tahun', $tahun)->first();

	if($aktiva)
		return $aktiva->nominal;
	else
		return '0';
}

/**
 * [get_neraca_pasiva description]
 * @param  [type] $id    [description]
 * @param  [type] $tahun [description]
 * @return [type]        [description]
 */
function get_neraca_pasiva($id, $tahun)
{
	$pasiva = App\NeracaPasiva::where('pasiva_id', $id)->where('tahun', $tahun)->first();

	if($pasiva)
		return $pasiva->nominal;
	else
		return '0';
}

/**
 * [get_pendapatan description]
 * @param  [type] $id    [description]
 * @param  [type] $tahun [description]
 * @return [type]        [description]
 */
function get_value_pendapatan($id, $tahun)
{
	$pendapatan = App\HistoryPendapatan::where('pendapatan_id', $id)->where('tahun', $tahun)->first();

	if($pendapatan)
		return $pendapatan->nominal;
	else
		return '0';
}

/**
 * [get_value_biaya description]
 * @param  [type] $id    [description]
 * @param  [type] $tahun [description]
 * @return [type]        [description]
 */
function get_value_biaya($id, $tahun)
{
	$pendapatan = App\HistoryBiaya::where('biaya_id', $id)->where('tahun', $tahun)->first();

	if($pendapatan)
		return $pendapatan->nominal;
	else
		return '0';
}

/**
 * [total_biaya description]
 * @param  [type] $tahun [description]
 * @return [type]        [description]
 */
function total_biaya($tahun)
{
	$total = \DB::table('history_biaya')->select(DB::raw('SUM(nominal) as total'))->where('tahun', $tahun)->first();

	if($total)
		return $total->total;
	else
		return '0';
}

/**
 * [total_aktiva description]
 * @param  [type] $tahun [description]
 * @return [type]        [description]
 */
function total_aktiva($tahun)
{
	$total = \DB::table('neraca_aktiva')->select(DB::raw('SUM(nominal) as total'))->where('tahun', $tahun)->first();

	if($total)
		return $total->total;
	else
		return '0';
}

/**
 * [total_pasiva description]
 * @param  [type] $tahun [description]
 * @return [type]        [description]
 */
function total_pasiva($tahun)
{
	$total = \DB::table('neraca_pasiva')->select(DB::raw('SUM(nominal) as total'))->where('tahun', $tahun)->first();

	if($total)
		return $total->total;
	else
		return '0';
}

/**
 * [total_pasiva_all description]
 * @param  [type] $tahun [description]
 * @return [type]        [description]
 */
function total_pasiva_all()
{
	$total = \DB::table('neraca_pasiva')->select(DB::raw('SUM(nominal) as total'))->first();

	if($total)
		return $total->total;
	else
		return '0';
}

/**
 * [total_aktiva_alll description]
 * @return [type] [description]
 */
function total_aktiva_all()
{
	$total = \DB::table('neraca_aktiva')->select(DB::raw('SUM(nominal) as total'))->first();

	if($total)
		return $total->total;
	else
		return '0';
}

/**
 * [total_pendapatan description]
 * @param  [type] $tahun [description]
 * @return [type]        [description]
 */
function total_pendapatan($tahun)
{
	$total = \DB::table('history_pendapatan')->select(DB::raw('SUM(nominal) as total'))->where('tahun', $tahun)->first();

	if($total)
		return $total->total;
	else
		return '0';
}

/**
 * [total_pendapatan_all description]
 * @return [type] [description]
 */
function total_pendapatan_all()
{
	$total = \DB::table('history_pendapatan')->select(DB::raw('SUM(nominal) as total'))->first();

	if($total)
		return $total->total;
	else
		return '0';
}

/**
 * [total_biaya_all description]
 * @return [type] [description]
 */
function total_biaya_all()
{
	$total = \DB::table('history_biaya')->select(DB::raw('SUM(nominal) as total'))->first();

	if($total)
		return $total->total;
	else
		return '0';
}

