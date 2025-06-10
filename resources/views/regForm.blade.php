@extends('layout.master')

@section('title', __('messages.registration_title'))

@section('style')
    @vite(['resources/css/regForm.css'])
@endsection

@section('main-content')
    @php
        $locale = session('locale');

        if ($locale) {
            app()->setLocale($locale);
            config(['app.locale' => $locale]);
        }
        logger('Blade render - app()->getLocale(): ' . app()->getLocale());
    @endphp
    

    <main>
        {{-- Add this section to display all errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" id="registration-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="left-part">
                <h2>@lang('messages.registration')</h2>
                <div class="user-profile">
                    <img id="user-image" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="User Image" name="userImage">
                    <input type="file" name="user_image" id="user_image_input" accept="image/*" style="display: none;">
                    <button type="button" id="choose-photo">@lang('messages.choose_profile')</button>
                </div>
            </div>

            <div class="right-part">
                <div class="name container">
                    <div class="box">
                        <label for="fname">@lang('messages.full_name')</label>
                        <input type="text" class="form-input" id="fname" name="full_name" placeholder="@lang('messages.full_name_placeholder')">
                    </div>

                    <div class="box">
                        <label for="uName">@lang('messages.username')</label>
                        <input type="text" class="form-input" id="uName" name="user_name" placeholder="@lang('messages.username_placeholder')">
                    </div>
                </div>

                <div class="telephone container">
                    <div class="box">
                        <label for="phone">@lang('messages.phone_number')</label>
                        <input type="tel" class="form-input" id="phone" name="phone_number" placeholder="@lang('messages.phone_number_placeholder')">
                    </div>

                    <div class="box">
                        <label for="whatsAppNumber">
                            @lang('messages.whatsapp_number')
                            <i 
                                class="fa-solid fa-circle-question" 
                                title="@lang('messages.whatsapp_helper')">
                            </i>
                        </label>
                        <input type="tel" class="form-input" id="whatsAppNumber" name="whatsapp_number" placeholder="@lang('messages.whatsapp_number_placeholder')">
                    </div>
                </div>

                <div class="pass-conPass container">
                    <div class="box">
                        <label for="password">@lang('messages.password')</label>
                        <input type="password" class="form-input" id="password" name="password" placeholder="@lang('messages.password_placeholder')">
                    </div>

                    <div class="box">
                        <label for="cPassword">@lang('messages.confirm_password')</label>
                        <input type="password" class="form-input" id="cPassword" placeholder="@lang('messages.confirm_password_placeholder')" disabled>
                    </div>
                </div>

                <div class="email-address container">
                    <div class="box">
                        <label for="address">@lang('messages.address')</label>
                        <input type="text" class="form-input" id="address" name="user_address" placeholder="@lang('messages.address_placeholder')">
                    </div>

                    <div class="box">
                        <label for="email">@lang('messages.email')</label>
                        <input type="email" class="form-input" id="email" name="user_email" placeholder="@lang('messages.email_placeholder')">
                    </div>
                </div>
            </div>

            <!-- <input class="submit-form" type="submit" value="Register"> -->
            <button type="Submit" class="submit-form">@lang('messages.submit')</button>
        </form>
    </main>
@endsection

@section('script')
    @vite(['resources/js/regForm.js', 'resources/js/imageUpload.js'])
@endsection