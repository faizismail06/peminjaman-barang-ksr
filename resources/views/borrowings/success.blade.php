@extends('layouts.app')

@section('title', 'Permohonan Berhasil Dikirim')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-2xl mx-auto text-center">
        <!-- Success Icon -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full">
                <i class="fas fa-check-circle text-5xl text-green-500"></i>
            </div>
        </div>

        <!-- Success Message -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Permohonan Berhasil Dikirim!</h1>
        <p class="text-lg text-gray-600 mb-8">
            Terima kasih telah mengajukan permohonan peminjaman barang. Permohonan Anda sedang diproses oleh admin KSR PMI Polines.
        </p>

        <!-- Info Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8 text-left">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Apa Selanjutnya?</h2>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fas fa-envelope text-crimson text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Cek Email Anda</h3>
                        <p class="text-gray-600 text-sm">Kami akan mengirimkan notifikasi melalui email yang Anda berikan.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fas fa-phone text-crimson text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Pastikan Telepon Anda Aktif</h3>
                        <p class="text-gray-600 text-sm">Admin mungkin akan menghubungi Anda untuk konfirmasi lebih lanjut.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fas fa-clock text-crimson text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Waktu Proses</h3>
                        <p class="text-gray-600 text-sm">Biasanya permohonan akan diproses dalam 1-2 hari kerja.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-crimson bg-opacity-10 rounded-lg p-6 mb-8">
            <h3 class="font-bold text-gray-800 mb-2">Butuh Bantuan?</h3>
            <p class="text-gray-600 text-sm mb-4">Hubungi kami jika ada pertanyaan:</p>
            <div class="flex justify-center space-x-6">
                <a href="mailto:info@ksrpmipolines.ac.id" class="text-crimson hover:text-maroon">
                    <i class="fas fa-envelope mr-2"></i>info@ksrpmipolines.ac.id
                </a>
                <a href="tel:+62247473417" class="text-crimson hover:text-maroon">
                    <i class="fas fa-phone mr-2"></i>(024) 7473417
                </a>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4">
            <a href="{{ route('home') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-300 font-semibold">
                <i class="fas fa-home mr-2"></i>Kembali ke Beranda
            </a>
            <a href="{{ route('katalog') }}" class="bg-crimson text-white px-6 py-3 rounded-lg hover:bg-maroon transition duration-300 font-semibold">
                <i class="fas fa-box mr-2"></i>Lihat Katalog Lainnya
            </a>
        </div>
    </div>
</div>
@endsection
