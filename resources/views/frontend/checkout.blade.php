<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Cafe Senja</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            background-image: url('https://png.pngtree.com/thumb_back/fw800/background/20231024/pngtree-aesthetic-blend-roasted-coffee-beans-atop-a-weathered-concrete-surface-image_13690854.png');
            background-size: 100% 100vh; 
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0; 
            height: 100vh; 
        }
    </style>
</head>

<body class="from-gray-200 via-gray-300 to-gray-400 min-h-screen flex flex-col items-center">
    
    <!-- Header at the top of the page -->
    <header class="bg-gradient-to-br from-[#4b2c01]/50 to-[#8B4513]/50 text-white py-4 text-center w-full">
        <button onclick="window.location.href='/'" class="font-bold text-5xl text-shadow-lg mb-4 focus:outline-none hover:bg-opacity-80 transition duration-300 p-2 rounded">
            Cafe Senja
        </button>
    </header>

    <!-- Main container centered on the page -->
    <div class="w-full max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-xl mt-8">
        <h1 class="text-3xl font-serif text-primary text-center mb-8">
            <i class="fas fa-shopping-bag me-2"></i> Checkout
        </h1>

        <div class="bg-gradient-to-r from-white to-gray-100 p-6 rounded-xl border border-gray-200 mb-8">
            <h2 class="text-2xl text-secondary font-serif mb-6">
                <i class="fas fa-receipt me-2"></i> Ringkasan Pesanan
            </h2>
            <div id="orderItems" class="space-y-4"></div>
            <div class="flex justify-between border-t pt-4">
                <span class="text-lg font-semibold">Total:</span>
                <span id="orderTotal" class="text-lg font-semibold">Rp 0</span>
            </div>
        </div>

        <form id="checkoutForm">
            <div class="space-y-6">
                <div class="form-group">
                    <label for="name" class="text-lg font-medium text-text mb-2">
                        <i class="fas fa-user me-2"></i> Nama:
                    </label>
                    <input type="text" id="name" name="name" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" required placeholder="Masukkan nama lengkap">
                </div>
 
                <div class="form-group">
                    <label for="phone" class="text-lg font-medium text-text mb-2">
                        <i class="fas fa-chair me-2"></i> No. meja:
                    </label>
                    <input type="number" id="no_meja" name="no_meja" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" required placeholder="Masukkan nomor telepon">
                </div>


                <div class="form-group">
                    <label for="paymentMethod" class="text-lg font-medium text-text mb-2">
                        <i class="fas fa-credit-card me-2"></i> Metode Pembayaran:
                    </label>
                    <select id="paymentMethod" name="paymentMethod" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" required>
                        <option value="">Pilih Metode Pembayaran</option>
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Transfer Bank</option>
                        <option value="e_wallet">E-Wallet</option>
                    </select>
                </div>

                <!-- Modal untuk metode pembayaran -->
<div id="paymentMethodModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 mx-auto">
        <h2 class="text-xl font-bold mb-4">Metode Pembayaran</h2>
        
        <div id="bankTransferForm" class="hidden">
            <label class="block mb-2">Nama Bank:</label>
            <input type="text" id="bankName" name="bankName" class="w-full p-2 border rounded mb-3">
            
            <label class="block mb-2">Nomor Rekening:</label>
            <input type="text" id="accountNumber" name="accountNumber" class="w-full p-2 border rounded">
        </div>
        
        <div id="eWalletForm" class="hidden">
            <label class="block mb-2">Provider E-Wallet:</label>
            <select id="eWalletProvider" name="eWalletProvider" class="w-full p-2 border rounded mb-3">
                <option value="">Pilih Provider</option>
                <option value="gopay">Gopay</option>
                <option value="ovo">OVO</option>
                <option value="dana">DANA</option>
                <option value="linkaja">LinkAja</option>
            </select>
            
            <label class="block mb-2">Nomor E-Wallet:</label>
            <input type="text" id="eWalletNumber" name="eWalletNumber" class="w-full p-2 border rounded">
        </div>
        
        <div class="flex justify-end mt-4">
            <button type="button" id="closeModal" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
            <button type="button" id="savePayment" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
        </div>
    </div>
</div>

<button type="submit" class="w-full p-4 bg-gradient-to-br from-[#4b2c01] to-[#8B4513] text-white rounded-full text-lg font-medium shadow-lg transform transition-all duration-300 hover:translate-y-[-2px]">
                    Konfirmasi Pesanan
                </button>
            </div>
        </form>

    </div>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const checkoutData = JSON.parse(localStorage.getItem('checkoutData'));
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
        const totalWithShipping = subtotal;

        orderTotalElement.innerText = `Rp ${totalWithShipping.toLocaleString('id-ID')}`;
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

            let subtotal = checkoutData.items.reduce((total, item) => {
                return total + (calculateItemPrice(item.harga, item.size) * item.quantity);
            }, 0);

            const totalWithShipping = subtotal;

            const orderData = {
                name,
                no_meja,
                paymentDetails,
                items: checkoutData.items,
                subtotal,
                total: totalWithShipping
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