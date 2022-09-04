@extends('layouts.app')

@section('title', 'Entre em Contato')

@section('breadcrumbs')
    <li class="active"><span>Entre em Contato</span></li>
@endsection

@section('wrapper')
    <livewire:contact-form />
@endsection