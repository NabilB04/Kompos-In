<meta name="csrf-token" content="{{ csrf_token() }}">

<header class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="text-2xl font-bold text-emerald-600">KOMPOS-IN</div>
        <nav class="flex items-center space-x-4">
            <a href="#katalog" class="text-gray-700 hover:text-emerald-600 transition-colors">Katalog</a>
            <a href="#Artikel" class="text-gray-700 hover:text-emerald-600 transition-colors">Artikel</a>
            <a href="https://wa.me/+6285163021022" class="text-gray-700 hover:text-emerald-600 transition-colors">Kontak</a>
            @if (session('role') === 'pelanggan')
                @if (auth('pelanggan')->check() && auth('pelanggan')->user()->status->status_id == 1)
                    <a href="{{ route('pelanggan.riwayat') }}" class="text-gray-700 hover:text-emerald-600 transition-colors">Pengambilan Sampah</a>
                @else
                    <a href="#" class="text-gray-700 cursor-not-allowed" title="Anda belum berlangganan">Pengambilan Sampah</a>
                @endif
                <div class="relative">
                    <button onclick="toggleDropdown()" class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xl focus:outline-none hover:bg-emerald-700 transition-colors">
                        <i class="fas fa-user"></i>
                    </button>
                    <div id="dropdownMenu" class="absolute right-0 mt-2 w-56 bg-white border border-emerald-100 rounded-lg shadow-lg hidden z-50">
                        <div class="py-1 border-b border-emerald-100">
                            <div class="px-4 py-2 text-xs text-emerald-600 uppercase">Pengaturan</div>
                            <button onclick="openAccountModal()" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Profil</button>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="py-1" id="logoutForm">
                            @csrf
                            <button type="button" onclick="confirmLogout()" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="bg-amber-400 hover:bg-amber-500 text-white px-4 py-2 rounded-lg transition-colors">Login</a>
            @endif
        </nav>
    </div>
</header>

<!-- Account Settings Modal -->
<div id="accountSettingsModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex justify-center items-center transition-opacity duration-300">
    <div class="bg-gradient-to-b from-emerald-50 to-white w-full max-w-md min-h-[400px] rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 overflow-y-auto">
        <div class="px-6 py-4 border-b bg-emerald-100 rounded-t-2xl text-center">
            <h2 class="text-xl font-semibold text-emerald-800" id="modalTitle">Ubah Data Profil</h2>
        </div>
        <div class="px-6 py-6 space-y-6" id="modalContent">
            @if (session('pending_profile_update') &&
                (isset(session('pending_profile_update')['email']) && !session('pending_profile_update')['email_verified'] ?? false) ||
                (isset(session('pending_profile_update')['nomor_telepon']) && !session('pending_profile_update')['phone_verified'] ?? false))
                <div class="text-center">
                    <p class="text-gray-600 mb-2">
                        @php
                            $fields = [];
                            if (isset(session('pending_profile_update')['email']) && !session('pending_profile_update')['email_verified'] ?? false) {
                                $fields[] = 'email';
                            }
                            if (isset(session('pending_profile_update')['nomor_telepon']) && !session('pending_profile_update')['phone_verified'] ?? false) {
                                $fields[] = 'nomor telepon';
                            }
                            echo count($fields) > 0 ? ucfirst(implode(' dan ', $fields)) . ' Anda belum diverifikasi.' : 'Profil Anda belum diverifikasi.';
                        @endphp
                    </p>
                    <form id="resendVerificationForm" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="text-emerald-600 hover:text-emerald-800">Kirim Ulang Link Verifikasi</button>
                    </form>
                </div>
            @endif
            <form id="updateProfileForm" method="POST" action="{{ route('pengaturan.data.simpan') }}">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-emerald-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ auth('pelanggan')->check() ? auth('pelanggan')->user()->nama_lengkap : '' }}" class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all bg-white text-base" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-emerald-700">Email</label>
                        <input type="email" name="email" value="{{ auth('pelanggan')->check() ? auth('pelanggan')->user()->email : '' }}" class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all bg-white text-base">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-emerald-700">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" value="{{ auth('pelanggan')->check() ? auth('pelanggan')->user()->nomor_telepon : '' }}" class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all bg-white text-base">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-emerald-700">Alamat</label>
                        <textarea name="alamat" class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all bg-white text-base" rows="4">{{ auth('pelanggan')->check() ? auth('pelanggan')->user()->alamat : '' }}</textarea>
                    </div>
                    @php
                        $status = auth('pelanggan')->user()->status->nama_status ?? 'Tidak Diketahui';
                        $warnaStatus = match(strtolower($status)) {
                            'aktif' => 'bg-green-100 text-green-700 border-green-300',
                            'tidak aktif' => 'bg-red-100 text-red-700 border-red-300',
                            default => 'bg-gray-100 text-gray-700 border-gray-300'
                        };
                    @endphp

                    <span class="text-sm font-medium px-3 py-1 rounded-full border {{ $warnaStatus }}">
                        Status Berlangganan: {{ ucfirst($status) }}
                    </span>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg hover:from-emerald-600 hover:to-emerald-700 transition-colors text-base">Simpan</button>
                </div>
            </form>
        </div>
        <div class="px-6 py-4 border-t bg-emerald-100 rounded-b-2xl">
            <button onclick="closeAccountModal()" class="w-full py-2 text-emerald-600 hover:text-red-500 font-medium transition-colors text-base">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Logout -->
