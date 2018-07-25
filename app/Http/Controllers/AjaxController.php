<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModelUser;
use Auth;
use Session;
use Illuminate\Support\Facades\Input;
use App\NeracaAktiva;
use App\NeracaPasiva;
use App\HistoryBiaya;
use App\HistoryPendapatan;
use App\Cicilan;
use App\SimpananPokok;
use App\Deposit;
use App\SimpananWajib;
use App\Transaksi;
use App\Pinjaman;
use App\AhliWaris;

class AjaxController extends Controller
{
    protected $respon;

    /**
     * [__construct description]
     */
    public function __construct()
    {
        /**
         * [$this->respon description]
         * @var [type]
         */
        $this->respon = ['message' => 'success'];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ;
    }

    /**
     * [submitAhliWaris description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function submitAhliWaris(Request $request)
    {
        // cek simpanan
        $data = ModelUser::where('id', $request->user_id)->first();
        
        if($data)
        {
            $data                   = new AhliWaris();
            $data->user_id          = $request->user_id;
            $data->nama             = $request->nama;
            $data->tanggal_lahir    = $request->tanggal_lahir;
            $data->alamat           = $request->alamat;
            $data->nik              = $request->nik;
            $data->hubungan         = $request->hubungan;
            $data->save();

            return response()->json(['message' => 'success']);

        }else
            return response()->json(['message' => 'error', 'data' => 'Maaf data Anggota tidak ditemukan !']);
    }

    /**
     * [submitSimpananSukarela description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function submitSimpananSukarela(Request $request)
    {
        // cek simpanan
        $data = ModelUser::where('id', $request->user_id)->first();
        
        if($data)
        {
            $deposit            = new Deposit();
            $deposit->user_id   = $request->user_id;
            $deposit->nominal   = $request->nominal;
            $deposit->save();

            $data->simpanan_sukarela = $data->simpanan_sukarela + $request->nominal;
            $data->save();

            return response()->json(['message' => 'success', 'data' => 'Anda berhasil melakukan topup sebesar : <strong>'. $request->nominal .'</strong> ']);

        }else
            return response()->json(['message' => 'error', 'data' => 'Maaf data Anggota tidak ditemukan !']);

    }

    public function submitPremiAsuransi(Request $request)
    {
        // cek simpanan
        $data = ModelUser::where('id', $request->user_id)->first();
        
        if($data)
        {
            if($request->nominal > $data->simpanan_sukarela)
            {
                return response()->json(['message' => 'error', 'data' => 'Maaf Simpanan Sukarela Anda Kurang dari nominal pembayaran !']);
            }
            else 
            {
                $data->expired_term_life    = date('Y-m-d', strtotime('+ 1 Year'));
                $data->simpanan_sukarela = $data->simpanan_sukarela - $request->nominal;
                $data->save();

                $wajib          = new Transaksi();
                $wajib->user_id = $request->user_id;
                $wajib->nominal = $request->nominal;
                $wajib->jenis_transaksi = 'Premi Asuransi Reliance Term Life ';
                $wajib->save();

                return response()->json(['message' => 'success', 'data' => 'Simpanan Wajib berhasil di bayarkan !']);
            }   
        }
        else
        {

        }

        return response()->json(['message' => 'error']);
    }

    /**
     * [submitSimpananWajib description]
     * @return [type] [description]
     */
    public function submitSimpananWajib(Request $request)
    {
        // cek simpanan
        $data = ModelUser::where('id', $request->user_id)->first();
        
        if($data)
        {
            if($request->nominal > $data->simpanan_sukarela)
            {
                return response()->json(['message' => 'error', 'data' => 'Maaf Simpanan Sukarela Anda Kurang dari nominal pembayaran !']);
            }
            else 
            {
                $data->simpanan_wajib    = $request->nominal;
                $data->simpanan_sukarela = $data->simpanan_sukarela - $request->nominal;
                $data->save();

                $wajib          = new Transaksi();
                $wajib->user_id = $request->user_id;
                $wajib->nominal = $request->nominal;
                $wajib->jenis_transaksi = 'Simpanan Wajib';
                $wajib->save();

                return response()->json(['message' => 'success', 'data' => 'Simpanan Wajib berhasil di bayarkan !']);
            }   
        }
        else
        {

        }

        return response()->json(['message' => 'error']);
    }

