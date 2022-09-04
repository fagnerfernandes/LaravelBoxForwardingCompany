@extends('layouts.app')

@section('title')
    FAQs
@endsection

@section('breadcrumbs')
    <li class="active"><span>FAQs</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6 class=""> FAQs</h6>
                </div>
                <div class="card-body">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @foreach ($rows as $key => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading{{ $key }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $key }}" aria-expanded="false" aria-controls="flush-collapse{{ $key }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="flush-collapse{{ $key }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $key }}" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">{!! $faq->answer !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>
@endsection
