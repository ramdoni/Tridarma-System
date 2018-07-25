<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pasiva;
use App\ModelUser;

class PasivaController extends Controller
{	
	/**
	 * [index description]
	 * @return [type] [description]
	 */
    public function index()
    {
        $params['data'] = Pasiva::orderBy('id', 'DESC')->get();

    	return view('pasiva.index')->with($params);
    }

     /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        return view('pasiva.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $data['data']   = Pasiva::where('id', $id)->first();;
        
        return view('pasiva.edit')->with($data);
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
        
        $data               = Pasiva::where('id', $id)->first();
        $data->group        = $request->group;
        $data->name         = $request->name;
        $data->save();

        return redirect()->route('pasiva.index')->with('message-success', 'Data berhasil disimpan'); 
    }


    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = Pasiva::where('id', $id)->first();
        $data->delete();

        return redirect()->route('pasiva.index')->with('message-sucess', 'Data berhasi di hapus');
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
        
        $data               =  new Pasiva();
        $data->group        = $request->group;
        $data->name         = $request->name;
        $data->save();

        return redirect()->route('pasiva.index')->with('message-success', 'Data berhasil disimpan'); 
   }
}
