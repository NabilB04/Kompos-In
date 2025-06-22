<aside class="w-64 bg-white border-r relative">
    <div class="p-6">
        <img src="{{ asset('img/logo_komposin.png') }}" alt="Kompos-IN Logo" class="mx-auto mb-6"
            style="max-height: 30px;" />
        <nav>
            <ul>
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center p-3 rounded-lg
          {{ request()->is('admin/dashboard') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="font-medium">Pelanggan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.manajemenArtikel') }}"
                        class="flex items-center p-3 rounded-lg
                        {{ request()->is('admin/manajemenartikel') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Manajemen Artikel</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.rute') }}"
                        class="flex items-center p-3 rounded-lg
                        {{ request()->is('admin/rute') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Pengambilan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.pelaporan') }}"
                        class="flex items-center p-3 rounded-lg
                        {{ request()->is('admin/pelaporan') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Pelaporan</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="absolute bottom-0 w-full p-6">
        <ul>
            <li>
                <button onclick="openAdminModal()" type="button"
                    class="w-full flex items-center p-3 text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-left">Profil</span>
                </button>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="button" onclick="confirmLogout()"
                        class="w-full flex items-center p-3 text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-left">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Sidebar Modal Admin -->
    <div id="adminSettingsModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex justify-center items-center transition-opacity duration-300">
        <div
            class="bg-white w-auto min-w-[450px] max-w-lg h-auto min-h-[250px] rounded-2xl shadow-2xl transform transition-all duration-300 scale-95">
            <div class="px-6 py-4 border-b bg-emerald-100 rounded-t-2xl text-center">
                <h2 class="text-2xl font-semibold text-emerald-800" id="adminModalTitle">Pengaturan Admin</h2>
            </div>

            <div class="px-6 py-6 space-y-6 max-h-[80vh] overflow-y-auto" id="adminModalContent">
                <!-- Content will be populated by JavaScript -->
            </div>

            <div class="px-6 py-4 border-t bg-emerald-100 rounded-b-2xl">
                <button onclick="closeAdminModal()" type="button"
                    class="w-full py-2 text-emerald-600 hover:text-red-500 font-medium transition-colors text-base">Tutup</button>
            </div>
        </div>
    </div>
</aside>

<!-- Modal Konfirmasi Logout -->
<div id="logoutConfirmModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex justify-center items-center">
    <div class="bg-white w-full max-w-sm p-6 rounded shadow-lg">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Logout</h2>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin logout?</p>
        <div class="flex justify-end space-x-2">
            <button onclick="closeLogoutModal()" type="button"
                class="px-4 py-2 text-sm text-gray-500 hover:text-red-500">Batal</button>
            <button onclick="submitLogout()" type="button"
                class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">Ya, Logout</button>
        </div>
    </div>
</div>

<script>
    // Pastikan semua fungsi di scope global
    window.openAdminModal = function() {
        console.log('Opening admin modal...');
        const modal = document.getElementById('adminSettingsModal');
        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                const transform = modal.querySelector('.transform');
                if (transform) {
                    transform.classList.remove('scale-95');
                }
            }, 10);
            showAdminProfileAndPasswordForm();
        } else {
            console.error('Admin modal not found!');
        }
    };

    window.closeAdminModal = function() {
        console.log('Closing admin modal...');
        const modal = document.getElementById('adminSettingsModal');
        if (modal) {
            const transform = modal.querySelector('.transform');
            if (transform) {
                transform.classList.add('scale-95');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    };

    window.confirmLogout = function() {
        console.log('Opening logout confirmation...');
        const modal = document.getElementById('logoutConfirmModal');
        if (modal) {
            modal.classList.remove('hidden');
        } else {
            console.error('Logout modal not found!');
        }
    };

    window.closeLogoutModal = function() {
        console.log('Closing logout modal...');
        const modal = document.getElementById('logoutConfirmModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    };

    window.submitLogout = function() {
        console.log('Submitting logout...');
        const form = document.getElementById('logoutForm');
        if (form) {
            form.submit();
        } else {
            console.error('Logout form not found!');
        }
    };

    function showAdminProfileAndPasswordForm() {
        const titleElement = document.getElementById('adminModalTitle');
        const contentElement = document.getElementById('adminModalContent');

        if (titleElement) {
            titleElement.innerText = 'Pengaturan Admin';
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}";
        console.log('CSRF Token:', csrfToken);

        if (contentElement) {
            contentElement.innerHTML = `
            <form id="adminSettingsForm">
              <input type="hidden" name="_token" value="${csrfToken}">
              <input type="hidden" name="_method" value="PATCH">
              <div class="space-y-6">
                <div>
                  <label class="block text-sm font-medium text-emerald-700">Nama Lengkap</label>
                  <input type="text" name="nama_lengkap" value="{{ auth('admin')->user()->nama_lengkap }}" class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all bg-white text-sm" required>
                  <p class="text-sm text-red-600 mt-1 hidden" id="nama_lengkap_error"></p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-emerald-700">Email</label>
                  <input type="text" value="{{ auth('admin')->user()->email }}" class="w-full px-4 py-2 border border-emerald-300 rounded-lg bg-emerald-50 cursor-not-allowed text-sm" readonly>
                </div>
                <div>
                  <label class="block text-sm font-medium text-emerald-700">Telepon</label>
                  <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', auth('admin')->user()->nomor_telepon) }}" class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all bg-white text-sm">
                  <p class="text-sm text-red-600 mt-1 hidden" id="nomor_telepon_error"></p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-amber-700">Password Baru</label>
                  <input type="password" name="password" class="w-full px-4 py-2 border border-amber-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 transition-all bg-white text-sm">
                  <p class="text-sm text-red-600 mt-1 hidden" id="password_error"></p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-amber-700">Konfirmasi Password</label>
                  <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-amber-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 transition-all bg-white text-sm">
                </div>
              </div>
              <div class="mt-6 flex justify-end">
                <button type="button" onclick="submitAdminForm()" id="saveButton" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg hover:from-emerald-600 hover:to-emerald-700 transition-colors text-sm">Simpan</button>
              </div>
            </form>
          `;
        }
    }

    window.submitAdminForm = function() {
        const form = document.getElementById('adminSettingsForm');
        const saveButton = document.getElementById('saveButton');

        if (!form || !saveButton) {
            console.error('Form or save button not found!');
            return;
        }

        const formData = new FormData(form);

        // Reset previous error messages
        const errorElements = ['nama_lengkap_error', 'nomor_telepon_error', 'password_error'];
        errorElements.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.classList.add('hidden');
            }
        });

        // Show loading state
        saveButton.disabled = true;
        saveButton.innerText = 'Menyimpan...';

        fetch("{{ route('admin.nama_dan_password.update') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response ok:', response.ok);

                if (response.status === 419) {
                    throw new Error('CSRF token mismatch. Please refresh the page and try again.');
                }

                if (!response.ok) {
                    return response.text().then(text => {
                        console.log('Raw response:', text);
                        throw new Error(`Server error (status ${response.status}): ${text.substring(0, 100)}...`);
                    });
                }

                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    closeAdminModal();
                    window.location.reload();
                } else if (data.errors) {
                    errorElements.forEach(errorId => {
                        const fieldName = errorId.replace('_error', '');
                        if (data.errors[fieldName]) {
                            const errorElement = document.getElementById(errorId);
                            if (errorElement) {
                                errorElement.innerText = data.errors[fieldName][0];
                                errorElement.classList.remove('hidden');
                            }
                        }
                    });
                } else {
                    alert('Gagal menyimpan data: Tidak ada pesan kesalahan dari server.');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Terjadi kesalahan saat menyimpan data: ' + error.message);
            })
            .finally(() => {
                saveButton.disabled = false;
                saveButton.innerText = 'Simpan';
            });
    };

    // Debug: Log when script loads
    console.log('Sidebar script loaded');

    // Debug: Check if elements exist when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded');
        console.log('Admin modal exists:', !!document.getElementById('adminSettingsModal'));
        console.log('Logout modal exists:', !!document.getElementById('logoutConfirmModal'));
        console.log('Logout form exists:', !!document.getElementById('logoutForm'));
    });
</script>
