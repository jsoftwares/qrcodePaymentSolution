@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            API Tokens
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div id="app" class="row col-sm-9">
                    <passport-clients></passport-clients>
                    <passport-authorized-clients></passport-authorized-clients>
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                    
                </div>
            </div>
        </div>
    </div>
@endsection