<x-app-layout>   
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h3 class="mb-4 text-center">{{ __('Bạn quên mật khẩu ư?') }}</h3>
                        <p class="text-muted mb-4 text-center">
                            {{ __('Không sao cả. Bạn có thể đặt lại mật khẩu ở đây') }}
                        </p>
                        
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            
                            <!-- Email Address -->
                            <div class="mb-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            
                            <div class="d-grid">
                                <x-primary-button class="btn btn-primary btn-block">
                                    {{ __('Gửi') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
