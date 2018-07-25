<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pinjaman;
use App\Cicilan;
use App\Transaksi;
use App\ModelUser;

class TagihanController extends Controller
{	
	/**
	 * [index description]
	 * @return [type] [description]
	 */
    public function index()
    {
        $params['cicilan_belum_bayar']    = Cicilan::where('tanggal_bayar', '<=', date('Y-m-d'))->where('status', 0)->get();
        $params['cicilan_3_hari']         = Cicilan::where('status', 0)->where('tanggal_bayar', '<=', date('Y-m-d', strtotime(' + 7 days')))->where('tanggal_bayar', '>=', date('Y-m-d', strtotime(' + 3 days')))->get();

    	return view('tagihan.index')->with($params);
    }

    /**
     * detail pinjaman
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {        
        $params['data']     = Pinjaman::where('id', $id)->first();
        $params['id']       = $id;

        return view('tagihan.detail')->with($params);
    } 

    /**
     * [confirmBayar description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function bayar($id)
    {
        $cicilan = Cicilan::where('id', $id)->first();
        
        $anggota = ModelUser::where('id', $cicilan->pinjaman->user_id)->first();

        if($cicilan->angsuran > $anggota->simpanan_sukarela)
        {
            return redirect()->route('tagihan.index')->with('message-error', 'Maaf Simpanan Sukarela Anda Kurang dari nominal pembayaran !');
        }

        $anggota->simpanan_sukarela = $anggota->simpanan_sukarela - $cicilan->angsuran;
        $anggota->save();

        $cicilan->status = 1;
        $cicilan->tanggal_lunas = date('Y-m-d');
        $cicilan->save();

        // Transaksi
        $data = new Transaksi();
        $data->nominal          = $cicilan->angsuran;
        $data->user_id          = $cicilan->pinjaman->user_id;
        $data->jenis_transaksi  = 'Cicilan';
        $data->key_id           = $cicilan->id;
        $data->save();

        return redirect()->route('tagihan.index')->with('message-success', 'Pembayaran cicilan berhasil di proses !');
    }
}
