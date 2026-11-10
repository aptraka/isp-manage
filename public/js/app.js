
document.addEventListener('DOMContentLoaded', function () {

    // Sidebar mobile
    const sidebar = document.querySelector('.sidebar');
    const toggleButton = document.querySelector('.sidebar-toggle');
    const overlay = document.querySelector('.sidebar-overlay');

    function closeSidebar() {
        sidebar?.classList.remove('show');
        overlay?.classList.remove('show');
    }

    toggleButton?.addEventListener('click', function () {
        sidebar?.classList.toggle('show');
        overlay?.classList.toggle('show');
    });

    overlay?.addEventListener('click', closeSidebar);

    sidebar?.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth < 992) {
                closeSidebar();
            }
        });
    });

    // Konfirmasi hapus data
    document.querySelectorAll('.delete-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                event.preventDefault();
            }
        });
    });

    // Menghilangkan notifikasi otomatis
    document.querySelectorAll('.alert:not(.alert-permanent)').forEach(function (alert) {
        setTimeout(function () {
            if (typeof bootstrap !== 'undefined') {
                bootstrap.Alert.getOrCreateInstance(alert).close();
            }
        }, 4000);
    });

    // Format mata uang Rupiah
    document.querySelectorAll('[data-currency]').forEach(function (element) {
        const value = Number(element.dataset.currency);

        if (!Number.isNaN(value)) {
            element.textContent = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(value);
        }
    });

    // Harga paket internet
    const packageSelect = document.querySelector('#package_id');
    const packagePrice = document.querySelector('#package_price');

    packageSelect?.addEventListener('change', function () {
        const selected = packageSelect.options[packageSelect.selectedIndex];

        if (packagePrice && selected.dataset.price) {
            packagePrice.value = new Intl.NumberFormat('id-ID').format(
                Number(selected.dataset.price)
            );
        }
    });

    // Nominal tagihan
    const customerSelect = document.querySelector('#customer_id');
    const invoiceAmount = document.querySelector('#invoice_amount');

    customerSelect?.addEventListener('change', function () {
        const selected = customerSelect.options[customerSelect.selectedIndex];

        if (invoiceAmount && selected.dataset.price) {
            invoiceAmount.value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(Number(selected.dataset.price));
        }
    });

});
