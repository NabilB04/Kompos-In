<aside class="w-64 bg-white border-r relative">
    <div class="p-6">
      <img src="{{ asset('img/logo_komposin.png') }}" alt="Kompos-IN Logo" class="mx-auto mb-6" style="max-height: 30px;" />
      <nav>
        <ul>
          <li class="mb-4">
            <a href="#" class="flex items-center text-green-600 font-medium">
              <i class="fas fa-users mr-3"></i> Pelanggan
            </a>
          </li>
          <li class="mb-4">
            <a href="#" class="flex items-center text-gray-700">
              <i class="fas fa-file-alt mr-3"></i> Konten Branding
            </a>
          </li>
          <li class="mb-4">
            <a href="#" class="flex items-center text-gray-700">
              <i class="fas fa-trash-alt mr-3"></i> Pengambilan Sampah
            </a>
          </li>
          <li class="mb-4">
            <a href="#" class="flex items-center text-gray-700">
              <i class="fas fa-flag mr-3"></i> Pelaporan
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="absolute bottom-0 w-full p-6">
      <ul>
        <li class="mb-4">
          <button onclick="openAdminModal()" class="flex items-center text-gray-700 w-full focus:outline-none">
            <i class="fas fa-cog mr-3"></i> Pengaturan
          </button>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="button" onclick="confirmLogout()" class="flex items-center text-gray-700 w-full text-left">
                  <i class="fas fa-power-off mr-3"></i> Logout
                </button>
              </form>
        </li>
      </ul>
    </div>

    <!-- Sidebar Modal Admin -->
    <div id="adminSettingsModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex justify-end">
      <div class="bg-white w-full max-w-sm h-full overflow-y-auto shadow-xl">
        <div class="px-6 py-4 border-b flex justify-between items-center">
          <h2 class="text-lg font-bold" id="adminModalTitle">Pengaturan Admin</h2>
          <button onclick="closeAdminModal()" class="text-gray-500 hover:text-red-600 text-xl">&times;</button>
        </div>

        <div class="px-6 py-4 space-y-4" id="adminModalContent">
          <button onclick="showAdminUbahNama()" class="block w-full text-left px-4 py-2 rounded bg-stone-100 text-black hover:bg-stone-200">Ubah Profil</button>
          <button onclick="showAdminUbahPassword()" class="block w-full text-left px-4 py-2 rounded bg-stone-100 text-black hover:bg-stone-200">Ubah Password</button>
        </div>

        <div class="px-6 py-3 border-t text-right">
          <button onclick="closeAdminModal()" class="text-gray-500 hover:text-red-500">Tutup</button>
        </div>
      </div>
    </div>
  </aside>

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
    function openAdminModal() {
      document.getElementById('adminSettingsModal').classList.remove('hidden');
      resetAdminModal();
    }

    function closeAdminModal() {
      document.getElementById('adminSettingsModal').classList.add('hidden');
    }

    function resetAdminModal() {
      document.getElementById('adminModalTitle').innerText = 'Pengaturan Admin';
      document.getElementById('adminModalContent').innerHTML = `
        <button onclick="showAdminUbahNama()" class="block w-full text-left px-4 py-2 rounded bg-stone-100 text-black hover:bg-stone-200">Ubah Profil</button>
        <button onclick="showAdminUbahPassword()" class="block w-full text-left px-4 py-2 rounded bg-stone-100 text-black hover:bg-stone-200">Ubah Password</button>
      `;
    }

    function showAdminUbahNama() {
      document.getElementById('adminModalTitle').innerText = 'Ubah Nama Admin';
      document.getElementById('adminModalContent').innerHTML = `
        <form method="POST" action="{{ route('admin.nama.update') }}">
          @csrf
          @method('PATCH')

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
              <input type="text" name="nama_lengkap" value="{{ auth('admin')->user()->nama_lengkap }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-green-300" required>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <input type="text" value="{{ auth('admin')->user()->email }}" class="w-full px-3 py-2 border rounded bg-gray-100" readonly>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Telepon</label>
              <input type="text" name="nomor_telepon" value="{{ auth('admin')->user()->nomor_telepon }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-green-300">
            </div>
          </div>

          <div class="mt-4 flex justify-between">
            <button type="button" onclick="resetAdminModal()" class="text-sm text-gray-500 hover:text-red-500">Kembali</button>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
          </div>
        </form>
      `;
    }

    function showAdminUbahPassword() {
      document.getElementById('adminModalTitle').innerText = 'Ubah Password';
      document.getElementById('adminModalContent').innerHTML = `
        <form method="POST" action="{{ route('admin.password.update') }}">
          @csrf
          @method('PATCH')

          <label class="block mb-2 text-sm font-medium text-gray-700">Password Baru</label>
          <input type="password" name="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-yellow-300" required>

          <label class="block mt-4 mb-2 text-sm font-medium text-gray-700">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-yellow-300" required>

          <div class="mt-4 flex justify-between">
            <button type="button" onclick="resetAdminModal()" class="text-sm text-gray-500 hover:text-red-500">Kembali</button>
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
