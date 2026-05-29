<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <h2 class="text-2xl font-black text-teal-800 text-center mb-2 tracking-tight">Verifikasi Email Anda</h2>
        <p class="text-slate-500 text-sm text-center mb-8">
            Kami telah mengirimkan kode OTP 6 digit ke alamat email:<br>
            <strong class="text-slate-700">{{ $email }}</strong>
        </p>

        @if(session('success'))
            <div class="bg-teal-50 border-l-4 border-teal-500 p-4 rounded-xl mb-6 shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                <p class="text-teal-900 text-xs font-bold">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->has('otp'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl mb-6 shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <p class="text-red-900 text-xs font-bold">{{ $errors->first('otp') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('verification.otp.verify') }}" id="otp-form" class="space-y-8">
            @csrf

            <!-- Hidden input to store compiled 6-digit OTP -->
            <input type="hidden" name="otp" id="otp-value" required>

            <!-- 6 Digit Inputs -->
            <div class="flex justify-between items-center gap-2" id="otp-inputs">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required
                           class="w-12 h-14 text-center text-2xl font-black text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-all shadow-inner uppercase"
                           data-index="{{ $i }}">
                @endfor
            </div>

            <button type="submit" class="w-full bg-teal-700 text-white py-4 rounded-2xl font-bold hover:bg-teal-600 transition shadow-lg active:scale-[0.98]">
                Verifikasi Akun
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-500">
            Tidak menerima kode? 
            <form method="POST" action="{{ route('verification.otp.resend') }}" class="inline ml-1" id="resend-form">
                @csrf
                <button type="submit" id="resend-btn" class="text-teal-600 font-bold hover:underline focus:outline-none disabled:text-slate-400 disabled:no-underline">
                    Kirim Ulang Code
                </button>
            </form>
            <span id="countdown" class="hidden font-bold text-slate-400 ml-1"></span>
        </div>

        <div class="mt-6 border-t border-slate-100 pt-6 text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-bold uppercase tracking-wider">
                    Keluar / Log Out
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('#otp-inputs input');
            const hiddenOtpInput = document.getElementById('otp-value');
            const form = document.getElementById('otp-form');

            // Set focus to the first input on load
            inputs[0].focus();

            // Handling paste event
            inputs[0].addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').trim().replace(/[^0-9]/g, '');
                
                if (pasteData.length > 0) {
                    inputs.forEach((input, idx) => {
                        input.value = pasteData[idx] || '';
                    });
                    
                    // Update hidden field value
                    updateHiddenOtp();
                    
                    // Focus on last filled input or submit if full
                    const nextFocusIndex = Math.min(pasteData.length, 5);
                    inputs[nextFocusIndex].focus();
                }
            });

            // Handle typing and navigation
            inputs.forEach((input, index) => {
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace') {
                        if (input.value === '') {
                            // Backspace on empty field: move to previous field
                            if (index > 0) {
                                inputs[index - 1].focus();
                                inputs[index - 1].value = '';
                            }
                        } else {
                            // Backspace on filled field: clear value
                            input.value = '';
                        }
                        updateHiddenOtp();
                    }
                });

                input.addEventListener('input', (e) => {
                    // Strip non-numbers
                    input.value = input.value.replace(/[^0-9]/g, '');

                    if (input.value !== '') {
                        // Move to next field
                        if (index < 5) {
                            inputs[index + 1].focus();
                        }
                    }
                    updateHiddenOtp();
                });
            });

            function updateHiddenOtp() {
                let otpValue = '';
                inputs.forEach(input => otpValue += input.value);
                hiddenOtpInput.value = otpValue;
            }

            // Form Submit checking
            form.addEventListener('submit', (e) => {
                updateHiddenOtp();
                if (hiddenOtpInput.value.length !== 6) {
                    e.preventDefault();
                    alert('Harap masukkan 6 digit kode OTP secara lengkap.');
                }
            });

            // Countdown timer for Resend OTP button
            const resendBtn = document.getElementById('resend-btn');
            const countdownEl = document.getElementById('countdown');
            let cooldownTime = 60; // seconds
            let timer;

            function startTimer() {
                resendBtn.disabled = true;
                countdownEl.classList.remove('hidden');
                
                timer = setInterval(() => {
                    cooldownTime--;
                    countdownEl.textContent = `(Tunggu ${cooldownTime} detik)`;
                    
                    if (cooldownTime <= 0) {
                        clearInterval(timer);
                        resendBtn.disabled = false;
                        countdownEl.classList.add('hidden');
                        cooldownTime = 60; // reset
                    }
                }, 1000);
            }

            // Start countdown immediately on load to prevent immediate spamming
            startTimer();

            // When user submits the resend form, store a flag in localStorage to restart timer on page reload
            document.getElementById('resend-form').addEventListener('submit', () => {
                localStorage.setItem('otp_timer_start', Date.now());
            });

            // Check if timer was already running previously
            const timerStart = localStorage.getItem('otp_timer_start');
            if (timerStart) {
                const elapsed = Math.floor((Date.now() - timerStart) / 1000);
                if (elapsed < 60) {
                    cooldownTime = 60 - elapsed;
                    clearInterval(timer);
                    startTimer();
                } else {
                    localStorage.removeItem('otp_timer_start');
                }
            }
        });
    </script>
</x-guest-layout>
