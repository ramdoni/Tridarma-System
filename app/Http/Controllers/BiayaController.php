<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Biaya;

class BiayaController extends Controller
{	
	/**
	 * [index description]
	 * @return [type] [description]
	 */
    public function index()
    {
        $params['data'] = Biaya::orderBy('id', 'DESC')->get();

    	return view('biaya.index')->with($params);
    }

     /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        return view('biaya.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $data['data']   = Biaya::where('id', $id)->first();;
        
        return view('biaya.edit')->with($data);
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
            'name'              => 'required',
        ]);
        
        $data               =  Biaya::where('id', $id)->first();
        $data->name         = $request->name;
        $data->save();

        return redirect()->route('biaya.index')->with('message-success', 'Data berhasil disimpan'); 
    }


    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = Biaya::where('id', $id)->first();
        $data->delete();

        return redirect()->route('biaya.index')->with('message-sucess', 'Data berhasi di hapus');
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
            'name'              => 'required',
        ]);
        
        $data               =  new Biaya();
        $data->name         = $request->name;
        $data->save();

        return redirect()->route('biaya.index')->with('message-success', 'Data berhasil disimpan'); 
   }
}