    /**
     * [submitSimpananPokok description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function submitSimpananPokok(Request $request)
    {
        // cek simpanan
        $data = ModelUser::where('id', $request->user_id)->first();
        
        if($data)
        {
            if($request->nominal > $data->simpanan_sukarela)
            {
                return response()->json(['message' => 'error', 'data' => 'Maaf Simpanan Pokok Anda Kurang dari nominal pembayaran !']);
            }
            else 
            {
                $sp = new Transaksi();
                $sp->jenis_transaksi    = 'Simpanan Pokok';
                $sp->nominal            = $request->nominal;
                $sp->user_id            = $request->user_id;
                $sp->bulan              = $request->bulan;
                $sp->tahun              = $request->tahun;
                $sp->save();

                $data->simpanan_sukarela    = $data->simpanan_sukarela - $request->nominal;
                $data->simpanan_pokok       = $data->simpanan_pokok + $request->nominal; 
                $data->save();

                return response()->json(['message' => 'success', 'data' => 'Simpanan Pokok berhasil di bayarkan !']);
            }   
        }
        else
        {

        }

        return response()->json($this->respon);
    }

    /**
     * [submitCicilan description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function submitCicilan(Request $request)
    {
        if($request->ajax())
        {
            $cicilan = Cicilan::where('pinjaman_id', $request->id)->get();

            $date = $request->value;

            foreach($cicilan as $k => $item)
            {   
                $c                  = Cicilan::where('id', $item->id)->first();

                $c->tanggal_bayar   = date('Y-m-d', strtotime($date . '+ '.( $k+1 ).' month'));
                
                $c->save();
            }

            $pinjaman = Pinjaman::where('id', $request->id)->first();
            $pinjaman->created_at = $request->value;
            $pinjaman->save();

            Session::flash('message-success', 'Tanggal Aktivasi berhasil dirubah ');

            return response()->json($this->respon);
        }
    }

    /**
     * [submitPulsa description]
     * @return [type] [description]
     */
    public function submitValueAktiva(Request $request)
    {
        $data = NeracaAktiva::where('aktiva_id', $request->id)->where('tahun', $request->tahun)->first();
        
        if(!$data) $data               = new NeracaAktiva();

        $data->tahun        = $request->tahun;
        $data->aktiva_id    = $request->id;
        $data->nominal      = hapus_angka_koma($request->value);
        $data->save();
        
        return response()->json($this->respon);
    }

    /**
     * [submitPulsa description]
     * @return [type] [description]
     */
    public function submitValuePasiva(Request $request)
    {
        $data = NeracaPasiva::where('pasiva_id', $request->id)->where('tahun', $request->tahun)->first();
        
        if(!$data) $data               = new NeracaPasiva();

        $data->tahun        = $request->tahun;
        $data->pasiva_id    = $request->id;
        $data->nominal      = hapus_angka_koma($request->value);
        $data->save();
        
        return response()->json($this->respon);
    }

    /**
     * [submitValuePerhitungan description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function submitValuePendapatan(Request $request)
    {
        $data = HistoryPendapatan::where('pendapatan_id', $request->id)->where('tahun', $request->tahun)->first();
        
        if(!$data) $data               = new HistoryPendapatan();

        $data->tahun        = $request->tahun;
        $data->pendapatan_id= $request->id;
        $data->nominal      = hapus_angka_koma($request->value);
        $data->save();
        
        return response()->json($this->respon);
    }

    /**
     * [submitValueBiaya description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function submitValueBiaya(Request $request)
    {
        $data = HistoryBiaya::where('biaya_id', $request->id)->where('tahun', $request->tahun)->first();
        
        if(!$data) $data               = new HistoryBiaya();

        $data->tahun        = $request->tahun;
        $data->biaya_id     = $request->id;
        $data->nominal      = hapus_angka_koma($request->value);
        $data->save();
        
        return response()->json($this->respon);
    }
       
}
