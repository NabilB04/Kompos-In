<!-- resources/views/auth/password/email.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Kompos-IN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f3f8ec] min-h-screen flex items-center justify-center">
    <div class="flex w-full max-w-6xl mx-auto bg-white shadow-lg rounded-3xl overflow-hidden">
        <div class="w-full p-10">
            <h2 class="text-4xl font-bold text-center mb-2">Reset Password</h2>
            @if(session('status'))
                <div class="mb-4 text-green-700 bg-green-100 border border-green-300 rounded-lg px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 text-red-700 bg-red-100 border border-red-300 rounded-lg px-4 py-3">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block mb-1 font-medium">Masukkan alamat email</label>
                    <input type="email" name="email" placeholder="Alamat email" required
                        class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" />
                </div>
                <button type="submit"
                    class="w-full bg-green-800 hover:bg-green-700 text-white py-3 rounded-lg shadow-md">
                    Kirim Link Reset
                </button>
            </form>
            <p class="mt-4 text-sm text-gray-600">
                Kembali ke <a href="{{ route('login') }}" class="text-green-800 hover:underline">Login</a>
            </p>
        </div>
    </div>
</body>
</html>
