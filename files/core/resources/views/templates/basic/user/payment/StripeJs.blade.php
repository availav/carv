@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card custom--card">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Stripe Storefront')</h5>
                        </div>
                        <div class="card-body p-5">
                            <form id="payment-form" action="{{ $data->url }}" method="{{ $data->method }}">
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
                                <script src="{{ $data->src }}" class="stripe-button" @foreach ($data->val as $key => $value)
                            data-{{ $key }}="{{ $value }}" @endforeach></script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
    <style>
        .stripe-button-el {
            background-image: unset !important;
            padding: 14px 35px !important;
        }

        .stripe-button-el:not(:disabled):active,
        .stripe-button-el.active,
        .stripe-button-el:focus {
            background: #37ebec !important;
            box-shadow: none !important;
        }
    </style>
@endpush
@push('script-lib')
    <script src="https://js.stripe.com/v3/"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            $('button[type="submit"]').removeClass().addClass("btn btn--base w-100 mt-3").text("Pay Now");
        })(jQuery);
    </script>
@endpush
