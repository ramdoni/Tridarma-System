<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ModelUser; 
Use App\Pinjaman;
use App\Cicilan;
use App\PinjamanEndowment;
use App\CicilanEndowment;
use App\Deposit;
use App\SimpananPokok;
use App\SimpananWajib;
use App\Transaksi;
use App\AhliWaris;
use Auth;
use App\TempImportAnggota;

class AnggotaController extends Controller
{	
	/**
	 * [index description]
	 * @return [type] [description]
	 */
    public function index()
    {
    	$data = ModelUser::where('access_id', 2)->get();

    	return view('anggota.index', compact('data'));
    }

    /**
     * [import description]
     * @return [type] [description]
     */
    public function import()
    {
        $params['data'] = TempImportAnggota::all();

        return view('anggota.import')->with($params);
    }

    /**
     * [deleteTemp description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteTemp($id)
    {
        $data = TempImportAnggota::where('id', $id)->first();
        $data->delete();

        return redirect()->route('anggota.import')->with('message-success', 'Data temporary berhasil di hapus');
    }

    /**
     * [importOk description]
     * @return [type] [description]
     */
    public function importOk()
    {
        $data = TempImportAnggota::all();
        
        foreach($data as $item)
        {
            $no_anggota = date('y').date('m').date('d'). (ModelUser::all()->count() + 1);

            $user               = new ModelUser();
            $user->nik          = $item->nik;
            $user->name         = $item->nama;
            $user->email        = $item->email;
            $user->no_anggota   = $no_anggota;
            $user->tempat_lahir = $item->tempat_lahir;
            $user->tanggal_lahir= $item->tanggal_lahir;
            $user->jenis_kelamin= $item->jenis_kelamin;
            $user->alamat       = $item->alamat;
            $user->telepon      = $item->telepon;
            $user->agama        = $item->agama;
            $user->is_import    = 1;
            $user->access_id    = 2;
            $user->status       = 1;
            $user->tanggal_aktivasi=date('Y-m-d');
            $user->save();
        }

        TempImportAnggota::truncate();

        return redirect()->route('anggota.index')->with('message-success', 'Data berhasil di import');
    }   

    /**
     * [submitImport description]
     * @return [type] [description]
     */
    public function submitImport(Request $request)
    {
        if($request->file('file'))
        {
            $path = $request->file('file')->getRealPath();
            $data = \Excel::load($path, function($reader){
                
            })->get();

            if(!empty($data) && $data->count())
            {   
                // delete all data
                TempImportAnggota::truncate();

                foreach ($data->toArray() as $row)
                {
                    if(!empty($row))
                    {
                        $catatan    = '';
                        $user_id    = 0;

                        $cek_email  = ModelUser::where('nik', $row['nik'])->count();

                        if($cek_email != 0)
                        {
                            continue;
                        }

                        $temp               = new TempImportAnggota();
                        $temp->nik          = $row['nik'];
                        $temp->nama         = $row['nama'];
                        $temp->email        = $row['email'];
                        $temp->no_anggota   = 0;
                        $temp->tempat_lahir = $row['tempat_lahir'];
                        $temp->tanggal_lahir= $row['tanggal_lahir'];
                        $temp->jenis_kelamin= $row['jenis_kelamin'];
                        $temp->alamat       = $row['alamat'];
                        $temp->telepon      = $row['telepon'];
                        $temp->agama        = $row['agama'];
                        $temp->user_id      = $user_id;
                        $temp->catatan      = $catatan;
                        $temp->save();
                    }
                }
            }
        }

        return redirect()->route('anggota.import')->with('messages-success', 'Data Anggota berhasil di import');
    }

    /**
     * [topup description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function topup(Request $request)
    {
        $deposit = new Deposit();
        $deposit->nominal = $request->nominal;
        $deposit->user_id = $id;
        $deposit->save();

        return redirect()->route()->with('message-success', 'Anda berhasil melakukan topup sebesar : <strong>Rp. '. number_format($request->nominal) .'</strong>');
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        return view('anggota.create');
    }

    /**
     * [active description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function active($id)
    {
        $data = ModelUser::where('id', $id)->first();
        
        if($data)
        {
            $data->tanggal_aktivasi = date('Y-m-d');
            $data->status = 1;
            $data->save();
            
            return redirect()->route('anggota.index')->with('message-success', 'Data Anggota berhasil di aktifkan !');
        }else{
            return redirect()->route('anggota.index')->with('message-error', 'Data Anggota tidak ditemukan !');
        }
    }

    /**
     * [active description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function inactive($id)
    {
        $data = ModelUser::where('id', $id)->first();
        
        if($data)
        {
            $data->status = 0;
            $data->save();
            
            return redirect()->route('anggota.index')->with('message-success', 'Data Anggota berhasil di inaktif !');
        }else{
            return redirect()->route('anggota.index')->with('message-error', 'Data Anggota tidak ditemukan !');
        }
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
            return redirect()->route('anggota.detail', ['id' => $cicilan->pinjaman->user_id, '#pinjaman'])->with('message-error', 'Maaf Simpanan Sukarela Anda Kurang dari nominal pembayaran !');
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

        return redirect()->route('anggota.detail', ['id' => $cicilan->pinjaman->user_id, '#simpanan'])->with('message-success', 'Anda berhasil membayar cicilan.');
    }

    /**
     * [add_pinjaman description]
     */
    public function add_pinjaman($id)
    {
        $user = ModelUser::where('id', $id)->first();

        return view('anggota.add_pinjaman')->with(['id' => $id, 'user' => $user]);
    }

