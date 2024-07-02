<x-guest-layout>
    <div class=" flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full bg-white rounded-lg p-6">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">{{ __('Xác Thực Địa Chỉ Email') }}</h2>
                <p class="mt-2 text-gray-600">{{ __('Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, vui lòng xác thực địa chỉ email của bạn bằng cách nhấp vào liên kết chúng tôi vừa gửi qua email. Nếu bạn không nhận được email, chúng tôi sẽ gửi lại một email khác.') }}</p>
            </div>
    
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-md">
                    {{ __('Một liên kết xác thực mới đã được gửi đến địa chỉ email bạn đã cung cấp khi đăng ký.') }}
                </div>
            @endif
    
            <div class="mt-6 flex justify-between items-center">
                <form method="POST" action="{{ route('verification.send') }}" class="flex-grow mr-2">
                    @csrf
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Gửi Lại Email Xác Thực') }}
                    </button>
                </form>
    
                {{-- <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Đăng Xuất') }}
                    </button>
                </form> --}}
            </div>
        </div>
    </div>
</x-guest-layout>
