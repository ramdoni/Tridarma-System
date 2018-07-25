<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Premi;

class PremiController extends Controller
{	
	/**
	 * [index description]
	 * @return [type] [description]
	 */
    public function index()
    {
        $params['data'] = Premi::orderBy('id', 'DESC')->get();

    	return view('premi.index')->with($params);
    }

     /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        return view('premi.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $data['data']   = Premi::where('id', $id)->first();;
        
        return view('premi.edit')->with($data);
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
        $this->validate($request,[
            'tahun'              => 'required',
            'persen'              => 'required',
        ]);
        
        $data               = Premi::where('id', $id)->first();
        $data->tahun         = $request->tahun;
        $data->persen         = $request->persen;
        $data->save();

        return redirect()->route('premi.index')->with('message-success', 'Data berhasil disimpan'); 
    }


    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = Premi::where('id', $id)->first();
        $data->delete();

        return redirect()->route('premi.index')->with('message-sucess', 'Data berhasi di hapus');
    }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $this->validate($request,[
            'tahun'              => 'required',
            'rate'              => 'required',
        ]);
        
        $data               =  new Premi();
        $data->tahun         = $request->tahun;
        $data->persen         = $request->rate;
        $data->save();

        return redirect()->route('premi.index')->with('message-success', 'Data berhasil disimpan'); 
   }
}
