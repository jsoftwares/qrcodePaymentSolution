@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">User: {!! $user->id!!}</h1>

    @if(Auth::user()->role_id < 3)
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('users.edit', $user->id) !!}">Edit</a>
        </h1>
    @endif
    </section>
    <div class="content">
    <div class="clearfix"></div>

@include('flash::message')

<div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('users.show_fields')
                    <a href="{!! route('users.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>

           
        </div>
    </div>
    @if($user->id == Auth::user()->id || Auth::user()->role_id < 3)
    <!-- NAV TABS -->
    <div class="content">
    <div class="box box-primary">
        <div class="box-body">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#qrcodes" >User QRCodes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#transactions">Transactions for QRCode</a>
                </li>
            </ul>
            <!-- TABS -->
            <div class="tab-content">
                <div class="tab-pane container active row" id="qrcodes">
                    @include('qrcodes.table')
                </div>
                <div class="tab-pane container fade row" id="transactions">
                    @include('transactions.table')
                </div>
            </div>
        </div>
    </div>
    </div>
@endif
@endsection
