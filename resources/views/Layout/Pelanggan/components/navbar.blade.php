<header class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <div class="text-2xl font-bold text-green-600">KOMPOS-IN</div>
      <nav class="flex items-center space-x-4">
        <a href="#" class="text-gray-700 hover:text-green-600">Fitur</a>
        <a href="#" class="text-gray-700 hover:text-green-600">Artikel</a>
        <a href="#" class="text-gray-700 hover:text-green-600">Tentang</a>
        <a href="#" class="text-gray-700 hover:text-green-600">Kontak</a>

        @if (session('role') === 'pelanggan')
        <!-- Profile Dropdown -->
        <div class="relative">
          <button onclick="toggleDropdown()" class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center text-xl focus:outline-none">
            <i class="fas fa-user"></i>
          </button>
          <div id="dropdownMenu" class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded shadow-md hidden z-50">
            <div class="py-1 border-b">
              <div class="px-4 py-2 text-xs text-gray-500 uppercase">Pengaturan</div>
              <button onclick="openAccountModal()" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-green-100">Profil</button>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="py-1" id="logoutForm">
                @csrf
                <button type="button" onclick="confirmLogout()" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-green-100">Logout</button>
            </form>
          </div>
        </div>
        @else
        <a href="{{ route('login') }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">Login</a>
        @endif
      </nav>
    </div>
  </header>

<!-- Sidebar Modal -->
<div id="accountSettingsModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex justify-end">
    <div class="bg-white w-full max-w-sm h-full overflow-y-auto shadow-xl">
      <div class="px-6 py-4 border-b flex justify-between items-center">
        <h2 class="text-lg font-bold" id="modalTitle">Pengaturan Akun</h2>
        <button onclick="closeAccountModal()" class="text-gray-500 hover:text-red-600 text-xl">&times;</button>
      </div>

      <!-- Konten dinamis -->
      <div class="px-6 py-4 space-y-4" id="modalContent">
        <div id="profilBladeContent" class="hidden">
            @if(auth('pelanggan')->check())
              <div class="space-y-4 text-sm">
                <div>
                  <span class="block text-gray-500">Nama Lengkap</span>
                  <p class="font-medium">{{ auth('pelanggan')->user()->nama_lengkap }}</p>
                </div>
                <div>
                  <span class="block text-gray-500">Email</span>
                  <p class="font-medium">{{ auth('pelanggan')->user()->email }}</p>
                </div>
                <div>
                  <span class="block text-gray-500">Nomor Telepon</span>
                  <p class="font-medium">{{ auth('pelanggan')->user()->nomor_telepon }}</p>
                </div>
                <div>
                  <span class="block text-gray-500">Alamat</span>
                  <p class="font-medium whitespace-pre-line">{{ auth('pelanggan')->user()->alamat }}</p>
                </div>
              </div>
            @else
              <p class="text-gray-500">Data pengguna tidak tersedia.</p>
            @endif
          </div>

      </div>

      <div class="px-6 py-3 border-t text-right">
        <button onclick="closeAccountModal()" class="text-gray-500 hover:text-red-500">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Modal Konfirmasi Logout -->
<div id="logoutConfirmModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white w-full max-w-sm p-6 rounded shadow-lg">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Logout</h2>
      <p class="text-gray-600 mb-6">Apakah Anda yakin ingin logout?</p>
      <div class="flex justify-end space-x-2">
        <button onclick="closeLogoutModal()" class="px-4 py-2 text-sm text-gray-500 hover:text-red-500">Batal</button>
        <button onclick="submitLogout()" class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">Ya, Logout</button>
      </div>
    </div>
  </div>



  <script>
    function toggleDropdown() {
      document.getElementById('dropdownMenu').classList.toggle('hidden');
    }

    function openAccountModal() {
      document.getElementById('accountSettingsModal').classList.remove('hidden');
      resetModal();
    }

    function closeAccountModal() {
      document.getElementById('accountSettingsModal').classList.add('hidden');
    }

    function resetModal() {
    document.getElementById('modalTitle').innerText = 'Profil Saya';

    const content = document.getElementById('profilBladeContent').cloneNode(true);
    content.classList.remove('hidden');

    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = '';
    modalContent.appendChild(content);
    }

    function showUbahNama() {
    document.getElementById('modalTitle').innerText = 'Ubah Nama';
    document.getElementById('modalContent').innerHTML = `
        <form method="POST" action="{{ route('pengaturan.nama.simpan') }}">
        @csrf
        <div class="space-y-4">
            <div>
            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ auth('pelanggan')->check() ? auth('pelanggan')->user()->nama_lengkap : '' }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-green-300" required>
            </div>

            <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="text" value="{{ auth('pelanggan')->check() ? auth('pelanggan')->user()->email : '' }}" class="w-full px-3 py-2 border rounded bg-gray-100" readonly>
            </div>

            <div>
            <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <input type="text" value="{{ auth('pelanggan')->check() ? auth('pelanggan')->user()->nomor_telepon : '' }}" class="w-full px-3 py-2 border rounded bg-gray-100" readonly>
            </div>

            <div>
            <label class="block text-sm font-medium text-gray-700">Alamat</label>
            <textarea class="w-full px-3 py-2 border rounded bg-gray-100" readonly>{{ auth('pelanggan')->check() ? auth('pelanggan')->user()->alamat : '' }}</textarea>
            </div>
        </div>

        <div class="mt-4 flex justify-between">
            <button type="button" onclick="resetModal()" class="text-sm text-gray-500 hover:text-red-500">Kembali</button>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
        </div>
        </form>
    `;
    }


    function showUbahPassword() {
    document.getElementById('modalTitle').innerText = 'Ubah Password';
    document.getElementById('modalContent').innerHTML = `
        <form method="POST" action="{{ route('pengaturan.password.simpan') }}">
        @csrf

        <label class="block mb-2 text-sm font-medium text-gray-700">Password Baru</label>
        <input type="password" name="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-yellow-300" required>

        <label class="block mt-4 mb-2 text-sm font-medium text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-yellow-300" required>

        <div class="mt-4 flex justify-between">
            <button type="button" onclick="resetModal()" class="text-sm text-gray-500 hover:text-red-500">Kembali</button>
            <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Simpan</button>
        </div>
        </form>
    `;
    }

    function confirmLogout() {
    document.getElementById('logoutConfirmModal').classList.remove('hidden');
    }

    function closeLogoutModal() {
    document.getElementById('logoutConfirmModal').classList.add('hidden');
    }

    function submitLogout() {
    document.getElementById('logoutForm').submit();
    }

  </script>


