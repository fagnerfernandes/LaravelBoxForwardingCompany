@extends('layouts.app')

@section('title')
    Lista de Templates de E-mail
@endsection

@section('breadcrumbs')
    <li class="active"><span>Lista de Templates de E-mail</span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h6>Lista de Templates de E-mail</h6>
                
                    <a href="{{ route('mail_templates.create') }}" class="btn btn-success btn-sm">
                        <i class="bx bx-plus"></i> Adicionar
                    </a>
                </div>
                <div class="table-wrap mt-10">
                    <div class="table-responsive mb-4">
                        <table class="table table-hover mb-0">
                            <thead>
                                <th>#</th>
                                <th>Template</th>
                                <th>Tipo</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($mailTemplates as $mailTemplate)
                                    <tr class="align-middle">
                                        <td>{{ $mailTemplate->id }}</td>
                                        <td>{{ $mailTemplate->name }}</td>
                                        <td>{{ App\Enums\MailTemplateTypesEnum::asText($mailTemplate->type) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('mail_templates.edit', ['mail_template' => $mailTemplate]) }}" title="Editar Template" class="btn btn-light btn-sm">
                                                <i class="bx bx-edit"  style="margin-right: 0px !important"></i>
                                            </a>
                                            <form method="POST" action="{{ route('mail_templates.destroy', ['mail_template' => $mailTemplate]) }}" accept-charset="UTF-8" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm mr-0" title="Excluir Template" onclick="return confirm(&quot;Confirma a exclução do Template?&quot;)">
                                                    <i class="bx bx-trash" style="margin-right: 0px !important"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="pagination-wrapper"> {!! $shops->appends(['search' => Request::get('search')])->render() !!} </div> --}}
                </div>
        
            </div>
        </div>
    </div>
    <!-- /Basic Table -->
</div>
@endsection
