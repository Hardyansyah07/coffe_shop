<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - CAFFE BrewTopia
CAFFE BrewTopia
CAF</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
    body {
        background-color: #f3f4f6;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    header button {
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    input:focus, select:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 0 0 2px rgba(139, 69, 19, 0.2);
    }

    #paymentMethodModal {
        backdrop-filter: blur(4px);
    }

    #paymentMethodModal .bg-white {
        transition: transform 0.3s ease;
    }

    #paymentMethodModal.show .bg-white {
        transform: scale(1.05);
    }
</style>

</head>

<body class="from-gray-200 via-gray-300 to-gray-400 min-h-screen flex flex-col items-center">
    
    <!-- Header at the top of the page -->
    <header class="bg-white shadow-md text-[#4b2c01] py-4 text-center w-full">
        <button onclick="window.location.href='/'" class="font-bold text-4xl tracking-tight hover:text-[#8B4513] transition">
            <i class="fas fa-coffee mr-2"></i>CAFFE BrewTopia
        </button>
    </header>

    <!-- Main container centered on the page -->
    <div class="max-w-6xl w-full bg-white p-8 rounded-2xl shadow-lg mt-10 flex flex-col md:flex-row gap-8">
        
            <!-- Bagian kiri: Daftar Pesanan -->
            <div class="w-full md:w-2/3">
                <h2 class="text-2xl font-semibold mb-4">Ringkasan Pesanan</h2>
                <div id="orderItems" class="space-y-4"></div>
            </div>
            <!-- Bagian kanan: Total dan Formulir -->
            <div class="w-full md:w-1/3 bg-gray-100 p-6 rounded-2xl shadow">
                <div class="mb-4 border-b pb-2">
                    <p id="orderTotal" class="text-xl font-bold">Rp 0</p>
                </div>
                
                <form id="checkoutForm" class="space-y-4">
                    <div>
                        <label class="block font-medium">Nama:</label>
                        <input type="text" id="name" name="name" class="w-full p-2 border rounded" required>
                    </div>
                    <div>
                        <label class="block font-medium">No. Meja:</label>
                        <select id="no_meja" name="no_meja" class="w-full p-2 border rounded" required>
                            <option value="" disabled selected>Pilih Nomor Meja</option>
                            @for ($i = 1; $i <= 20; $i++) <!-- Sesuaikan jumlah meja -->
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium">Metode Pembayaran:</label>
                        <select id="paymentMethod" name="paymentMethod" class="w-full p-2 border rounded" required>
                            <option value="">Pilih Metode</option>
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="e_wallet">E-Wallet</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full py-3 bg-[#4b2c01] hover:bg-[#5c3514] text-white rounded-xl text-base font-semibold shadow transition duration-300">
                        Konfirmasi Pesanan
                    </button>
                </form>
            </div>
        </div>
                <!-- Modal untuk metode pembayaran -->
                <div id="paymentMethodModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-96 mx-auto">
                        <h2 class="text-xl font-bold mb-4">Metode Pembayaran</h2>
                        
                        <div id="bankTransferForm" class="hidden">
                            <label class="block mb-2">Nama Bank:</label>
                            <input type="text" id="bankName" name="bankName" class="w-full p-2 border rounded mb-3">
                            
                            <label class="block mb-2">Nomor Rekening:</label>
                            <input type="number" id="accountNumber" name="accountNumber" class="w-full p-2 border rounded">
                        </div>
                        
                        <div id="eWalletForm" class="hidden">
                            <label class="block mb-2">Provider E-Wallet:</label>
                            <select id="eWalletProvider" name="eWalletProvider" class="w-full p-2 border rounded mb-3">
                                <option value="">Pilih Provider</option>
                                <option value="gopay">Gopay</option>
                                <option value="ovo">OVO</option>
                                <option value="dana">DANA</option>
                            </select>
                            
                            <label class="block mb-2">Nomor Handphone:</label>
                            <input type="tel" id="eWalletNumber" name="eWalletNumber" class="w-full p-2 border rounded" value="+62" onfocus="addPrefix()" oninput="preventDeletePrefix()">
                        </div>
                        
                        <div class="flex justify-end mt-4">
                        <button type="button" id="closeModal" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded transition">Batal</button>
                        <button type="button" id="savePayment" class="ml-2 px-4 py-2 bg-[#4b2c01] text-white hover:bg-[#5c3514] rounded transition">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const checkoutData = JSON.parse(localStorage.getItem('checkoutData')) || { items: [] };
    const orderItemsContainer = document.getElementById('orderItems');
    const orderTotalElement = document.getElementById('orderTotal');
    const paymentMethodSelect = document.getElementById('paymentMethod');
    const paymentMethodModal = document.getElementById('paymentMethodModal');
    const bankTransferForm = document.getElementById('bankTransferForm');
    const eWalletForm = document.getElementById('eWalletForm');
    const closeModalButton = document.getElementById('closeModal');
    const savePaymentButton = document.getElementById('savePayment');

    if (checkoutData && checkoutData.items.length > 0) {
    checkoutData.items.forEach(item => {
        const itemElement = document.createElement('div');
        itemElement.className = 'flex justify-between border-b py-2';
        const itemTotal = calculateItemPrice(item.harga, item.size) * item.quantity;
        itemElement.innerHTML = `
            <span>${item.nama} (${item.size}) (x${item.quantity})</span>
            <span>Rp ${itemTotal.toLocaleString('id-ID')}</span>
        `;
        orderItemsContainer.appendChild(itemElement);
    });

    const subtotal = checkoutData.items.reduce((total, item) => {
        return total + (calculateItemPrice(item.harga, item.size) * item.quantity);
    }, 0);

    const tax = subtotal * 0.11; // Pajak 11%
    const totalWithTax = subtotal + tax; // Total setelah pajak

    // Menampilkan ringkasan pesanan dengan pajak di sebelah kiri
    orderTotalElement.innerHTML = `
        <div class="flex justify-between">
            <span>Subtotal:</span>
            <span>Rp ${subtotal.toLocaleString('id-ID')}</span>
        </div>
        <div class="flex justify-between">
            <span>Pajak (11%):</span>
            <span>Rp ${tax.toLocaleString('id-ID')}</span>
        </div>
        <div class="flex justify-between font-bold border-t mt-2 pt-2">
            <span>Total Harga:</span>
            <span>Rp ${totalWithTax.toLocaleString('id-ID')}</span>
        </div>
    `;
} else {
    orderItemsContainer.innerHTML = '<p class="text-red-500">Keranjang belanja kosong!</p>';
}


    function calculateItemPrice(price, size) {
        let adjustedPrice = price;
        switch (size) {
            case 'level 1': adjustedPrice += 1000; break;
            case 'level 2': adjustedPrice += 2000; break;
            case 'sedang': adjustedPrice += 5000; break;
            case 'besar': adjustedPrice += 10000; break;
            default: break;
        }
        return adjustedPrice;
    }

    // MENANGANI PILIHAN METODE PEMBAYARAN
    paymentMethodSelect.addEventListener('change', (e) => {
        const selectedMethod = e.target.value;
        bankTransferForm.style.display = 'none';
        eWalletForm.style.display = 'none';

        if (selectedMethod === 'bank_transfer') {
            bankTransferForm.style.display = 'block';
            paymentMethodModal.style.display = 'flex';
        } else if (selectedMethod === 'e_wallet') {
            eWalletForm.style.display = 'block';
            paymentMethodModal.style.display = 'flex';
        }
    });

    closeModalButton.addEventListener('click', () => {
        paymentMethodModal.style.display = 'none';
        paymentMethodSelect.value = ''; // Reset pilihan
    });

    // MENYIMPAN DATA PEMBAYARAN
    savePaymentButton.addEventListener('click', () => {
        paymentMethodModal.style.display = 'none';
    });

    // MENANGANI FORM CHECKOUT
    document.getElementById('checkoutForm').onsubmit = async (event) => {
        event.preventDefault();

        if (!checkoutData || checkoutData.items.length === 0) {
            alert('Keranjang belanja kosong! Silakan tambahkan item sebelum checkout.');
            return;
        }

        try {
            const name = document.getElementById('name').value;
            const no_meja = document.getElementById('no_meja').value;
            const paymentMethod = paymentMethodSelect.value;

            let paymentDetails = {};

            if (paymentMethod === 'bank_transfer') {
                paymentDetails = {
                    method: 'Bank Transfer',
                    bankName: document.getElementById('bankName').value,
                    accountNumber: document.getElementById('accountNumber').value,
                };
            } else if (paymentMethod === 'e_wallet') {
                paymentDetails = {
                    method: 'E-Wallet',
                    provider: document.getElementById('eWalletProvider').value,
                    number: document.getElementById('eWalletNumber').value,
                };
            }else{
                paymentDetails = {
                    method:'CASH',
                }
            }

            function addPrefix() {
                let input = document.getElementById('eWalletNumber');
                if (!input.value.startsWith('+62')) {
                    input.value = '+62';
                }
            }

            function preventDeletePrefix() {
                let input = document.getElementById('eWalletNumber');
                if (!input.value.startsWith('+62')) {
                    input.value = '+62' + input.value.replace(/[^0-9]/g, '');
                }
            }

            let subtotal = checkoutData.items.reduce((total, item) => {
                return total + (calculateItemPrice(item.harga, item.size) * item.quantity);
            }, 0);

            const tax = subtotal * 0.11; // Pajak 11%
            const totalWithTax = subtotal + tax;

            const orderData = {
                name,
                no_meja,
                paymentDetails,
                items: checkoutData.items,
                subtotal,
                tax,
                total: totalWithTax
            };

            console.log(orderData);

            const response = await fetch('/checkout/confirm', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(orderData)
            });

            const result = await response.json();

            if (result.status === 'success') {
                localStorage.removeItem('checkoutData');
                window.location.href = '/confirmation';
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error('Error saat checkout:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    };
    
});
</script>
</body>
</html>