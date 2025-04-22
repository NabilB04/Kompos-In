@extends('layout.Pelanggan.app')

@section('content')

<!-- Hero Section -->
<section class="relative h-[33rem] overflow-hidden">
    <div class="absolute inset-0 bg-[url('/img/background_komposin.png')] bg-repeat-x bg-[length:500px_auto] bg-center"></div>
    <div class="absolute inset-0 bg-black/40"></div>
    <!-- Konten Teks dan Tombol -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
      <h1 class="text-5xl font-extrabold text-white drop-shadow-md">KOMPOSIN</h1>
      <p class="mt-4 max-w-2xl text-white text-lg">
        Otomatisasi monitoring, penjadwalan, dan optimalisasi rute pengambilan sampah organik berbasis teknologi untuk lingkungan yang lebih bersih dan berkelanjutan
      </p>
      <div class="mt-6 space-x-4">
        <a href="#" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 font-semibold">Daftar Sekarang</a>
        <a href="#" class="bg-yellow-400 text-white px-6 py-3 rounded hover:bg-yellow-500 font-semibold">Pelajari Lebih Lanjut</a>
      </div>
    </div>
  </section>


<!-- Features Section -->
<section class="py-16 bg-white">
  <div class="container mx-auto text-center">
    <h2 class="text-3xl font-bold text-green-600">Fitur Unggulan Kompos-In</h2>
    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ([
            ['icon' => 'fa-microchip', 'title' => 'Monitoring IoT Real-time', 'desc' => 'Pantau kondisi tempat sampah organik Anda secara real-time melalui sensor ultrasonic.'],
            ['icon' => 'fa-route', 'title' => 'Optimalisasi Rute', 'desc' => 'Rute pengumpulan sampah optimal berdasarkan titik koordinat customer.'],
            ['icon' => 'fa-chart-line', 'title' => 'Dashboard Pelaporan', 'desc' => 'Akses riwayat pengelolaan sampah dan konversi ke pupuk.'],
            ['icon' => 'fa-book', 'title' => 'Edukasi Sampah Organik', 'desc' => 'Artikel edukatif tentang pengelolaan sampah organik.'],
            ['icon' => 'fa-comments', 'title' => 'Chatbot Cerdas', 'desc' => 'Chatbot dengan decision tree aktif 24/7.'],
            ['icon' => 'fa-shopping-cart', 'title' => 'E-commerce Pupuk', 'desc' => 'Belanja pupuk kompos dari platform kami.', 'link' => '/ecomerce'],
          ] as $fitur)
            @if(isset($fitur['link']))
              <a href="{{ $fitur['link'] }}" class="block bg-green-50 p-6 rounded shadow-md hover:bg-green-100 transition">
                <i class="fas {{ $fitur['icon'] }} text-4xl text-green-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-green-800">{{ $fitur['title'] }}</h3>
                <p class="mt-2 text-gray-600">{{ $fitur['desc'] }}</p>
              </a>
            @else
              <div class="bg-green-50 p-6 rounded shadow-md">
                <i class="fas {{ $fitur['icon'] }} text-4xl text-green-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-green-800">{{ $fitur['title'] }}</h3>
                <p class="mt-2 text-gray-600">{{ $fitur['desc'] }}</p>
              </div>
            @endif
          @endforeach
    </div>
  </div>
</section>

<!-- Articles Section -->
<section class="py-16 bg-gray-100">
  <div class="container mx-auto text-center">
    <h2 class="text-3xl font-bold text-green-600">Artikel Terbaru</h2>
    <p class="mt-4 text-gray-600">Update terbaru seputar pengelolaan sampah organik by Komposin</p>
    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach (range(1, 3) as $i)
      <div class="bg-white p-6 rounded shadow-md">
        <img src="https://placehold.co/300x200" alt="Article image" class="w-full h-40 object-cover rounded mb-4" />
        <h3 class="text-xl font-semibold">Judul Artikel {{ $i }}</h3>
        <p class="mt-2 text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
        <a href="#" class="text-green-600 hover:underline mt-4 block">Baca Selengkapnya</a>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Community Section -->
<section class="py-16 bg-green-50">
  <div class="container mx-auto text-center">
    <h2 class="text-3xl font-bold text-green-600">Bergabunglah dengan Komunitas Peduli Lingkungan</h2>
    <p class="mt-4 text-gray-600">Dukung gerakan Indonesia Bebas Sampah bersama Kompos-In</p>
    <a href="#" class="mt-6 inline-block bg-yellow-400 text-white px-6 py-3 rounded hover:bg-yellow-500">Bergabung</a>
  </div>
</section>

@endsection
