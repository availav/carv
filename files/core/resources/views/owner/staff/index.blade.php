@extends('owner.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Role')</th>
                                    <th>@lang('Status')</th>
                                    @can(['owner.staff.*'])
                                        <th>@lang('Action')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allStaff as $staff)
                                    <tr>
                                        <td>{{ $staff->fullname }}</td>
                                        <td>{{ $staff->email }}</td>
                                        <td>
                                            @if ($staff->role)
                                                {{ $staff->role->name }}
                                            @else
                                                @lang('Super Vendor')
                                            @endif
                                        </td>

                                        <td>
                                            @php
                                                echo $staff->statusBadge;
                                            @endphp
                                        </td>
                                        @can(['owner.staff.*'])
                                            <td>
                                                <div class="button--group">
                                                    @if ($staff->id > 1)
                                                        @can('owner.staff.save')
                                                            <button class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Update Staff')" data-resource="{{ $staff }}" type="button">
                                                                <i class="la la-pencil"></i>@lang('Edit')
                                                            </button>
                                                        @endcan
                                                        @can('owner.staff.status')
                                                            @if ($staff->status)
                                                                <button class="btn btn-sm confirmationBtn btn-outline--danger" data-action="{{ route('owner.staff.status', $staff->id) }}" data-question="@lang('Are you sure to ban this staff?')" type="button">
                                                                    <i class="las la-user-alt-slash"></i>@lang('Ban')
                                                                </button>
                                                            @else
                                                                <button class="btn btn-sm confirmationBtn btn-outline--success" data-action="{{ route('owner.staff.status', $staff->id) }}" data-question="@lang('Are you sure to unban this staff?')" type="button">
                                                                    <i class="las la-user-check"></i>@lang('Unban')
                                                                </button>
                                                            @endif
                                                        @endcan
                                                        @can('owner.staff.login')
                                                            <a class="btn btn-sm btn-outline--dark" href="{{ route('owner.staff.login', $staff->id) }}" target="_blank">
                                                                <i class="las la-sign-in-alt"></i>@lang('Login')
                                                            </a>
                                                        @endcan
                                                    @endif
                                                </div>
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($allStaff->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($allStaff) }}

                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-confirmation-modal />

    @can('owner.staff.save')
        <!-- Create Update Modal -->
        <div class="modal fade" id="cuModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                            <i class="las la-times"></i>
                        </button>
                    </div>

                    <form action="{{ route('owner.staff.save') }}" method="POST">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label>@lang('First Name')</label>
                                <input class="form-control" name="firstname" required type="text">
                            </div>

                            <div class="form-group">
                                <label>@lang('Last Name')</label>
                                <input class="form-control" name="lastname" required type="text">
                            </div>

                            <div class="form-group">
                                <label>@lang('Email')</label>
                                <input class="form-control" name="email" required type="email">
                            </div>

                            <div class="form-group">
                                <label>@lang('Role')</label>
                                <select class="form-control" name="role_id" required>
                                    <option disabled selected value="">@lang('Select One')</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>@lang('Password')</label>
                                <div class="input-group">
                                    <input class="form-control" name="password" required type="text">
                                    <button class="input-group-text generatePassword" type="button">@lang('Generate')</button>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username" />
    <!-- Modal Trigger Button -->
    @can('owner.staff.save')
        <button class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Staff')" type="button">
            <i class="las la-plus"></i>@lang('Add New')
        </button>
    @endcan
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.generatePassword').on('click', function() {
                $(this).siblings('[name=password]').val(generatePassword());
            });

            $('.cuModalBtn').on('click', function() {
                let passwordField = $('#cuModal').find($('[name=password]'));
                let label = passwordField.parents('.form-group').find('label')
                if ($(this).data('resource')) {
                    passwordField.removeAttr('required');
                    label.removeClass('required')
                } else {
                    passwordField.attr('required', 'required');
                    label.addClass('required')
                }
            });

            function generatePassword(length = 12) {
                let charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+<>?/";
                let password = '';

                for (var i = 0, n = charset.length; i < length; ++i) {
                    password += charset.charAt(Math.floor(Math.random() * n));
                }

                return password
            }
        })(jQuery);
    </script>
@endpush
