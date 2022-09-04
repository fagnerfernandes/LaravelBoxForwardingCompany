<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Faq::query();

        $rows = $query->paginate();
        return view('faqs.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqRequest $request)
    {
        if (Faq::create($request->all())) {
            flash()->success('Faq adicoinada com sucesso!');
        } else {
            flash()->error('Houve um erro ao adicionar a Faq');
        }
        return redirect(route('faqs.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Faq  $faq
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        return view('faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return view('faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        if ($faq->update($request->all())) {
            flash()->success('Faq editada com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar o Faq');
        }
        return redirect(route('faqs.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq = Faq::findOrFail($faq);
        if ($faq->delete()) {
            flash()->success('Faq removido com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover o Faq');
        }
        return redirect(route('faqs.index'));
    }
}
