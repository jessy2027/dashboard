@extends('layouts.main')

@section('content')
    <!-- CONTENT HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>{{__('Coupon')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.coupons.index')}}">{{__('Coupon')}}</a>
                        </li>
                        <li class="breadcrumb-item"><a class="text-muted"
                                                       href="{{route('admin.coupons.edit' , $coupon->id)}}">{{__('Edit')}}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- END CONTENT HEADER -->

    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="mr-2 fas fa-money-check-alt"></i>{{__('Coupon details')}}
                            </h5>
                        </div>
                        <div class="card-body">
                          <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="flex-row-reverse d-flex">
                              <div class="custom-control custom-switch">
                                <input
                                  type="checkbox"
                                  id="random_codes"
                                  name="random_codes"
                                  class="custom-control-input"
                                >
                                <label for="random_codes" class="custom-control-label">
                                  {{ __('Random Codes') }}
                                  <i
                                    data-toggle="popover"
                                    data-trigger="hover"
                                    data-content="{{__('Replace the creation of a single code with several at once with a custom field.')}}"
                                    class="fas fa-info-circle">
                                  </i>
                                </label>
                              </div>
                            </div>
                            <div id="range_codes_element" style="display: none;" class="form-group">
                              <label for="range_codes">
                                {{ __('Range Codes') }}
                                <i
                                  data-toggle="popover"
                                  data-trigger="hover"
                                  data-content="{{__('Generate a number of random codes.')}}"
                                  class="fas fa-info-circle">
                                </i>
                              </label>
                              <input
                                type="number"
                                id="range_codes"
                                name="range_codes"
                                step="any"
                                min="1"
                                max="100"
                                class="form-control @error('range_codes') is-invalid @enderror"
                              >
                              @error('range_codes')
                                <div class="text-danger">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div id="coupon_code_element" class="form-group">
                              <label for="code">
                                {{ __('Coupon Code') }}
                                <i
                                  data-toggle="popover"
                                  data-trigger="hover"
                                  data-content="{{__('The coupon code to be registered.')}}"
                                  class="fas fa-info-circle">
                                </i>
                              </label>
                              <input
                                type="text"
                                id="code"
                                name="code"
                                placeholder="SUMMER"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ $coupon->code }}"
                              >
                              @error('code')
                                <div class="text-danger">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div class="form-group">
                              <div class="p-0 mb-3 custom-control">
                                <label for="type">
                                  {{ __('Coupon Type') }}
                                  <i
                                    data-toggle="popover"
                                    data-trigger="hover"
                                    data-content="{{__('The way the coupon should discount.')}}"
                                    class="fas fa-info-circle">
                                  </i>
                                </label>
                                <select
                                  name="type"
                                  id="type"
                                  class="custom-select @error('type') is_invalid @enderror"
                                  style="width: 100%; cursor: pointer;"
                                  autocomplete="off"
                                  required
                                >
                                  <option value="percentage" @if($coupon->type == 'percentage') selected @endif>{{ __('Percentage') }}</option>
                                  <option value="amount" @if($coupon->type == 'amount') selected @endif>{{ __('Amount') }}</option>
                                </select>
                                @error('type')
                                  <div class="text-danger">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="input-group d-flex flex-column">
                                <label for="value">
                                  {{ __('Coupon Value') }}
                                  <i
                                    data-toggle="popover"
                                    data-trigger="hover"
                                    data-content="{{__('The value that the coupon will represent.')}}"
                                    class="fas fa-info-circle">
                                  </i>
                                </label>
                                <div class="d-flex">
                                  <input
                                    name="value"
                                    id="value"
                                    type="number"
                                    step="any"
                                    min="1"
                                    max="100"
                                    class="form-control @error('value') is-invalid @enderror"
                                    value="{{ $coupon->type == 'amount' ? Currency::formatForForm($coupon->value) : $coupon->value }}"
                                  >
                                  <span id="input_percentage" class="input-group-text">%</span>
                                </div>
                                @error('value')
                                  <div class="text-danger">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="max_uses">
                                {{ __('Max uses') }}
                                <i
                                  data-toggle="popover"
                                  data-trigger="hover"
                                  data-content="{{__('The maximum number of times the coupon can be used.')}}"
                                  class="fas fa-info-circle">
                                </i>
                              </label>
                              <input
                                name="max_uses"
                                id="max_uses"
                                type="number"
                                step="any"
                                min="1"
                                max="100"
                                class="form-control @error('max_uses') is-invalid @enderror"
                                value="{{ $coupon->max_uses }}"
                              >
                              @error('max_uses')
                                <div class="text-danger">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div class="d-flex flex-column input-group form-group date" id="expires_at" data-target-input="nearest">
                              <label for="expires_at">
                                {{ __('Expires at') }}
                                <i
                                  data-toggle="popover"
                                  data-trigger="hover"
                                  data-content="{{__('The date when the coupon will expire (If no date is provided, the coupon never expires).')}}"
                                  class="fas fa-info-circle">
                                </i>
                              </label>
                              <div class="d-flex">
                                <input
                                  value="{{ $expired_at ?? '' }}"
                                  name="expires_at"
                                  placeholder="yyyy-mm-dd hh:mm:ss"
                                  type="text"
                                  class="form-control @error('expires_at') is-invalid @enderror datetimepicker-input"
                                  data-target="#expires_at"
                                />
                                <div
                                  class="input-group-append"
                                  data-target="#expires_at"
                                  data-toggle="datetimepicker"
                                >
                                  <div class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                </div>
                              </div>
                              @error('expires_at')
                                <div class="text-danger">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div class="mb-0 text-right form-group">
                              <button type="submit" class="btn btn-primary">
                                {{__('Submit')}}
                              </button>
                            </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- END CONTENT -->

    <script>
      $(document).ready(function() {
        $('#expires_at').datetimepicker({
          format: 'Y-MM-DD HH:mm:ss',
          icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'fas fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'far fa-times-circle'
          }
        });
        $('#random_codes').change(function() {
          if ($(this).is(':checked')) {
            $('#coupon_code_element').prop('disabled', true).hide()
            $('#range_codes_element').prop('disabled', false).show()

            if ($('#code').val()) {
              $('#code').prop('value', null)
            }

          } else {
            $('#coupon_code_element').prop('disabled', false).show()
            $('#range_codes_element').prop('disabled', true).hide()

            if ($('#range_codes').val()) {
              $('#range_codes').prop('value', null)
            }
          }
        })

        $('#type').change(function() {
          if ($(this).val() == 'percentage') {
            $('#input_percentage').prop('disabled', false).show()
          } else {
            $('#input_percentage').prop('disabled', true).hide()
          }
        })
      })
    </script>
@endsection
