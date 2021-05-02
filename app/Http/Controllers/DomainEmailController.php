<?php

namespace App\Http\Controllers;

use App\DataTables\DomainEmailDataTable;
use App\DomainEmail;
use Illuminate\Http\Request;

class DomainEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DomainEmailDataTable $dataTable)
    {
      return $dataTable->render('domains.email');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DomainEmail  $domainEmail
     * @return \Illuminate\Http\Response
     */
    public function show(DomainEmail $domainEmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DomainEmail  $domainEmail
     * @return \Illuminate\Http\Response
     */
    public function edit(DomainEmail $domainEmail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DomainEmail  $domainEmail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DomainEmail $domainEmail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DomainEmail  $domainEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(DomainEmail $domainEmail)
    {
        //
    }
}
