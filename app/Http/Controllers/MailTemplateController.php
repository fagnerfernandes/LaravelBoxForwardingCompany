<?php

namespace App\Http\Controllers;

use App\Models\MailTemplate;
use Illuminate\Http\Request;

class MailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mailTemplates = MailTemplate::orderBy('type', 'asc')->paginate();

        return View('mail_templates.index', compact('mailTemplates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('mail_templates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MailTemplate  $mailTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(MailTemplate $mailTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MailTemplate  $mailTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(MailTemplate $mailTemplate)
    {
        return View('mail_templates.edit', compact('mailTemplate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MailTemplate  $mailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MailTemplate $mailTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MailTemplate  $mailTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(MailTemplate $mailTemplate)
    {
        if ($mailTemplate->delete()) {
            flash()->success('Template removido com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover o template');
        }
        return redirect()->route('mail_templates.index');
    }
}
