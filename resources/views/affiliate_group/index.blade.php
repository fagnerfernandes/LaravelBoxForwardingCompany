@extends('layouts.app')

@section('title')
    Grupo de Afiliados
@endsection

@section('breadcrumbs')
    <li class="active"><span>Grupo de Afiliados</span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="panel-title txt-dark"><i class="zmdi zmdi-account"></i> Grupo de Afiliados</h6>
                
                    <a href="{{ route('affiliate_groups.create') }}" class="btn btn-success btn-sm">
                        <i class="bx bx-plus"></i> Adicionar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="panel-body">
                    {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                    <div class="table-wrap mt-10">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Grupo de Afiliados Padrão</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($affiliateGroups as $affiliateGroup)
                                        <tr class="align-middle">
                                            <td>{{ $affiliateGroup->id }}</td>
                                            <td>{{ $affiliateGroup->name }}</td>
                                            <th>{{ $affiliateGroup->is_default ? 'Sim' : 'Não' }}</th>
                                            <td class="text-end">
                                                <a href="{{ route('affiliate_groups.edit', ['affiliate_group' => $affiliateGroup]) }}" title="Editar Template" class="btn btn-light btn-sm">
                                                    <i class="bx bx-edit"  style="margin-right: 0px !important"></i>
                                                </a>
                                                {{-- <form method="POST" action="{{ route('mail_templates.destroy', ['mail_template' => $mailTemplate]) }}" accept-charset="UTF-8" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light btn-sm mr-0" title="Excluir Template" onclick="return confirm(&quot;Confirma a exclução do Template?&quot;)">
                                                        <i class="bx bx-trash" style="margin-right: 0px !important"></i>
                                                    </button>
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="pagination-wrapper"> {!! $customers->appends(['search' => Request::get('search')])->render() !!} </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Basic Table -->
</div>
@endsection
