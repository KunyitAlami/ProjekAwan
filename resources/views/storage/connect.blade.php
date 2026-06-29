@extends('layout.app')

@section('title', 'Connect Storage')

@section('content')
<div class="max-w-md mx-auto mt-16 bg-white rounded-xl shadow p-8">

    <h2 class="text-2xl font-bold mb-2">
        Connect to Object Storage
    </h2>

    <p class="text-gray-500 mb-6">
        Masukkan Access Key dan Secret Key untuk mengakses layanan storage.
    </p>

    @if($errors->any())
        <div class="mb-4 text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('storage.authenticate') }}">

        @csrf

        <div class="mb-4">
            <label class="block mb-1">Access Key</label>
            <input type="text"
                   name="access_key"
                   class="w-full border rounded p-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Secret Key</label>
            <input type="password"
                   name="secret_key"
                   class="w-full border rounded p-2"
                   required>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded">
            Connect
        </button>

    </form>

</div>
@endsection