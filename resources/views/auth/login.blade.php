<x-guest-layout>
    <x-authentication-card>
         <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
        <x-slot name="logo">
            <img src="{{ asset('source/img/clinic-logo1.png') }}" class="img img-circle"
                style="width: 100px; height: 100px">
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <span class="input-group-text">
                    <i id="showPassword" class="far fa-eye-slash"></i>
                </span>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <x-button class="btn btn-primary ml-4 w-100">
                    {{ __('Log in') }}
                </x-button>
            </div>

        </form>
    </x-authentication-card>
</x-guest-layout>
<script>
    $(document).ready(function() {
        $('#showPassword').click(function() {
            var password = $('#password');
            var type = password.attr('type');
            if (type === "password") {
                password.attr("type", "text");
                $("#showPassword i").removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                password.attr("type", "password");
                $("#showPassword i").removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });
    })
</script>
