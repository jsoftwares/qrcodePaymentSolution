@extends('layouts.app')

@section('content')
    <section class="content-header clearfix">
    <h1 class="pull-left">Qrcodes</h1>
    @if(!Auth::guest() && (Auth::user()->role_id < 3 || Auth::user()->id == $qrcode->user_id ))
        
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('qrcodes.edit', [$qrcode->id]) !!}">Edit</a>
        </h1>
    @endif
        <section>@include('flash::message')</section>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('qrcodes.show_fields')
                    <!-- <a href="{!! route('qrcodes.index') !!}" class="btn btn-default">Back</a> -->
                </div>
                
            </div>
        </div>
    </div>
@endsection
