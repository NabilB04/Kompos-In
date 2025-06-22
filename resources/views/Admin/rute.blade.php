@extends('layout.admin.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="flex flex-col lg:flex-row h-screen bg-gray-100">

  <!-- Sidebar -->
  <div class="lg:w-1/2 w-full bg-blue-200 shadow-lg p-6 overflow-y-auto flex flex-col justify-between rounded-r-xl">
    <div>

      <div class="flex items-center justify-between space-x-4 mb-2">
        <h2 class="text-2xl font-bold text-blue-900">Device Tracker</h2>
        <div class="flex space-x-4">
            <button id="routeBtn"
                class="bg-blue-700 text-white px-5 py-3 rounded-lg shadow-md hover:bg-blue-800 transition">
                Optimasi Rute
            </button>

            <button id="selesaiBtn"
                class="bg-green-600 text-white px-5 py-3 rounded-lg shadow-md hover:bg-green-700 transition">
                Selesai
            </button>

            <button id="resetBtn"
                class="bg-red-600 text-white px-5 py-3 rounded-lg shadow-md hover:bg-red-700 transition">
                Reset Konversi
            </button>
        </div>
      </div>



      @if(session('success') || session('error'))
      <div id="popupMessage"
        class="mb-4 px-4 py-3 rounded-md shadow transition-opacity duration-500
        {{ session('success') ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
        {{ session('success') ?? session('error') }}
      </div>

      <script>
        setTimeout(() => {
          const popup = document.getElementById('popupMessage');
          if (popup) {
            popup.style.opacity = '0';
            setTimeout(() => popup.remove(), 500);
          }
        }, 3000);
      </script>
      @endif

<!-- Tabel -->
      <div class="overflow-x-auto rounded-xl border border-blue-200 bg-white shadow-md">
        <table class="min-w-full divide-y divide-blue-200">
          <thead>
            <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
              <th class="px-6 py-4 text-center text-xs font-medium uppercase tracking-wider w-16">
                <span class="flex justify-center">
                  {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> --}}
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                </span>
              </th>
              <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Nama</th>
              <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Koordinat</th>
              <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Volume</th>
              <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Status</th>
              <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Ember</th>
              <th class="px-6 py-4 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($datarute as $index => $item)
            <tr id="row-{{ $item->pelanggan_id }}"
            class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-50' }}  transition-colors duration-150">
              <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="flex items-center justify-center">
                  <input type="checkbox"
                    class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition duration-150 ease-in-out cursor-pointer"
                    data-pelanggan-id="{{ $item->pelanggan_id }}"
                    data-lat="{{ $item->latitude }}"
                    data-lng="{{ $item->longitude }}"
                    data-volume="{{ strtolower($item->tempatSampah->status_penuh ?? '') }}"
                    data-status="{{ strtolower($item->status->nama_status ?? '') }}"
                  >
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ $item->nama_lengkap }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-700 font-mono">[{{ $item->latitude }}, {{ $item->longitude }}]</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                  {{ strtolower($item->tempatSampah->status_penuh ?? '') === 'penuh'
                      ? 'bg-red-100 text-red-800'
                      : 'bg-green-100 text-green-800' }}">
                  {{ $item->tempatSampah->status_penuh ?? '-' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                  {{ strtolower($item->status->nama_status ?? '') === 'aktif'
                      ? 'bg-green-100 text-green-800'
                      : 'bg-gray-100 text-gray-800' }}">
                  {{ $item->status->nama_status ?? '-' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                  <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ ($item->pengambilanSampah->jumlah_ember ?? 0) > 0 ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $item->pengambilanSampah->jumlah_ember ?? '0' }}
                  </span>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-center">
                <form action="{{ route('pelanggan.konfirmasi', $item->pelanggan_id) }}" method="POST">
                  @csrf
                  <button type="submit"
                      class="konfirmasi-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition-colors duration-150"
                      data-pelanggan-id="{{ $item->pelanggan_id }}"
                      data-jumlah-ember="{{ $item->pengambilanSampah->jumlah_ember ?? 0 }}">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                      </svg>
                      Konversi
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Empty State -->
      @if(count($datarute) === 0)
      <div class="text-center py-10">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
        <p class="mt-1 text-sm text-gray-500">Belum ada data pelanggan yang tersedia.</p>
      </div>
      @endif
    </div>
  </div>


  <!-- Map -->
  <div id="map" class="lg:w-1/2 w-full h-96 lg:h-full rounded-l-xl"></div>
</div>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Routing -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>

<script>
const map = L.map('map').setView([-8.165177, 113.702789], 17);

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(position => {
        map.setView([position.coords.latitude, position.coords.longitude], 13);
    });
}

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);

