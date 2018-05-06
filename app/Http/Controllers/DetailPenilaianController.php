<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DetailPenilaian;
use App\Penilaian;
use App\Komponen;
use URI;

class DetailPenilaianController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $komponen = Komponen::all();

        return view('asesor.detail-penilaian.create', compact('penilaian', 'komponen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        $skor = $request->skor;
        $id_komponen = $request->id_komponen;

        // return response()->json($id_komponen);
        $count = 0;

        if(count($id_komponen) > count($skor)) {
            $count = count($id_komponen);
        }else $count = count($skor);

        // set data
        for($r = 0; $r < $count; $r++) {
            $data = array(
                'id_penilaian'  => $id,
                'id_komponen'   => $id_komponen[$r],
                'skor'          => $skor[$r]
            );

            DetailPenilaian::create($data);
        }

        return redirect(route('asesor.penilaian.index'))->with('notification', 'Action Completed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       $detailPenilaian = Komponen::join('detail_penilaian', 'detail_penilaian.id_komponen', 'komponen.id_komponen')
                                ->join('penilaian', 'penilaian.id_penilaian', 'detail_penilaian.id_penilaian')
                                ->where('id_peserta', $id)
                                ->select('komponen.id_komponen', 'komponen', 'parent_komponen', 'skor')
                                // ->get();
                                ->paginate(7);

        // dd($detailPenilaian);


        return view('asesor.detail-penilaian.show', compact('penilaian', 'detailPenilaian'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
}
