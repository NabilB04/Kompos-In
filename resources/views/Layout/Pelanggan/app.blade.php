<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kompos-In</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body class="font-sans bg-white">

  @include('layout.Pelanggan.components.navbar')

  <main>
    @yield('content')
  </main>

  @include('layout.Pelanggan.components.footer')

  <script>
    function toggleDropdown() {
      const dropdown = document.getElementById('dropdownMenu');
      dropdown.classList.toggle('hidden');
    }
    document.addEventListener('click', function (event) {
      const dropdown = document.getElementById('dropdownMenu');
      const button = event.target.closest('button');
      if (!dropdown.contains(event.target) && !button) {
        dropdown.classList.add('hidden');
      }
    });
  </script>
</body>
</html>
