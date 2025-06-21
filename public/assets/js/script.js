// public/assets/js/script.js

document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk memperbarui tanggal akhir minimal pada form pemesanan
    var rentalStartDateInputs = document.querySelectorAll('input[name="rental_start_date"]');
    if (rentalStartDateInputs) {
        rentalStartDateInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                var startDate = this.value;
                var endDateInputId = this.id.replace('rental_start_date', 'rental_end_date');
                var endDateInput = document.getElementById(endDateInputId);

                if (endDateInput) {
                    endDateInput.min = startDate;
                    if (endDateInput.value < startDate) {
                        endDateInput.value = startDate;
                    }
                }
            });
        });
    }

    // Contoh validasi form sederhana sebelum submit (opsional, PHP juga harus validasi)
    var orderForms = document.querySelectorAll('form[name="orderForm"]');
    if (orderForms) {
        orderForms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                var emailInput = form.querySelector('input[name="customer_email"]');
                if (emailInput && !emailInput.value.includes('@')) {
                    alert('Format email tidak valid. Harap masukkan email yang benar.');
                    event.preventDefault();
                }
            });
        });
    }

    // Fungsi untuk format angka pemisah ribuan otomatis (untuk Rupiah)
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah   = split[0].substr(0, sisa),
            ribuan   = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }

    // Ambil input harga sewa di halaman add.php dan edit.php admin
    var rentalPriceInputs = document.querySelectorAll('input[name="rental_price"]');
    
    if (rentalPriceInputs) {
        rentalPriceInputs.forEach(function(input) {
            input.addEventListener('keyup', function(e) {
                if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight' && e.key !== 'Delete' && e.key !== 'Backspace') {
                    this.value = formatRupiah(this.value);
                }
            });

            input.addEventListener('blur', function() {
                this.setAttribute('data-pure-value', this.value.replace(/\./g, '').replace(/,/g, '.'));
                this.value = formatRupiah(this.value);
            });

            if (this.value) {
                this.value = formatRupiah(this.value.replace(/\./g, '').replace(/,/g, '.'));
            }
        });

        const priceForms = document.querySelectorAll('form');
        priceForms.forEach(form => {
            const priceInput = form.querySelector('input[name="rental_price"]');
            if (priceInput) {
                form.addEventListener('submit', function() {
                    if (priceInput.hasAttribute('data-pure-value')) {
                        priceInput.value = priceInput.getAttribute('data-pure-value');
                    } else {
                        priceInput.value = priceInput.value.replace(/\./g, '').replace(/,/g, '.');
                    }
                });
            }
        });
    }

    var buttons = document.querySelectorAll('.btn');
    if (buttons) {
        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                this.classList.add('active');
                setTimeout(() => {
                    this.classList.remove('active');
                }, 300);
            });
        });
    }

    if (typeof Swal !== 'undefined') {
        const deleteForms = document.querySelectorAll('form.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                let itemType = 'item ini';
                if (this.querySelector('button[name="delete_motorcycle"]')) {
                    itemType = 'motor ini';
                } else if (this.querySelector('button[name="delete_profile"]')) {
                    itemType = 'profil ini';
                }

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda tidak akan dapat mengembalikan ${itemType}!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); 
                    }
                });
            });
        });
    } else {
        const fallbackDeleteForms = document.querySelectorAll('form.delete-form');
        fallbackDeleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                let itemType = 'item ini';
                if (this.querySelector('button[name="delete_motorcycle"]')) {
                    itemType = 'motor ini';
                } else if (this.querySelector('button[name="delete_profile"]')) {
                    itemType = 'profil ini';
                }
                
                if (!confirm(`Apakah Anda yakin ingin menghapus ${itemType}?`)) {
                    e.preventDefault();
                }
            });
        });
    }
});