const markerMap = {};
const checkboxes = document.querySelectorAll('input[type="checkbox"]');

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const id = this.dataset.pelangganId;
        const lat = parseFloat(this.dataset.lat);
        const lng = parseFloat(this.dataset.lng);
        const volume = this.dataset.volume;
        const status = this.dataset.status;
        const markerId = `marker-${id}`;

        if (this.checked) {
            if (volume !== 'penuh' || status !== 'aktif') {
                this.checked = false;
                alert('Hanya pelanggan dengan status AKTIF dan volume PENUH yang dapat dipilih.');
                return;
            }

            const redIcon = L.icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                iconSize: [32, 32], iconAnchor: [16, 32]
            });

            const greenIcon = L.icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                iconSize: [32, 32], iconAnchor: [16, 32]
            });

            const marker = L.marker([lat, lng], { icon: redIcon }).addTo(map);
            marker.on('click', function () {
                marker.setIcon(greenIcon);
                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                    .then(res => res.json())
                    .then(data => {
                        const address = data.display_name || "Alamat tidak ditemukan";
                        marker.bindPopup(`<b>Alamat:</b><br>${address}`).openPopup();
                    })
                    .catch(err => {
                        marker.bindPopup("Gagal mengambil alamat.").openPopup();
                        console.error(err);
                    });
            });

            markerMap[markerId] = { marker, pelanggan_id: id, lat, lng };
        } else {
            if (markerMap[markerId]) {
                map.removeLayer(markerMap[markerId].marker);
                delete markerMap[markerId];
            }
        }
    });
});

let routeControl = null;

// Tombol Optimasi Rute
document.getElementById('routeBtn').addEventListener('click', () => {
    if (!navigator.geolocation) {
        alert("Geolocation tidak didukung.");
        return;
    }

    navigator.geolocation.getCurrentPosition(position => {
        const userLatLng = [position.coords.latitude, position.coords.longitude];
        const waypoints = [L.latLng(userLatLng)];

        Object.values(markerMap).forEach(({ marker }) => {
            waypoints.push(marker.getLatLng());
        });

        if (waypoints.length <= 1) {
            alert("Tidak ada marker aktif.");
            return;
        }

        if (routeControl) {
            map.removeControl(routeControl);
        }

        routeControl = L.Routing.control({
            waypoints: waypoints,
            routeWhileDragging: false,
            show: false,
            plan: L.Routing.plan(waypoints, {
                createMarker: () => null
            }),
        }).addTo(map);
    });
});

// Tombol Selesai (Tambah Data ke Database)
document.getElementById('selesaiBtn').addEventListener('click', () => {
    const pelangganIds = [];

    Object.values(markerMap).forEach(({ pelanggan_id }) => {
        pelangganIds.push(pelanggan_id);
    });

    if (pelangganIds.length === 0) {
        alert("Belum melakukan optimasi rute.");
        return;
    }

    fetch("{{ route('Admin.tambahEmber') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')
        },
        body: JSON.stringify({ pelanggan_ids: JSON.stringify(pelangganIds) })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.reload(); // Reload setelah sukses
    })
    .catch(err => {
        console.error(err);
        alert("Terjadi kesalahan saat menyimpan data.");
    });
});



document.addEventListener('DOMContentLoaded', function () {
    // Saat tombol konfirmasi ditekan
    document.querySelectorAll('.konfirmasi-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            const pelangganId = this.dataset.pelangganId;
            const jumlahEmber = parseInt(this.dataset.jumlahEmber);

            if (jumlahEmber < 10) {
                alert("Jumlah ember harus minimal 10 untuk bisa dikonfirmasi.");
                e.preventDefault();
                return;
            }

            // Simpan ke localStorage
            const now = new Date().getTime();
            localStorage.setItem(`konfirmasi-${pelangganId}`, now);
        });
    });

    // Tombol Reset Background
  document.getElementById('resetBtn').addEventListener('click', () => {
    if (!confirm("Apakah Anda yakin ingin mereset list data konversi?")) return;

    document.querySelectorAll('tr[id^="row-"]').forEach((row, index) => {
        const pelangganId = row.id.replace('row-', '');
        localStorage.removeItem(`konfirmasi-${pelangganId}`);

        // Reset warna
        row.classList.remove('bg-green-300');
        row.classList.add(index % 2 === 0 ? 'bg-white' : 'bg-blue-50');
    });
});


    // Saat halaman dimuat, cek localStorage
    document.querySelectorAll('tr[id^="row-"]').forEach(row => {
        const pelangganId = row.id.replace('row-', '');
        const timestamp = localStorage.getItem(`konfirmasi-${pelangganId}`);
        const now = new Date().getTime();

        if (timestamp && (now - timestamp) < 24 * 60 * 60 * 1000) {
            row.classList.remove('bg-white', 'bg-blue-50');
            row.classList.add('bg-green-300');
        } else if (timestamp) {
            localStorage.removeItem(`konfirmasi-${pelangganId}`);
        }
    });
});

</script>

@endsection
