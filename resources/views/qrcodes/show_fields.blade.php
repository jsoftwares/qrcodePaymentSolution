<div class="row">
    <div class="col-sm-7">
        <!-- Product Name Field -->
        <div class="form-group">
            <h3>{!! $qrcode->product_name !!}</h3>
            @if(isset($qrcode->company_name))
            <small>By: {!! $qrcode->company_name !!}</small>
            @endif
        </div>

        <!-- Amount Field -->
        <div class="form-group">
            <h4>Amount: NGN {!! number_format($qrcode->amount) !!}</h4>
        </div>

        <!-- Product Url Field -->
        <div class="form-group">
            {!! Form::label('product_url', 'Product Url:') !!}<br>
            <a href="{!! $qrcode->product_url !!}" target="_blank">{!! $qrcode->product_url !!}</a>
        </div>

        <!-- Id Field -->
        {{--<div class="form-group">
            {!! Form::label('id', 'Id:') !!}
            <p>{!! $qrcode->id !!}</p>
        </div> --}}

        <!-- Only logged in users who are admin or owner of the QRCode will see this -->
        @if(!Auth::guest() && ($qrcode->user_id == Auth::user()->id || Auth::user()->role_id < 3))
        <hr/>
        <!-- User Id Field -->
        <div class="form-group">
            {!! Form::label('user_id', 'User:') !!}
            <p>{!! $qrcode->user->email !!}</p>
        </div>

        <!-- Company Name Field -->
        <!-- <div class="form-group">
            {!! Form::label('company_name', 'Company Name:') !!}
            <p>{!! $qrcode->company_name !!}</p>
        </div> -->

        <!-- Website Field -->
        <div class="form-group">
            {!! Form::label('website', 'Website:') !!}
            <p><a href="{!! $qrcode->website !!}" target="_blank">{!! $qrcode->website !!}"</a></p>
        </div>

        <!-- Callback Url Field -->
        <div class="form-group">
            {!! Form::label('callback_url', 'Callback Url:') !!}
            <p><a href="{!! $qrcode->callback_url !!}" target="_blank">{!! $qrcode->callback_url !!}</a></p>
        </div>

        <!-- Status Field -->
        <div class="form-group">
            {!! Form::label('status', 'Status:') !!}
            <p>{!! $qrcode->status==1 ? 'Active' : 'Inactive' !!}</p>
        </div>

        <!-- Deleted At Field -->
        <div class="form-group">
            {!! Form::label('deleted_at', 'Deleted At:') !!}
            <p>{!! $qrcode->deleted_at !!}</p>
        </div>

        <!-- Created At Field -->
        <div class="form-group">
            {!! Form::label('created_at', 'Created At:') !!}
            <p>{!! $qrcode->created_at !!}</p>
        </div>

        <!-- Updated At Field -->
        <div class="form-group">
            {!! Form::label('updated_at', 'Updated At:') !!}
            <p>{!! $qrcode->updated_at !!}</p>
        </div>
        @endif
    </div>

    <div class="col-sm-5">
        <!-- Qrcode Path Field -->
        <div class="form-group">
            <span class="text-bold">Scan QRCode and Pay with our App:</span>
            <!-- {!! Form::label('qrcode_path', 'Scan QRCode and Pay with our App:') !!} -->
            <br><img src="{!! url($qrcode->qrcode_path) !!}" alt="QRCode">
        </div>  

        <form method="post" action="{{route('qrcodes.show_payment_page')}}">
            <div class="form-group col-sm-8">
                @csrf()
                <!-- Only logged out users get to see an email field entry field -->
                @if(Auth::guest())
                    <label for="email" class="form-control-label">Enter email</label>
                    <input type="email" name="email" id="email" class="form-control" required placeholder="example@domain.com">
                @else
                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                @endif
                <input type="hidden" name="qrcode_id" value="{{$qrcode->id}}">
                <br>
                <button class="btn btn-success btn-block" type="submit">
                    <i class="fa fa-plus-circle fa-lg"></i> Proceed to Pay
                </button>
            </div>
        </form>
        
    </div>

</div>
<!-- If user is logged in, an admin or the owner of this QRCode, then show its transactions  -->
@if(!Auth::guest() && ($qrcode->user_id == Auth::user()->id || Auth::user()->role_id < 3))
    <hr>
    <h4 class="text-default text-center">Transactions for QRCode</h4>
    @include('transactions.table')
@endif

