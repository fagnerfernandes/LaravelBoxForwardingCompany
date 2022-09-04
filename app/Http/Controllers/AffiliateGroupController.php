<?php

namespace App\Http\Controllers;

use App\Models\AffiliateGroup;
use Illuminate\Http\Request;

class AffiliateGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $affiliateGroups = AffiliateGroup::orderBy('id', 'desc')->paginate();

        return View('affiliate_group.index', compact('affiliateGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('affiliate_group.create');
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
     * @param  \App\Models\AffiliateGroup  $affiliateGroup
     * @return \Illuminate\Http\Response
     */
    public function show(AffiliateGroup $affiliateGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AffiliateGroup  $affiliateGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(AffiliateGroup $affiliateGroup)
    {
        $affiliateGroup->load('courtesyServices.courtesable');
        
        return View('affiliate_group.edit', compact('affiliateGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AffiliateGroup  $affiliateGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AffiliateGroup $affiliateGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AffiliateGroup  $affiliateGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(AffiliateGroup $affiliateGroup)
    {
        //
    }
}
