<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Coffe Shop</title>

        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #8D6E63; }
        .bg-brown { background-color: #4E342E; }
        .bg-accent { background-color: #03a9f4; }
        .delete-item {  color: #FF0000; }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .card { transition: transform 0.3s; }
        .card:hover { transform: scale(1.05); box-shadow: 0 10px 15px rgba(0, 0, 0, 0, 2); }
    </style>
    </head>
    <body class="antialiased">

     navbar
        <nav class="bg-brown p-4">
            <div class="container mx-auto flex items-center justify-between">
                <a href="/" class="text-white text-3xl font-bold flex items-center">
                    <i class="fas fa-coffee mr-2"></i>
                    Coffe Shop
                </a>
                <button id="cart-button" class="relative bg-accent text-white py-2 px-5 rounded-lg flex items-center shadow-lg transition hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                <i class="fas fa-shopping-cart text-lg mr-2"></i>
                <span id="total-price-display">Total: Rp 0</span>
            </button>
            </div>
        </nav>

 // content
 <div class="flex items-center justify-center min-h-screen py-4">
    <div class="container mx-auto p-5">
// menu
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($menus as $menu)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden card">
                        <a href="{{ route('menu.show', $menu->id) }}">
                            <img src="{{ asset('storage/menus/' . $menu->image) }}" alt="{{ $menu->nama_menu }}" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-gray-800">{{ $menu->nama_menu }}</h2>
                            <p class="text-lg font-semibold text-gray-600 mt-2">Rp {{ number_format($menu->harga, 2) }}</p>
                            <div class="mt-4 flex items-center">
                                <button class="decrement-button bg-red-500 text-gray-800 px-2 py-1 rounded-1">-</button>
                                <input type="number" class="quantity-input border-t border-b border-gray-300 text-center w-12" value="0" min="1" readonly>
                                <button class="increment-button bg-blue-500 taxt-gray-800 px-2 py-1 rounded-r">+</button>
                            </div>
                            <div class="mt-4">
                                <select class="size-select border border-gray-300 rounded px-4 py-2 w-full mb-3 text-gray-700">
                                    <option value="" data-price="0">Pilih Ukuran</option>
                                    <option value="Kecil" data-price="{{ $menu->harga }}">Kecil - Rp {{ number_format($menu->harga, 2) }}</option>
                                    <option value="Sedang" data-price="{{ $menu->harga + 2500 }}">Sedang - Rp {{ number_format($menu->harga + 2500, 2) }}</option>
                                    <option value="Besar" data-price="{{ $menu->harga + 5000 }}">Besar - Rp {{ number_format($menu->harga + 5000, 2) }}</option>
                                </select>
                                <button class="bg-accent text-white px-4 py-2 rounded-lg w-full order-button hover:bg-blue-700 transition mt-2" data-name="{{ $menu->nama_menu }}">Pesan</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>
 </div>
  //Modal
 <div id="cartModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 class="text-2xl font-bold mb-4">Keranjang Belanja</h2>
                <div id="cartItems"></div>
                <div class="mt-4">
                    <strong>Total: <span id="modalTotalPrice"></span></strong>
                </div>
                <a href="{{url('/checkout')}}"><button id="checkoutButton" class="mt-4 bg-accent text-white px-4 py-2 rounded-lg w-full hover:bg-blue-700 transition">Checkout</button></a>
            </div>
        </div>
 <script>
        let totalPrice = 0;
        let cartItems = [];

        $(document).ready(function() {
            $('.increment-button').click(function() {
                let quantityInput = $(this).prev('input.quantity-input');
                let currentValue = parseInt(quantityInput.val());
                quantityInput.val(currentValue + 1);
                updateTotalPrice($(this));
            });

            $('.decrement-button').click(function() {
                let quantityInput = $(this).next('input.quantity-input');
                let currentValue = parseInt(quantityInput.val());
                if (currentValue > 0) {
                    quantityInput.val(currentValue - 1);
                    updateTotalPrice($(this));
                }
            });

            $('.order-button').click(function() {
                let menuName = $(this).data('name');
                let quantityInput = $(this).closest('.card').find('input.quantity-input');
                let quantity = parseInt(quantityInput.val());
                let sizeSelect = $(this).closest('.card').find('select.size-select');
                let sizePrice = sizeSelect.find('option:selected').data('price');
                let totalPriceForItem = quantity * sizePrice;

                cartItems.push({
                    name: menuName,
                    quantity: quantity,
                    price: totalPriceForItem
                });

                totalPrice += totalPriceForItem;
                updateTotalPriceDisplay();
            });

            function updateTotalPrice(button) {
                let card = button.closest('.card');
                let quantityInput = card.find('input.quantity-input');
                let quantity = parseInt(quantityInput.val());
                let sizeSelect = card.find('select.size-select');
                let sizePrice = sizeSelect.find('option:selected').data('price');
                let totalPriceForItem = quantity * sizePrice;

                let existingItemIndex = cartItems.findIndex(item => item.name === card.find('.order-button').data('name'));
                if (existingItemIndex !== -1) {
                    cartItems[existingItemIndex].quantity = quantity;
                    cartItems[existingItemIndex].price = totalPriceForItem;
                } else {
                    cartItems.push({
                        name: card.find('.order-button').data('name'),
                        quantity: quantity,
                        price: totalPriceForItem
                    });
                }

                totalPrice = cartItems.reduce((acc, item) => acc + item.price, 0);
                updateTotalPriceDisplay();
            }

            $('#cart-button').click(function() {
                    showModal();
                });

                // Tambahkan event listener untuk tombol close pada modal
                $('.close').click(function() {
                    hideModal();
                });

                // Tutup modal jika user mengklik di luar modal
                $(window).click(function(event) {
                    if (event.target == document.getElementById('cartModal')) {
                        hideModal();
                    }
                });

                // Event listener untuk tombol checkout
                $('#checkoutButton').click(function() {
                    // Implementasikan logika checkout di sini
                    alert('Checkout berhasil!');
                    hideModal();
                });

                function showModal() {
                    updateModalContent();
                    $('#cartModal').css('display', 'block');
                }

                function hideModal() {
                    $('#cartModal').css('display', 'none');
                }

                function updateModalContent() {
                    let cartItemsHtml = '';
                    cartItems.forEach(item => {
                        cartItemsHtml += `<p>${item.name} - ${item.quantity}x - Rp ${item.price.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>`;
                    });
                    $('#cartItems').html(cartItemsHtml);
                    $('#modalTotalPrice').text(`Rp ${totalPrice.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);
                }

                function updateModalContent() {
                    let cartItemsHtml = '';
                        cartItems.forEach((item, index) => {
                        cartItemsHtml += `
                            <div class="flex justify-between items-center mb-2">
                        <p>${item.name} - ${item.quantity}x - Rp ${item.price.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
                        <button class="delete-item" data-index="${index}">Hapus</button>
                    </div>
                    `;
                    });
                    $('#cartItems').html(cartItemsHtml);
                     $('#modalTotalPrice').text(`Rp ${totalPrice.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);

    // Tambahkan event listener untuk tombol hapus
                    $('.delete-item').click(function() {
                    let index = $(this).data('index');
                    removeItem(index);
                });
                }

                function removeItem(index) {
                let removedItem = cartItems.splice(index, 1)[0];
                totalPrice -= removedItem.price;
                updateModalContent();
                updateTotalPriceDisplay();
                }

                function updateTotalPriceDisplay() {
                    $('#total-price-display').text(`Total: Rp ${totalPrice.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);
                }
            });
    </script>
</body>
</html> -->