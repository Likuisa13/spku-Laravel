<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Polusi::all();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::table('polusis')->insert([
            'kode' => $request->get('loc'),
            // 'latitude' => $request->get('lat'),
            // 'longitude' => $request->get('long'),
            'suhu' => $request->get('suhu'),
            'kelembaban' => $request->get('hum'),
            'co' => $request->get('co'),
            'debu' => $request->get('debu')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('polusis')->insert([
            'kode' => $request->get('loc'),
            // 'latitude' => $request->get('lat'),
            // 'longitude' => $request->get('long'),
            'suhu' => $request->get('suhu'),
            'kelembaban' => $request->get('hum'),
            'co' => $request->get('co'),
            'debu' => $request->get('debu')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Polusi  $polusi
     * @return \Illuminate\Http\Response
     */
    public function show(Polusi $polusi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Polusi  $polusi
     * @return \Illuminate\Http\Response
     */
    public function edit(Polusi $polusi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Polusi  $polusi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Polusi $polusi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Polusi  $polusi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Polusi $polusi)
    {
        //
    }
}
