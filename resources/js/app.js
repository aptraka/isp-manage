
document.addEventListener('DOMContentLoaded', function () {

    // =====================================
    // SIDEBAR MOBILE
    // =====================================

    const sidebar = document.querySelector('.sidebar');
    const toggleButton = document.querySelector('.sidebar-toggle');
    const overlay = document.querySelector('.sidebar-overlay');

    function openSidebar() {
        sidebar?.classList.add('show');
        overlay?.classList.add('show');
    }

    function closeSidebar() {
        sidebar?.classList.remove('show');
        overlay?.classList.remove('show');
    }

    toggleButton?.addEventListener('click', function () {
        if (sidebar?.classList.contains('show')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    overlay?.addEventListener('click', closeSidebar);

    sidebar?.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth < 992) {
                closeSidebar();
            }
        });
    });

    // =====================================
    // DELETE CONFIRMATION
    // =====================================

    document.querySelectorAll('.delete-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const confirmed = confirm(
                'Apakah Anda yakin ingin menghapus data ini?'
            );

            if (!confirmed) {
                event.preventDefault();
            }
        });
    });

    // =====================================
    // AUTO HIDE ALERT
    // =====================================

    document.querySelectorAll('.alert:not(.alert-permanent)').forEach(function (alert) {
        setTimeout(function () {
            if (typeof bootstrap !== 'undefined') {
                bootstrap.Alert.getOrCreateInstance(alert).close();
            }
        }, 4000);
    });

    // =====================================
    // FORMAT RUPIAH
    // =====================================

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

    // =====================================
    // CUSTOMER PACKAGE PRICE
    // =====================================

    const packageSelect = document.querySelector('#package_id');
    const packagePrice = document.querySelector('#package_price');

    function updatePackagePrice() {
        if (!packageSelect || !packagePrice) return;

        const selected = packageSelect.options[packageSelect.selectedIndex];

        if (selected?.dataset.price) {
            packagePrice.value = new Intl.NumberFormat('id-ID').format(
                Number(selected.dataset.price)
            );
        }
    }

    packageSelect?.addEventListener('change', updatePackagePrice);

    // =====================================
    // INVOICE CUSTOMER PRICE
    // =====================================

    const customerSelect = document.querySelector('#customer_id');
    const invoiceAmount = document.querySelector('#invoice_amount');

    function updateInvoiceAmount() {
        if (!customerSelect || !invoiceAmount) return;

        const selected = customerSelect.options[customerSelect.selectedIndex];

        if (selected?.dataset.price) {
            invoiceAmount.value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(Number(selected.dataset.price));
        }
    }

    customerSelect?.addEventListener('change', updateInvoiceAmount);

});