<div id="logoutConfirmModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex justify-center items-center transition-opacity duration-300">
    <div class="bg-white w-full max-w-md h-auto p-6 rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 border border-emerald-100">
        <h2 class="text-lg font-semibold text-emerald-800 mb-4">Konfirmasi Logout</h2>
        <p class="text-gray-600 mb-4">Apakah Anda yakin ingin logout?</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeLogoutModal()" class="px-4 py-2 text-sm text-emerald-600 hover:text-red-500 font-medium transition-colors">Batal</button>
            <button onclick="submitLogout()" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm rounded-lg hover:from-emerald-600 hover:to-emerald-700 transition-all">Ya, Logout</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Email Terkirim -->
<div id="emailSentModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex justify-center items-center transition-opacity duration-300">
    <div class="bg-white w-full max-w-md h-auto p-6 rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 border border-emerald-100">
        <h2 class="text-lg font-semibold text-emerald-800 mb-4">Konfirmasi</h2>
        <p class="text-gray-600 mb-4" id="emailSentMessage">Link verifikasi telah dikirim ke email Anda. Silakan periksa kotak masuk atau spam untuk mengkonfirmasi perubahan.</p>
        <div class="flex justify-end">
            <button onclick="closeEmailSentModal()" class="px-4 py-2 text-sm text-emerald-600 hover:text-red-500 font-medium transition-colors">Tutup</button>
        </div>
    </div>
</div>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.classList.toggle('hidden');
    }

    function openAccountModal() {
        const modal = document.getElementById('accountSettingsModal');
        if (!modal) {
            console.error('Modal pengaturan akun tidak ditemukan!');
            return;
        }
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.transform').classList.remove('scale-95');
        }, 10);
    }

    function closeAccountModal() {
        const modal = document.getElementById('accountSettingsModal');
        if (!modal) return;
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openEmailSentModal() {
        const modal = document.getElementById('emailSentModal');
        if (!modal) {
            console.error('Modal konfirmasi email tidak ditemukan!');
            return;
        }
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.transform').classList.remove('scale-95');
        }, 10);
    }

    function closeEmailSentModal() {
        const modal = document.getElementById('emailSentModal');
        if (!modal) return;
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            closeAccountModal();
        }, 300);
    }

    function confirmLogout() {
        const modal = document.getElementById('logoutConfirmModal');
        if (!modal) return;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.transform').classList.remove('scale-95');
        }, 10);
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logoutConfirmModal');
        if (!modal) return;
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function submitLogout() {
        document.getElementById('logoutForm').submit();
    }

    document.getElementById('updateProfileForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[name="email"]').value.trim();
        const nomorTelepon = this.querySelector('input[name="nomor_telepon"]').value.trim();
        const currentEmail = "{{ auth('pelanggan')->check() ? auth('pelanggan')->user()->email : '' }}".trim();
        const currentPhone = "{{ auth('pelanggan')->check() ? auth('pelanggan')->user()->nomor_telepon : '' }}".trim();

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            alert('CSRF token tidak ditemukan. Silakan muat ulang halaman.');
            return;
        }

        fetch('{{ route('pengaturan.data.simpan') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                email: email,
                nomor_telepon: nomorTelepon,
                nama_lengkap: this.querySelector('input[name="nama_lengkap"]').value.trim(),
                alamat: this.querySelector('textarea[name="alamat"]').value.trim(),
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal mengirim permintaan verifikasi');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                if (email !== currentEmail || nomorTelepon !== currentPhone) {
                    document.getElementById('emailSentMessage').innerText = data.message;
                    openEmailSentModal();
                } else {
                    alert(data.message);
                    window.location.reload();
                }
            } else {
                alert('Gagal mengirim link verifikasi: ' + (data.message || 'Silakan coba lagi.'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim link verifikasi. Silakan coba lagi.');
        });
    });

    document.getElementById('resendVerificationForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            alert('CSRF token tidak ditemukan. Silakan muat ulang halaman.');
            return;
        }

        fetch('{{ route('verification.resend') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal mengirim permintaan resend');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('emailSentMessage').innerText = data.message;
                openEmailSentModal();
            } else {
                alert(data.message || 'Gagal mengirim ulang link verifikasi. Silakan coba lagi.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim ulang link verifikasi. Silakan coba lagi.');
        });
    });
</script>
