@extends('owner.layouts.app')
@section('panel')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">@lang('Paystack')</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ipn.' . $deposit->gateway->alias) }}" class="text-center" method="POST">
                        @csrf
                        <ul class="list-group text-center">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You have to pay '):
                                <strong>{{ showAmount($deposit->final_amo) }} {{ __($deposit->method_currency) }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You will get '):
                                <strong>{{ showAmount($deposit->amount) }} {{ __($general->cur_text) }}</strong>
                            </li>
                        </ul>
                        <button class="btn btn--primary h-45 w-100 mt-3" id="btn-confirm" type="button">@lang('Pay Now')</button>
                        <script src="//js.paystack.co/v1/inline.js" data-key="{{ $data->key }}" data-email="{{ $data->email }}" data-amount="{{ round($data->amount) }}" data-currency="{{ $data->currency }}" data-ref="{{ $data->ref }}" data-custom-button="btn-confirm"></script>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
