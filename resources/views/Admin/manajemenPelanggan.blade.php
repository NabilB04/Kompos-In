@extends('layout.admin.app')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-gray-900 font-semibold text-lg mb-6">Daftar Pelanggan</h2>

    <table class="w-full border-collapse text-sm">
        <thead>
            <tr class="bg-green-100 text-gray-800 font-semibold text-[13px]">
                <th class="px-4 py-3 text-left border-b">Nama</th>
                <th class="px-4 py-3 text-left border-b">Email</th>
                <th class="px-4 py-3 text-left border-b">Alamat</th>
                <th class="px-4 py-3 text-left border-b">Latitude</th>
                <th class="px-4 py-3 text-left border-b">Longitude</th>
                <th class="px-4 py-3 text-left border-b">Status</th>
                <th class="px-4 py-3 text-left border-b">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @foreach($pelanggans as $pelanggan)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3">{{ $pelanggan->nama_lengkap }}</td>
                    <td class="px-4 py-3">{{ $pelanggan->email }}</td>
                    <td class="px-4 py-3">{{ $pelanggan->alamat }}</td>
                    <td class="px-4 py-3">{{ $pelanggan->latitude }}</td>
                    <td class="px-4 py-3">{{ $pelanggan->longitude }}</td>
                    <td class="px-4 py-3">{{ $pelanggan->status->nama_status ?? '-' }}
                    </td>
                    <td class="px-4 py-3 flex space-x-3">
                        <button
                            onclick="editPelanggan({{ $pelanggan->pelanggan_id }}, '{{ $pelanggan->alamat }}', '{{ $pelanggan->latitude }}', '{{ $pelanggan->longitude }}', '{{ $pelanggan->status_id }}')"
                            class="text-green-700 hover:text-green-800 flex items-center gap-1 font-semibold">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6 flex justify-center">
        {{ $pelanggans->links() }}
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300">
    <div
        class="bg-white w-auto min-w-[450px] max-w-lg h-auto min-h-[250px] rounded-2xl shadow-2xl transform transition-all duration-300 scale-95">
        <div class="px-6 py-4 border-b bg-emerald-100 rounded-t-2xl text-center">
            <h3 class="text-2xl font-semibold text-emerald-800">Edit Data Pelanggan</h3>
        </div>

        <div class="px-6 py-6 space-y-6 max-h-[80vh] overflow-y-auto" id="editModalContent">
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')

                <input type="hidden" id="pelanggan_id" name="pelanggan_id" />

                <div>
                    <label class="block text-sm font-medium text-emerald-700">Alamat</label>
                    <input type="text" id="alamat" name="alamat"
                        class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all bg-white text-sm" />
                    <p class="text-sm text-red-600 mt-1 hidden" id="alamat_error"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-emerald-700">Latitude</label>
                    <input type="text" id="latitude" name="latitude"
                        class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all bg-white text-sm" />
                    <p class="text-sm text-red-600 mt-1 hidden" id="latitude_error"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-emerald-700">Longitude</label>
                    <input type="text" id="longitude" name="longitude"
                        class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all bg-white text-sm" />
                    <p class="text-sm text-red-600 mt-1 hidden" id="longitude_error"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-amber-700">Status</label>
                    <select id="status_id" name="status_id"
                        class="w-full px-4 py-2 border border-amber-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 transition-all bg-white text-sm">
                        <option value="1">Aktif</option>
                        <option value="2">Tidak Aktif</option>
                    </select>
                    <p class="text-sm text-red-600 mt-1 hidden" id="status_id_error"></p>
                </div>

                <div class="px-6 py-4 border-t bg-emerald-100 rounded-b-2xl flex justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                        class="text-sm text-emerald-600 hover:text-red-500 font-medium transition-colors">Batal</button>
                    <button id="submitBtn" type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg hover:from-emerald-600 hover:to-emerald-700 transition-colors text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<script>
    function editPelanggan(id, alamat, latitude, longitude, status_id) {
        document.getElementById('editForm').action = `/admin/pelanggan/${id}`;

        document.getElementById('pelanggan_id').value = id;
        document.getElementById('alamat').value = alamat;
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;
        document.getElementById('status_id').value = status_id;

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
        // Reset error messages
        document.querySelectorAll('.text-red-600').forEach(error => error.classList.add('hidden'));
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('editForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);
            const url = form.getAttribute('action');

            // Reset error messages
            document.querySelectorAll('.text-red-600').forEach(error => error.classList.add('hidden'));

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const data = await response.json();

                    if (response.ok) {
                        if (data.success) {
                            closeModal();
                            window.location.reload();
                        } else {
                            alert('Update gagal, server tidak memberikan pesan kesalahan.');
                        }
                    } else if (response.status === 422) {
                        const errors = data.errors;
                        if (errors.alamat) {
                            document.getElementById('alamat_error').innerText = errors.alamat[
                            0];
                            document.getElementById('alamat_error').classList.remove('hidden');
                        }
                        if (errors.latitude) {
                            document.getElementById('latitude_error').innerText = errors
                                .latitude[0];
                            document.getElementById('latitude_error').classList.remove(
                            'hidden');
                        }
                        if (errors.longitude) {
                            document.getElementById('longitude_error').innerText = errors
                                .longitude[0];
                            document.getElementById('longitude_error').classList.remove(
                                'hidden');
                        }
                        if (errors.status_id) {
                            document.getElementById('status_id_error').innerText = errors
                                .status_id[0];
                            document.getElementById('status_id_error').classList.remove(
                                'hidden');
                        }
                    } else {
                        alert('Terjadi kesalahan saat memperbarui data: ' + response
                        .statusText);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui data: ' + error.message);
                });

        });
    });

</script>
