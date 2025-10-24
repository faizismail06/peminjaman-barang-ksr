@extends('layouts.app')

@section('title', 'Cek Status Peminjaman')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Cek Status Peminjaman</h1>
            <p class="text-gray-600">Masukkan kode peminjaman atau scan QR Code untuk melihat status</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <form action="{{ route('borrowings.track') }}" method="GET" id="trackingForm" class="space-y-6">
                <div>
                    <label for="code" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-barcode mr-2 text-crimson"></i>Kode Peminjaman
                    </label>
                    <div class="flex space-x-2">
                        <input type="text" 
                               name="code" 
                               id="code" 
                               value="{{ request('code') }}"
                               placeholder="Contoh: 2025-PJM-0001"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-crimson focus:border-transparent text-lg"
                               required>
                        <button type="submit" class="bg-crimson text-white px-8 py-3 rounded-lg hover:bg-maroon transition duration-300 font-semibold">
                            <i class="fas fa-search mr-2"></i>Cek Status
                        </button>
                    </div>
                </div>

                <!-- QR Scanner Option -->
                <div class="text-center">
                    <button type="button" 
                            id="scanButton"
                            onclick="toggleQRScanner()" 
                            class="text-crimson hover:text-maroon font-semibold">
                        <i class="fas fa-qrcode mr-2"></i>Atau Scan QR Code
                    </button>
                    <p class="text-xs text-gray-500 mt-2">
                        💡 Izinkan akses kamera saat diminta oleh browser
                    </p>
                </div>

                <!-- QR Scanner Container (Hidden by default) -->
                <div id="qr-scanner-container" class="hidden">
                    <div class="border-2 border-dashed border-crimson rounded-lg p-6 bg-gray-50">
                        
                        <!-- QR Reader Container -->
                        <div id="qr-reader" class="mx-auto rounded-lg overflow-hidden shadow-lg" style="max-width: 500px;"></div>
                        
                        <!-- Success Message (Hidden by default) -->
                        <div id="scan-success" class="hidden mt-4 p-4 bg-green-100 border border-green-300 rounded-lg text-center">
                            <i class="fas fa-check-circle text-green-600 text-2xl mb-2"></i>
                            <p class="text-green-800 font-semibold">QR Code Terdeteksi!</p>
                            <p class="text-green-700 text-sm">Memproses data...</p>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <button type="button" 
                                    id="closeScanner"
                                    onclick="stopScanner(); document.getElementById('qr-scanner-container').classList.add('hidden');" 
                                    class="text-red-600 hover:text-red-800 font-semibold text-sm">
                                <i class="fas fa-times-circle mr-1"></i>Tutup Scanner
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(request('code'))
            @if($borrowing)
                <!-- Borrowing Details -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Status Banner -->
                    <div class="px-6 py-4 
                        {{ $borrowing->status == 'pending' ? 'bg-yellow-50 border-l-4 border-yellow-500' : '' }}
                        {{ $borrowing->status == 'approved' ? 'bg-green-50 border-l-4 border-green-500' : '' }}
                        {{ $borrowing->status == 'rejected' ? 'bg-red-50 border-l-4 border-red-500' : '' }}
                        {{ $borrowing->status == 'returned' ? 'bg-gray-50 border-l-4 border-gray-500' : '' }}">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">{{ $borrowing->code_number }}</h2>
                                <p class="text-gray-600">Status: 
                                    <span class="font-semibold
                                        {{ $borrowing->status == 'pending' ? 'text-yellow-600' : '' }}
                                        {{ $borrowing->status == 'approved' ? 'text-green-600' : '' }}
                                        {{ $borrowing->status == 'rejected' ? 'text-red-600' : '' }}
                                        {{ $borrowing->status == 'returned' ? 'text-gray-600' : '' }}">
                                        {{ strtoupper($borrowing->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="text-6xl
                                {{ $borrowing->status == 'pending' ? 'text-yellow-500' : '' }}
                                {{ $borrowing->status == 'approved' ? 'text-green-500' : '' }}
                                {{ $borrowing->status == 'rejected' ? 'text-red-500' : '' }}
                                {{ $borrowing->status == 'returned' ? 'text-gray-500' : '' }}">
                                <i class="fas 
                                    {{ $borrowing->status == 'pending' ? 'fa-hourglass-half' : '' }}
                                    {{ $borrowing->status == 'approved' ? 'fa-check-circle' : '' }}
                                    {{ $borrowing->status == 'rejected' ? 'fa-times-circle' : '' }}
                                    {{ $borrowing->status == 'returned' ? 'fa-undo' : '' }}"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Borrower Info -->
                            <div>
                                <h3 class="font-bold text-gray-800 mb-4 text-lg border-b pb-2">Informasi Peminjam</h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-600">Nama Lengkap</p>
                                        <p class="font-semibold">{{ $borrowing->borrower_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">No. Telepon</p>
                                        <p class="font-semibold">{{ $borrowing->phone }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Organisasi</p>
                                        <p class="font-semibold">{{ $borrowing->organization ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Borrowing Info -->
                            <div>
                                <h3 class="font-bold text-gray-800 mb-4 text-lg border-b pb-2">Informasi Peminjaman</h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-600">Tanggal Pinjam</p>
                                        <p class="font-semibold">{{ $borrowing->borrow_date->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Tanggal Kembali</p>
                                        <p class="font-semibold">{{ $borrowing->return_date->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Durasi</p>
                                        <p class="font-semibold">{{ $borrowing->total_days }} hari</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Total Biaya</p>
                                        <p class="font-semibold text-crimson text-lg">Rp {{ number_format($borrowing->total_cost, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items -->
                        <div class="mb-6">
                            <h3 class="font-bold text-gray-800 mb-4 text-lg border-b pb-2">Barang yang Dipinjam</h3>
                            <div class="space-y-3">
                                @foreach($borrowing->borrowingItems as $item)
                                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            @if($item->item->photo)
                                                <img src="{{ asset('storage/' . $item->item->photo) }}" alt="{{ $item->item->name }}" class="w-16 h-16 object-cover rounded">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                    <i class="fas fa-box text-gray-400 text-2xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-800">{{ $item->item->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $item->item->code }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-800">{{ $item->quantity }} unit</p>
                                            <p class="text-sm text-gray-600">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}/hari</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Purpose -->
                        <div class="mb-6">
                            <h3 class="font-bold text-gray-800 mb-2">Keperluan</h3>
                            <p class="text-gray-600 bg-gray-50 p-4 rounded-lg">{{ $borrowing->purpose }}</p>
                        </div>

                        @if($borrowing->admin_notes)
                        <!-- Admin Notes -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-bold text-blue-800 mb-2">
                                <i class="fas fa-comment-alt mr-2"></i>Catatan Admin
                            </h3>
                            <p class="text-blue-900">{{ $borrowing->admin_notes }}</p>
                        </div>
                        @endif

                        @if($borrowing->status == 'approved' && $borrowing->approver)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-4">
                            <p class="text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                Disetujui oleh {{ $borrowing->approver->name }} pada {{ $borrowing->approved_at->format('d F Y, H:i') }} WIB
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Timeline -->
                    <div class="bg-gray-50 px-6 py-4">
                        <h3 class="font-bold text-gray-800 mb-4">Timeline</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-xs mr-3 text-blue-500"></i>
                                <span>Diajukan pada {{ $borrowing->created_at->format('d F Y, H:i') }} WIB</span>
                            </div>
                            @if($borrowing->approved_at)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-xs mr-3 text-green-500"></i>
                                <span>Disetujui pada {{ $borrowing->approved_at->format('d F Y, H:i') }} WIB</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            @else
                <!-- Not Found -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Peminjaman Tidak Ditemukan</h2>
                    <p class="text-gray-600 mb-6">Kode peminjaman "{{ request('code') }}" tidak ditemukan dalam sistem.</p>
                    <p class="text-sm text-gray-500">Pastikan Anda memasukkan kode yang benar atau hubungi admin jika ada masalah.</p>
                </div>
            @endif
        @else
            <!-- Info Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="font-bold text-blue-800 mb-3">
                    <i class="fas fa-info-circle mr-2"></i>Informasi
                </h3>
                <ul class="text-blue-900 space-y-2 text-sm">
                    <li><i class="fas fa-check mr-2"></i>Kode peminjaman dikirimkan setelah checkout berhasil</li>
                    <li><i class="fas fa-check mr-2"></i>Anda dapat menyimpan QR Code untuk tracking lebih mudah</li>
                    <li><i class="fas fa-check mr-2"></i>Status akan diupdate secara real-time oleh admin</li>
                </ul>
            </div>
        @endif
    </div>
</div>

<!-- Include html5-qrcode library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    let html5QrCode = null;
    let isScanning = false;

    function toggleQRScanner() {
        const container = document.getElementById('qr-scanner-container');
        
        if (container.classList.contains('hidden')) {
            container.classList.remove('hidden');
            startScanner();
        } else {
            container.classList.add('hidden');
            stopScanner();
        }
    }

    async function startScanner() {
        if (isScanning) {
            console.log("Scanner already running");
            return;
        }
        
        try {
            // Clear previous instance if exists
            if (html5QrCode) {
                try {
                    await html5QrCode.stop();
                    html5QrCode.clear();
                } catch (e) {
                    console.log("Clearing previous scanner:", e);
                }
            }
            
            html5QrCode = new Html5Qrcode("qr-reader");
            isScanning = true;
            
            console.log("🎥 Requesting camera access...");
            
            // Get all available cameras
            const cameras = await Html5Qrcode.getCameras();
            console.log("📷 Available cameras:", cameras.length);
            
            if (cameras && cameras.length > 0) {
                // Try to use back camera (environment facing)
                let cameraId = cameras[0].id;
                
                // Find back/rear/environment camera
                for (let camera of cameras) {
                    const label = camera.label.toLowerCase();
                    if (label.includes('back') || 
                        label.includes('rear') ||
                        label.includes('environment')) {
                        cameraId = camera.id;
                        console.log("📱 Using back camera:", camera.label);
                        break;
                    }
                }
                
                // If multiple cameras, prefer last one (usually back camera)
                if (cameras.length > 1 && cameraId === cameras[0].id) {
                    cameraId = cameras[cameras.length - 1].id;
                }
                
                // Configuration optimized for QR code scanning
                const config = {
                    fps: 10,    // 10 frames per second is optimal
                    qrbox: function(viewfinderWidth, viewfinderHeight) {
                        // Create a square scanning box
                        let minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                        let qrboxSize = Math.floor(minEdge * 0.8); // 80% of viewport
                        return {
                            width: qrboxSize,
                            height: qrboxSize
                        };
                    },
                    aspectRatio: 1.0,
                    disableFlip: false,
                    // Important: This ensures better detection
                    formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE]
                };
                
                // Start the scanner
                await html5QrCode.start(
                    { facingMode: "environment" }, // Use back camera
                    config,
                    onScanSuccess,
                    onScanError
                );
                
                console.log("✅ Scanner started! Ready to scan QR codes");
          
                
            } else {
                throw new Error("No cameras found on this device");
            }
            
        } catch (error) {
            console.error("❌ Error starting scanner:", error);
            isScanning = false;
            
            // User-friendly error messages
            let errorMsg = "⚠️ Tidak dapat mengakses kamera\n\n";
            
            if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
                errorMsg += "❌ Izin kamera ditolak\n\n";
                errorMsg += "Cara mengatasinya:\n";
                errorMsg += "1. Klik ikon 🔒 atau ⓘ di address bar\n";
                errorMsg += "2. Cari 'Camera' atau 'Kamera'\n";
                errorMsg += "3. Ubah ke 'Allow' atau 'Izinkan'\n";
                errorMsg += "4. Refresh halaman (F5)";
            } else if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
                errorMsg += "❌ Kamera tidak ditemukan\n\n";
                errorMsg += "Pastikan:\n";
                errorMsg += "• Perangkat memiliki kamera\n";
                errorMsg += "• Kamera tidak digunakan aplikasi lain\n";
                errorMsg += "• Driver kamera terinstal dengan baik";
            } else if (error.name === 'NotReadableError' || error.name === 'TrackStartError') {
                errorMsg += "❌ Kamera sedang digunakan aplikasi lain\n\n";
                errorMsg += "Tutup aplikasi yang menggunakan kamera:\n";
                errorMsg += "• Zoom, Teams, Skype\n";
                errorMsg += "• Tab browser lain\n";
                errorMsg += "• Aplikasi kamera lainnya";
            } else if (error.name === 'NotSupportedError') {
                errorMsg += "❌ Browser tidak mendukung\n\n";
                errorMsg += "Gunakan browser modern:\n";
                errorMsg += "• Google Chrome (recommended)\n";
                errorMsg += "• Mozilla Firefox\n";
                errorMsg += "• Microsoft Edge";
            } else {
                errorMsg += "Error: " + (error.message || error);
                errorMsg += "\n\nSilakan gunakan input manual atau coba lagi.";
            }
            
            alert(errorMsg);
            document.getElementById('qr-scanner-container').classList.add('hidden');
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        console.log("🎉 QR CODE DETECTED!");
        console.log("📱 Decoded Text:", decodedText);
        console.log("📊 Full Result:", decodedResult);
        
        // Stop scanner immediately to prevent multiple scans
        stopScanner();
        
        // Visual and haptic feedback
        if (navigator.vibrate) {
            navigator.vibrate([200, 100, 200]); // Triple vibration pattern
        }
        
        // Show success message
        const successDiv = document.getElementById('scan-success');
        successDiv.classList.remove('hidden');
        
        
        
        // Visual feedback on reader
        const reader = document.getElementById('qr-reader');
        if (reader) {
            reader.style.border = '4px solid #10b981';
            reader.style.boxShadow = '0 0 20px rgba(16, 185, 129, 0.5)';
        }
        
        // Extract the code (handle both URL and direct code)
        let extractedCode = decodedText;
        
        // If it's a URL, extract the code parameter
        try {
            const url = new URL(decodedText);
            const codeParam = url.searchParams.get('code');
            if (codeParam) {
                extractedCode = codeParam;
                console.log("📋 Extracted code from URL:", extractedCode);
            }
        } catch (e) {
            // Not a URL, use the text as is
            console.log("📋 Using direct code:", extractedCode);
        }
        
        // Fill the input field with extracted code
        const codeInput = document.getElementById('code');
        codeInput.value = extractedCode;
        
        // Highlight the input field
        codeInput.style.backgroundColor = '#d1fae5';
        codeInput.style.transition = 'background-color 0.3s';
        
        console.log("✅ Code inserted into field:", extractedCode);
        console.log("🚀 Auto-submitting form in 1 second...");
        
        // Auto-submit the form after showing success message
        setTimeout(() => {
            console.log("📤 Submitting form now...");
            document.getElementById('trackingForm').submit();
        }, 1000);
    }

    function onScanError(errorMessage) {
        // This is called continuously while scanning
        // Only log actual errors, not "QR code not found" which is normal
        if (errorMessage && 
            !errorMessage.includes('NotFoundException') && 
            !errorMessage.includes('No MultiFormat Readers')) {
            console.log("⚠️ Scan error:", errorMessage);
        }
    }

    async function stopScanner() {
        if (html5QrCode && isScanning) {
            try {
                await html5QrCode.stop();
                console.log("⏹️ Scanner stopped");
                html5QrCode.clear();
                html5QrCode = null;
                isScanning = false;
                
            } catch (err) {
                console.error("❌ Error stopping scanner:", err);
                html5QrCode = null;
                isScanning = false;
            }
        } else {
            isScanning = false;
        }
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (isScanning) {
            stopScanner();
        }
    });

    // Stop scanner when tab becomes hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden && isScanning) {
            console.log("👋 Tab hidden, stopping scanner...");
            stopScanner();
            document.getElementById('qr-scanner-container').classList.add('hidden');
        }
    });

    // Reset input field styling when user types
    document.getElementById('code').addEventListener('input', function() {
        this.style.backgroundColor = '';
    });
</script>

<style>
    /* Custom styles for QR scanner */
    #qr-reader {
        border: 3px solid #dc2626;
    }

    #qr-reader video {
        border-radius: 0.5rem;
    }

    /* Hide default QR scanner border */
    #qr-reader__dashboard_section_csr {
        display: none !important;
    }

    /* Style the scan region */
    #qr-reader__scan_region {
        border-radius: 0.5rem !important;
    }
</style>
@endsection