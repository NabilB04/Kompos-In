<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Pelanggan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r relative">
      <div class="p-6">
        <img src="<?php echo e(asset('storage/logo_komposin_dashboardadmin.png')); ?>" alt="Kompos-IN Logo"  class="mx-auto mb-6" style="max-height: 50px;"/>
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
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="flex items-center text-gray-700 w-full text-left">
                    <i class="fas fa-power-off mr-3"></i> Logout
                </button>
            </form>
          </li>
        </ul>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <!-- Header -->
      <header class="flex items-center justify-between mb-6">
        <div class="flex items-center">
          <button class="text-gray-500 focus:outline-none lg:hidden">
            <i class="fas fa-bars"></i>
          </button>
          <div class="relative ml-4 lg:ml-0">
            <input type="text" placeholder="Search" class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"/>
            <i class="fas fa-search absolute left-3 top-3 text  -gray-400"></i>
          </div>
        </div>
        <div class="flex items-center">
          <img src="https://placehold.co/40x40" alt="User Avatar" class="w-10 h-10 rounded-full mr-3"/>
          <div>
            
            <p class="text-gray-500 text-sm">Admin</p>
          </div>
        </div>
      </header>

      <!-- Breadcrumb -->
      <nav class="text-gray-500 mb-6">
        <ol class="list-reset flex">
          <li><a href="#" class="text-green-600">Pelanggan</a></li>
          <li><span class="mx-2">/</span></li>
          <li><a href="#" class="text-green-600">Mas Anies</a></li>
          <li><span class="mx-2">/</span></li>
          <li>Edit</li>
        </ol>
      </nav>

      <!-- Form -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Edit Mas Anies Mas Anies</h2>
        <form action="#" method="POST">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PATCH'); ?>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label class="block text-gray-700">Nama <span class="text-red-500">*</span></label>
              <input type="text" name="nama" value="Busway dan" class="w-full mt-2 p-2 border rounded-lg"/>
            </div>
            <div>
              <label class="block text-gray-700">Alamat Email <span class="text-red-500">*</span></label>
              <input type="email" name="email" value="masanis@gmail.com" class="w-full mt-2 p-2 border rounded-lg"/>
            </div>
            <div>
              <label class="block text-gray-700">No. Telepon</label>
              <input type="text" name="telepon" value="+62 8123-4567-8910" class="w-full mt-2 p-2 border rounded-lg"/>
            </div>
            <div>
              <label class="block text-gray-700">Status</label>
              <select name="status" class="w-full mt-2 p-2 border rounded-lg">
                <option value="Aktif" selected>Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
              </select>
            </div>
          </div>

          <div class="flex items-center">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg mr-2">Save changes</button>
            <a href="#" class="bg-white border px-4 py-2 rounded-lg">Cancel</a>
          </div>
        </form>
      </div>

      <!-- Address Section -->
      <div class="mt-6">
        <h3 class="text-xl font-semibold mb-4">Alamat</h3>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex justify-between items-center mb-4">
            <button class="bg-white border px-4 py-2 rounded-lg">Attach</button>
            <button class="bg-green-600 text-white px-4 py-2 rounded-lg">Tambah Alamat</button>
          </div>
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-gray-100">
                <th class="p-3 border-b">Alamat</th>
                <th class="p-3 border-b">Longitude</th>
                <th class="p-3 border-b">Kecamatan</th>
                <th class="p-3 border-b">Kota</th>
                <th class="p-3 border-b">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr class="bg-green-50">
                <td class="p-3 border-b"><input type="checkbox" class="mr-2"/>Jl. Semboro Fighter no.13</td>
                <td class="p-3 border-b">78613</td>
                <td class="p-3 border-b">Semboro</td>
                <td class="p-3 border-b">Jember</td>
                <td class="p-3 border-b">
                  <a href="#" class="text-green-600 mr-2">Edit</a>
                  <a href="#" class="text-red-600 mr-2">Detach</a>
                  <a href="#" class="text-red-600">Delete</a>
                </td>
              </tr>
              <tr>
                <td class="p-3 border-b"><input type="checkbox" class="mr-2"/>Jl. Tanggul Keras no.09</td>
                <td class="p-3 border-b">47153-0487</td>
                <td class="p-3 border-b">Tanggul</td>
                <td class="p-3 border-b">Jember</td>
                <td class="p-3 border-b">
                  <a href="#" class="text-green-600 mr-2">Edit</a>
                  <a href="#" class="text-red-600 mr-2">Detach</a>
                  <a href="#" class="text-red-600">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="flex justify-between items-center mt-4">
            <span>Per page</span>
            <select class="border rounded-lg p-2">
              <option>10</option>
              <option>20</option>
              <option>30</option>
            </select>
          </div>
        </div>
      </div>
    </main>
  </div>

<!-- Sidebar Modal Admin -->
<div id="adminSettingsModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex justify-end">
    <div class="bg-white w-full max-w-sm h-full overflow-y-auto shadow-xl">
      <div class="px-6 py-4 border-b flex justify-between items-center">
        <h2 class="text-lg font-bold" id="adminModalTitle">Pengaturan Admin</h2>
        <button onclick="closeAdminModal()" class="text-gray-500 hover:text-red-600 text-xl">&times;</button>
      </div>

      <!-- Konten dinamis -->
      <div class="px-6 py-4 space-y-4" id="adminModalContent">
        <button onclick="showAdminUbahNama()" class="block w-full text-left px-4 py-2 rounded bg-stone-100 text-black hover:bg-stone-200">Ubah Nama</button>
        <button onclick="showAdminUbahPassword()" class="block w-full text-left px-4 py-2 rounded bg-stone-100 text-black hover:bg-stone-200">Ubah Password</button>
      </div>

      <div class="px-6 py-3 border-t text-right">
        <button onclick="closeAdminModal()" class="text-gray-500 hover:text-red-500">Tutup</button>
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
        <button onclick="showAdminUbahNama()" class="block w-full text-left px-4 py-2 rounded bg-stone-100 text-black hover:bg-stone-200">Ubah Nama</button>
        <button onclick="showAdminUbahPassword()" class="block w-full text-left px-4 py-2 rounded bg-stone-100 text-black hover:bg-stone-200">Ubah Password</button>
      `;
    }

    function showAdminUbahNama() {
      document.getElementById('adminModalTitle').innerText = 'Ubah Nama Admin';
      document.getElementById('adminModalContent').innerHTML = `
        <form method="POST" action="<?php echo e(route('admin.nama.update')); ?>">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PATCH'); ?>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
              <input type="text" name="nama_lengkap" value="<?php echo e(auth('admin')->user()->nama_lengkap); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-green-300" required>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <input type="text" value="<?php echo e(auth('admin')->user()->email); ?>" class="w-full px-3 py-2 border rounded bg-gray-100" readonly>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Telepon</label>
              <input type="text" value="<?php echo e(auth('admin')->user()->nomor_telepon); ?>" class="w-full px-3 py-2 border rounded bg-gray-100" readonly>
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
        <form method="POST" action="/admin/update/password">
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <input type="hidden" name="_method" value="PATCH">

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
  </script>

</body>
</html>
<?php /**PATH E:\laragon\www\komposin-v1\resources\views/Admin/dashboard.blade.php ENDPATH**/ ?>