<!-- resources/views/auth/password/reset.blade.php -->
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
            <h2 class="text-4xl font-bold text-center mb-2">Setel Ulang Password</h2>
            @if($errors->any())
                <div class="mb-4 text-red-700 bg-red-100 border border-red-300 rounded-lg px-4 py-3">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="guard" value="{{ $guard }}">
                <div>
                    <label class="block mb-1 font-medium">Alamat email</label>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" required
                        class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Password baru</label>
                    <input type="password" name="password" required
                        class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Konfirmasi password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" />
                </div>
                <button type="submit"
                    class="w-full bg-green-800 hover:bg-green-700 text-white py-3 rounded-lg shadow-md">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</body>
</html>
