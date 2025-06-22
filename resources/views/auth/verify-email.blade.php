<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow w-full max-w-md text-center">
        <h1 class="text-2xl font-bold mb-4">Verifikasi Email</h1>
        <p class="mb-4">Kami telah mengirimkan link verifikasi ke email kamu. Silakan cek dan klik link tersebut.</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Kirim Ulang Email Verifikasi
            </button>
        </form>
        @if (session('message'))
            <p class="text-green-600 mt-4">{{ session('message') }}</p>
        @endif

        @if (session('wa_link'))
            <a href="{{ session('wa_link') }}" class="inline-block mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Hubungi Admin via WhatsApp
            </a>
        @endif

    </div>
</body>
</html>
