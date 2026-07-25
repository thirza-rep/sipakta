<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @csrf
        @method('patch')

        <div class="space-y-6">
            <div>
                <label for="name" class="block text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-2">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                       class="w-full px-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold text-slate-700">
                @error('name')<p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-wider">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-2">Alamat Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold text-slate-700">
                @error('email')<p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-wider">{{ $message }}</p>@enderror
            </div>
            
            <div class="flex items-center gap-6 pt-4">
                <button type="submit" class="px-10 py-4 bg-slate-900 text-white rounded-2xl font-black shadow-xl shadow-slate-200 hover:bg-slate-800 transition active:scale-95 group">
                    SIMPAN PERUBAHAN
                </button>
                @if (session('status') === 'profile-updated')
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                         class="flex items-center text-teal-600 font-black text-[10px] uppercase tracking-[0.2em]">
                        
                        Tersimpan!
                    </div>
                @endif
            </div>
        </div>
        
        <div class="bg-slate-50 rounded-[2rem] p-8 border border-slate-100 flex flex-col items-center justify-center text-center">
            <div class="w-32 h-32 rounded-full overflow-hidden shadow-xl shadow-slate-200 flex items-center justify-center text-4xl font-black text-slate-900 mb-4 border-4 border-white bg-white">
                @if($user->foto_profil)
                    <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                @else
                    <div id="avatar-initials">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <img id="avatar-preview" src="" class="hidden w-full h-full object-cover">
                @endif
            </div>
            
            <div class="w-full max-w-xs mt-2 mb-6" x-data="cameraCapture()">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 cursor-pointer hover:text-indigo-600 transition">
                    Ubah Foto Profil (Kamera Langsung)
                </label>
                
                <input type="hidden" name="foto_profil" x-model="fotoBase64">
                
                <template x-if="!isCameraOpen">
                    <button type="button" @click="openCamera()" class="w-full px-4 py-3 bg-indigo-50 text-indigo-700 text-sm font-bold rounded-xl hover:bg-indigo-100 transition shadow-sm border border-indigo-100 flex items-center justify-center gap-2">
                        
                        Buka Kamera
                    </button>
                </template>
                
                <template x-if="isCameraOpen">
                    <div class="relative w-full rounded-2xl overflow-hidden shadow-lg border border-slate-200 mt-2 bg-slate-900">
                        <video x-ref="video" autoplay playsinline class="w-full aspect-[3/4] object-cover transform -scale-x-100"></video>
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-4">
                            <button type="button" @click="capturePhoto()" class="w-14 h-14 bg-white/80 backdrop-blur-sm rounded-full border-4 border-indigo-500 shadow-xl active:scale-95 transition"></button>
                            <button type="button" @click="closeCamera()" class="absolute right-4 bottom-2 w-10 h-10 bg-red-500/80 backdrop-blur-sm text-white rounded-full font-bold active:scale-95 flex items-center justify-center shadow-lg">
                                
                            </button>
                        </div>
                        <canvas x-ref="canvas" class="hidden"></canvas>
                    </div>
                </template>

                @error('foto_profil')<p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-wider">{{ $message }}</p>@enderror
            </div>

            <h4 class="font-black text-slate-900 text-xl">{{ $user->name }}</h4>
            <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">{{ $user->role_display }}</p>
        </div>
    </form>
</section>

<script>
function cameraCapture() {
    return {
        isCameraOpen: false,
        fotoBase64: '',
        stream: null,
        
        async openCamera() {
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: 'user', width: { ideal: 720 }, height: { ideal: 960 } } 
                });
                this.isCameraOpen = true;
                this.$nextTick(() => {
                    this.$refs.video.srcObject = this.stream;
                });
            } catch (err) {
                alert('Tidak dapat mengakses kamera: ' + err.message + '. Pastikan Anda memberi izin kamera pada browser.');
            }
        },
        
        capturePhoto() {
            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            
            // Set canvas size for compression (400px width)
            canvas.width = 400;
            canvas.height = 400 * (video.videoHeight / video.videoWidth);
            
            const ctx = canvas.getContext('2d');
            // Mirror image horizontally to match mirrored video
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Compress with 0.8 quality
            this.fotoBase64 = canvas.toDataURL('image/jpeg', 0.8);
            
            // Update preview image directly
            const imgPreview = document.getElementById('avatar-preview');
            const initials = document.getElementById('avatar-initials');
            
            if (imgPreview) {
                imgPreview.src = this.fotoBase64;
                imgPreview.classList.remove('hidden');
                if(initials) initials.classList.add('hidden');
            }
            
            this.closeCamera();
        },
        
        closeCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
            this.isCameraOpen = false;
        }
    }
}
</script>
