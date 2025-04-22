<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | @yield('title', 'Dashboard')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

  <div class="flex min-h-screen">
    {{-- Sidebar --}}
    @include('layout.admin.components.sidebar')

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">
      {{-- Header --}}
      @include('layout.admin.components.header')

      {{-- Content --}}
      <main class="flex-1 p-6">
        @yield('content')
      </main>
    </div>
  </div>

</body>
</html>
