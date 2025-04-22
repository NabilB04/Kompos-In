@extends('layout.admin.app')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
  <h2 class="text-gray-900 font-semibold text-lg mb-6">Daftar Pelanggan</h2>

  <table class="w-full border-collapse text-sm">
    <thead>
      <tr class="bg-[#f0f6e9] text-gray-800 font-semibold text-[13px]">
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
      @foreach ($pelanggans as $pelanggan)
      <tr class="border-b hover:bg-gray-50 transition">
        <td class="px-4 py-3">{{ $pelanggan->nama_lengkap }}</td>
        <td class="px-4 py-3">{{ $pelanggan->email }}</td>
        <td class="px-4 py-3">{{ $pelanggan->alamat }}</td>
        <td class="px-4 py-3">{{ $pelanggan->latitude }}</td>
        <td class="px-4 py-3">{{ $pelanggan->longitude }}</td>
        <td class="px-4 py-3">{{ $pelanggan->status->nama_status ?? '-' }}</td>
        <td class="px-4 py-3 flex space-x-3">
          <a href="{{ route('admin.pelanggan.edit', $pelanggan->pelanggan_id) }}" class="text-green-700 hover:text-green-800 flex items-center gap-1 font-semibold">
            <i class="fas fa-edit"></i> Edit
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- Pagination --}}
  <div class="mt-6 flex justify-center">
    {{ $pelanggans->links() }}
  </div>
</div>
@endsection
