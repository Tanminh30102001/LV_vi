<x-app-layout>
    <main>
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="mb-4 text-center">{{ __('Cập nhập mật khẩu') }}</h3>

                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <!-- Email Address -->
                                <div class="mb-3">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <x-input-label for="password" :value="__('Mật khẩu mới')" />
                                    <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu mới')" />
                                    <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <div class="d-grid">
                                    <x-primary-button class="btn btn-primary btn-block">
                                        {{ __('Cập nhập mật khẩu') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
