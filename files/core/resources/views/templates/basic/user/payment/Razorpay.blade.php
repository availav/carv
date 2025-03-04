@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <section class="ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10">
                    <div class="card custom--card">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Razorpay')</h5>
                        </div>
                        <div class="card-body">
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
                            <form id="payment-form" action="{{ $data->url }}" method="{{ $data->method }}">
                                <input type="hidden" custom="{{ $data->custom }}" name="hidden">
                                <script src="{{ $data->checkout_js }}" @foreach ($data->val as $key => $value)
                                data-{{ $key }}="{{ $value }}" @endforeach></script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('input[type="submit"]').addClass("mt-4 btn btn--base w-100");
        })(jQuery);
    </script>
@endpush