    /**
     * [submitpinjaman description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function submitpinjaman(Request $request)
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

        return redirect()->route('anggota.detail', ['id' => $request->user_id])->with('message-sucess', 'Pinjaman berhasil di submit');
    }


    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {
        $params['pinjaman']     = Pinjaman::where('user_id', $id)->get();
        $params['data']         = ModelUser::where('id', $id)->first();
        $params['pinjaman_endowment'] = Pinjaman::where('user_id', $id)->where('include_endowment', 1)->get();
        $params['deposit']      = Deposit::where('user_id', $id)->orderBy('id', 'DESC')->get();
        $params['simpanan_pokok']= SimpananPokok::where('user_id', $id)->orderBy('id', 'DESC')->get();
        $params['simpanan_wajib']= SimpananWajib::where('user_id', $id)->get();
        $params['transaksi']     = Transaksi::where('user_id', $id)->orderBy('id', 'DESC')->get();
        $params['ahli_waris']       = AhliWaris::where('user_id', $id)->get();

        return view('anggota.detail')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $user = ModelUser::where('id', $id)->first();
        $data['data'] 	= $user;
        $data['id'] 	= $id;
        
        return view('anggota.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data =  ModelUser::where('id', $id)->first();
        
        $data->nik         = $request->nik; 
        $data->name        = $request->nama; 
        $data->jenis_kelamin= $request->jenis_kelamin; 
        $data->email        = $request->email;
        $data->telepon      = $request->telepon;
        $data->agama        = $request->agama;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir;
        $data->is_endowment = 0;
        $data->status   = $request->status;
        $data->alamat       = $request->alamat;

        if($request->status == 1)
        {
            $data->tanggal_aktivasi = date('Y-m-d');
        }

        if ($request->hasFile('file_ktp')) {
            
            $image = $request->file('file_ktp');
            
            $name = time().'.'.$image->getClientOriginalExtension();
            
            $destinationPath = public_path('/file_ktp/'. Auth::user()->id);
            
            $image->move($destinationPath, $name);

            $data->foto_ktp = $name;
        }

        if ($request->hasFile('file_photo')) {
            
            $image = $request->file('file_photo');
            
            $name = time().'.'.$image->getClientOriginalExtension();
            
            $destinationPath = public_path('/file_photo/'. Auth::user()->id);
            
            $image->move($destinationPath, $name);
            
            $data->foto = $name;
        }
        

        $data->save();

        return redirect()->route('anggota.detail',['id' => $id])->with('message-success', 'Data berhasil disimpan'); 
    }


    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = ModelUser::where('id', $id)->first();
        $data->delete();

        return redirect()->route('anggota.index')->with('message-sucess', 'Data berhasi di hapus');
    }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $no_anggota = date('y').date('m').date('d'). (ModelUser::all()->count() + 1);

        $this->validate($request,[
            'nik'               => 'required|unique:users',
            'telepon'           => 'required',
            'nama'              => 'required',
            'email'             => 'required|email|unique:users'
        ]);
        
        $data               =  new ModelUser();
        $data->no_anggota   = $no_anggota;
        $data->nik          = $request->nik; 
        $data->name         = $request->nama; 
        $data->jenis_kelamin= $request->jenis_kelamin; 
        $data->email        = $request->email;
        $data->telepon      = $request->telepon;
        $data->agama        = $request->agama;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir= $request->tanggal_lahir; 
        $data->access_id    = 2; // Akses sebagai anggota
        $data->status       = 1; // menunggu pembayaran 
        $data->is_endowment  = 0;
        $data->status       = $request->status;
        $data->alamat       = $request->alamat;
        $data->save();

        if ($request->hasFile('file_ktp')) {
            
            $image = $request->file('file_ktp');
            
            $name = time().'.'.$image->getClientOriginalExtension();
            
            $destinationPath = public_path('/file_ktp/'. $data->id);
            
            $image->move($destinationPath, $name);

            $data->foto_ktp = $name;
        }

        if ($request->hasFile('file_photo')) {
            
            $image = $request->file('file_photo');
            
            $name = time().'.'.$image->getClientOriginalExtension();
            
            $destinationPath = public_path('/file_photo/'. $data->id);
            
            $image->move($destinationPath, $name);
            
            $data->foto = $name;
        }

        $data->save();

        return redirect()->route('anggota.index')->with('message-success', 'Data berhasil disimpan'); 
   }
}
