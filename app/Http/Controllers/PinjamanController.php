<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pinjaman;
use App\Cicilan;
use App\Premi;
use App\ModelUser;
use App\Transaksi;

class PinjamanController extends Controller
{	
	/**
	 * [index description]
	 * @return [type] [description]
	 */
    public function index()
    {
        $params['pinjaman']             = Pinjaman::all();
        $params['pinjaman_endowment']   = Pinjaman::all();

        if(isset($_GET))
        {
            $data = Pinjaman::orderBy('id', 'DESC');

            if(isset($_GET['include_endowment']) and $_GET['include_endowment'] == 1)
            {
                $data = $data->where('include_endowment', $_GET['include_endowment']);
            }

            if(isset($_GET['include_premi_ajk']) and $_GET['include_premi_ajk'] == 1)
            {
                $data = $data->where('include_premi_ajk', $_GET['include_premi_ajk']);
            }
            

            $params['pinjaman']  = $data->get();
        }

    	return view('pinjaman.index')->with($params);
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

        return view('pinjaman.detail')->with($params);
    }   

    /**
     * menambah transaksi pinjaman
     */
    public function add()
    {   
        $params['premi']        = Premi::all();
        $params['anggota']      = ModelUser::where('access_id', 2)->where('status', 1)->get();
        $params['maksimal_ajk'] = Premi::orderBy('tahun', 'ASC')->first()->tahun;
        $params['minimal_ajk'] = Premi::orderBy('tahun', 'DESC')->first()->tahun;

        return view('pinjaman.add')->with($params);
    }

    /**
     * [bayar description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function bayar($id)
    {
        $cicilan = Cicilan::where('id', $id)->first();
        
        $anggota = ModelUser::where('id', $cicilan->pinjaman->user_id)->first();

        if($cicilan->angsuran > $anggota->simpanan_sukarela)
        {
            return redirect()->route('pinjaman.detail', ['id' => $cicilan->pinjaman->id])->with('message-error', 'Maaf Simpanan Sukarela Anda Kurang dari nominal pembayaran !');
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

        $total         = Cicilan::where('pinjaman_id', $cicilan->pinjaman->id)->where('status', 0)->count();
        
        if( $total ==0 )
        {
            // Rubah status peminjaman jadi selesai
            $data = Pinjaman::where('id', $cicilan->pinjaman->id)->first();
            $data->status = 2;
            $data->save();
        }

        return redirect()->route('pinjaman.detail', ['id' => $cicilan->pinjaman->id])->with('message-success', 'Anda berhasil membayar cicilan.');
    }

    /**
     * [storeadd description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function storePinjaman(Request $request)
    {
        $pinjaman = new Pinjaman;
        $pinjaman->tenor        = $request->tenor;
        $pinjaman->nominal      = $request->nominal;
        $pinjaman->user_id      = $request->user_id;
        $pinjaman->status       = 1;
        $pinjaman->provisi      = $request->provisi_;
        $pinjaman->jasa         = $request->jasa_;
        $pinjaman->total_endowment      = $request->total_endowment;
        $pinjaman->include_endowment    = $request->include_endowment;
        $pinjaman->include_premi_ajk = $request->include_ajk;
        $pinjaman->nominal_premi_ajk = (!empty($request->premi_ajk) ? hapus_angka_koma($request->premi_ajk) : 0);
        $pinjaman->save();

        foreach($request->sisa_pokok as $key => $item)
        {
            $cicilan = new Cicilan;
            $cicilan->pinjaman_id   = $pinjaman->id;
            $cicilan->tanggal_bayar = date('Y-m-d', strtotime('+'. ($key+1) .' month'));
            $cicilan->status        = 0;
            $cicilan->sisa_pokok    = $item;
            $cicilan->angsuran      = $request->angsuran[$key];
            $cicilan->pokok         = $request->pokok[$key];
            $cicilan->provisi       = $request->provisi[$key];
            $cicilan->jasa          = $request->jasa[$key];
            $cicilan->save();
        }

        return redirect()->route('pinjaman.index')->with('messages-success', 'Pengajuan Pinjaman anda berhasil di proses !');
    }
}
