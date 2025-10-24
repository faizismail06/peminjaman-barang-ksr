@extends('layouts.app')

@section('title', 'Permohonan Berhasil Dikirim')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-3xl mx-auto text-center">
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

        @if($borrowing)
        <!-- Booking Code & QR Code Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Kode Peminjaman Anda</h2>
            
            <!-- Code Number -->
            <div class="bg-gradient-to-r from-crimson to-maroon rounded-lg p-6 mb-6">
                <p class="text-sm mb-2 opacity-90">Nomor Peminjaman</p>
                <p class="text-3xl font-bold tracking-wider">{{ $borrowing->code_number }}</p>
            </div>

            <!-- QR Code -->
            <div class="mb-6">
                <p class="text-gray-600 mb-4">Simpan QR Code ini untuk tracking peminjaman</p>
                <div class="inline-block bg-white p-4 rounded-lg shadow-md">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($borrowing->code_number) }}" 
                         alt="QR Code" 
                         class="w-48 h-48 mx-auto">
                </div>
            </div>

            <!-- Download/Print Buttons -->
            <div class="flex justify-center space-x-4 mb-6">
                <button onclick="printQR()" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                    <i class="fas fa-print mr-2"></i>Print QR Code
                </button>
                <button onclick="downloadQR()" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                    <i class="fas fa-download mr-2"></i>Download QR
                </button>
            </div>

            <!-- Borrowing Details -->
            <div class="border-t pt-6 text-left">
                <h3 class="font-bold text-gray-800 mb-4">Detail Peminjaman</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Nama Peminjam</p>
                        <p class="font-semibold">{{ $borrowing->borrower_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">No. Telepon</p>
                        <p class="font-semibold">{{ $borrowing->phone }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Tanggal Pinjam</p>
                        <p class="font-semibold">{{ $borrowing->borrow_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Tanggal Kembali</p>
                        <p class="font-semibold">{{ $borrowing->return_date->format('d M Y') }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-600 mb-2">Barang yang Dipinjam</p>
                        <ul class="space-y-1">
                            @foreach($borrowing->borrowingItems as $item)
                                <li class="font-semibold">• {{ $item->item->name }} ({{ $item->quantity }} unit)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

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
            <a href="{{ route('borrowings.track') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-300 font-semibold">
                <i class="fas fa-search mr-2"></i>Cek Status Peminjaman
            </a>
            <a href="{{ route('katalog') }}" class="bg-crimson text-white px-6 py-3 rounded-lg hover:bg-maroon transition duration-300 font-semibold">
                <i class="fas fa-box mr-2"></i>Lihat Katalog Lainnya
            </a>
        </div>
    </div>
</div>

<!-- Hidden Canvas for QR Generation -->
<canvas id="qrCanvas" style="display: none;"></canvas>

<script>
async function downloadQR() {
    const codeNumber = '{{ $borrowing ? $borrowing->code_number : '' }}';
    const borrowerName = '{{ $borrowing ? $borrowing->borrower_name : '' }}';
    const borrowDate = '{{ $borrowing ? $borrowing->borrow_date->format("d M Y") : '' }}';
    const returnDate = '{{ $borrowing ? $borrowing->return_date->format("d M Y") : '' }}';
    
    // Show loading indicator
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generating...';
    btn.disabled = true;
    
    try {
        // Create canvas
        const canvas = document.getElementById('qrCanvas');
        const ctx = canvas.getContext('2d');
        
        // Set canvas size (larger for better quality and spacing)
        const width = 800;
        const height = 1100;
        canvas.width = width;
        canvas.height = height;
        
        // Background - White
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(0, 0, width, height);
        
        // Header Background - Crimson
        ctx.fillStyle = '#DC143C';
        ctx.fillRect(0, 0, width, 150);
        
        // Header Text - White
        ctx.fillStyle = '#FFFFFF';
        ctx.font = 'bold 36px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('KSR PMI POLINES', width / 2, 60);
        
        ctx.font = '24px Arial';
        ctx.fillText('Kode Peminjaman Barang', width / 2, 100);
        
        // Code Number - Large and centered
        ctx.fillStyle = '#333333';
        ctx.font = 'bold 48px Arial';
        ctx.fillText(codeNumber, width / 2, 230);
        
        // Separator line after code number with more spacing
        ctx.strokeStyle = '#CCCCCC';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(100, 290);
        ctx.lineTo(700, 290);
        ctx.stroke();
        
        // Load QR Code image
        const qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=' + encodeURIComponent(codeNumber);
        const qrImage = await loadImage(qrUrl);
        
        // Draw QR Code with white padding
        const qrSize = 400;
        const qrX = (width - qrSize) / 2;
        const qrY = 350; // Increased spacing from code number
        
        // White background for QR
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(qrX - 20, qrY - 20, qrSize + 40, qrSize + 40);
        
        // Border around QR
        ctx.strokeStyle = '#DC143C';
        ctx.lineWidth = 3;
        ctx.strokeRect(qrX - 20, qrY - 20, qrSize + 40, qrSize + 40);
        
        // Draw QR Code
        ctx.drawImage(qrImage, qrX, qrY, qrSize, qrSize);
        
        // Details section with better spacing
        const detailsY = 850;
        const labelX = 120;
        const valueX = 320;
        const lineHeight = 50;
        
        ctx.fillStyle = '#333333';
        ctx.textAlign = 'left';
        
        // Borrower name
        ctx.font = 'bold 22px Arial';
        ctx.fillText('Peminjam:', labelX, detailsY);
        ctx.font = '22px Arial';
        ctx.fillText(borrowerName, valueX, detailsY);
        
        // Borrow date
        ctx.font = 'bold 22px Arial';
        ctx.fillText('Tanggal Pinjam:', labelX, detailsY + lineHeight);
        ctx.font = '22px Arial';
        ctx.fillText(borrowDate, valueX, detailsY + lineHeight);
        
        // Return date
        ctx.font = 'bold 22px Arial';
        ctx.fillText('Tanggal Kembali:', labelX, detailsY + (lineHeight * 2));
        ctx.font = '22px Arial';
        ctx.fillText(returnDate, valueX, detailsY + (lineHeight * 2));
        
        // Footer - Instructions with adjusted position
        ctx.fillStyle = '#666666';
        ctx.font = 'italic 16px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('Simpan QR Code ini untuk tracking peminjaman Anda', width / 2, 1020);
        ctx.fillText('Scan di halaman "Cek Status Peminjaman"', width / 2, 1050);
        
        // Convert canvas to blob and download
        canvas.toBlob(function(blob) {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'QR-Peminjaman-' + codeNumber + '.png';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            
            // Reset button
            btn.innerHTML = originalHTML;
            btn.disabled = false;
            
            // Show success message
            showNotification('QR Code berhasil didownload!', 'success');
        }, 'image/png', 1.0);
        
    } catch (err) {
        console.error('Error generating QR code:', err);
        
        // Reset button
        btn.innerHTML = originalHTML;
        btn.disabled = false;
        
        // Show error message
        showNotification('Gagal generate QR Code. Silakan coba lagi.', 'error');
    }
}

// Helper function to load image
function loadImage(url) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = () => resolve(img);
        img.onerror = reject;
        img.src = url;
    });
}

// Show notification
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white font-semibold z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle mr-2"></i>
        ${message}
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function printQR() {
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Print QR Code - {{ $borrowing ? $borrowing->code_number : '' }}</title>
            <style>
                @page {
                    margin: 20mm;
                }
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    padding: 40px;
                    background: white;
                }
                .header {
                    background: #DC143C;
                    color: white;
                    padding: 30px;
                    margin: -40px -40px 15px -40px;
                    border-radius: 0;
                }
                .header h1 {
                    margin: 0 0 10px 0;
                    font-size: 32px;
                }
                .header h2 {
                    margin: 0;
                    font-size: 20px;
                    font-weight: normal;
                }
                .code {
                    font-size: 36px;
                    font-weight: bold;
                    margin: 10px 0;
                    color: #333;
                    letter-spacing: 2px;
                }
                .qr-container {
                    background: white;
                    padding: 30px;
                    border: 3px solid #DC143C;
                    display: inline-block;
                    margin: 20px 0;
                    border-radius: 10px;
                }
                .qr-container img {
                    display: block;
                }
              .info {
                    margin: 20px 0;
                    background: #f8f9fa;
                    padding: 20px;
                    border-radius: 10px;
                    border-left: 5px solid #DC143C;
                }
                .info p {
                    margin: 10px 0;
                    font-size: 16px;
                    text-align: left;
                }
                .info strong {
                    display: inline-block;
                    width: 180px;
                    color: #333;
                }
                .footer {
                    margin-top: 40px;
                    padding-top: 20px;
                    border-top: 2px solid #ddd;
                    color: #666;
                    font-size: 14px;
                    font-style: italic;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>KSR PMI POLINES</h1>
                <h2>Kode Peminjaman Barang</h2>
            </div>
            
            <div class="code">{{ $borrowing ? $borrowing->code_number : '' }}</div>
            
            <div class="qr-container">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ $borrowing ? urlencode($borrowing->code_number) : '' }}" alt="QR Code">
            </div>
            
            @if($borrowing)
            <div class="info">
                <p><strong>Nama Peminjam:</strong> {{ $borrowing->borrower_name }}</p>
                <p><strong>No. Telepon:</strong> {{ $borrowing->phone }}</p>
                <p><strong>Tanggal Pinjam:</strong> {{ $borrowing->borrow_date->format('d F Y') }}</p>
                <p><strong>Tanggal Kembali:</strong> {{ $borrowing->return_date->format('d F Y') }}</p>
                <p><strong>Durasi:</strong> {{ $borrowing->total_days }} hari</p>
            </div>
            @endif
            
            <div class="footer">
                <p>Simpan dokumen ini sebagai bukti peminjaman</p>
                <p>Scan QR Code di halaman "Cek Status Peminjaman" untuk tracking</p>
                <p>Hubungi: (024) 7473417 | info@ksrpmipolines.ac.id</p>
            </div>
            
            <script>
                window.onload = function() {
                    setTimeout(() => {
                        window.print();
                        window.onafterprint = () => window.close();
                    }, 500);
                }
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>
@endsection