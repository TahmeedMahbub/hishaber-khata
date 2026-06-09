/**
 * Dashboard — lazy/AJAX loading + draggable card persistence.
 *
 * No statistics are rendered server-side. The page shell paints instantly
 * with skeletons, then this script hydrates each widget after load.
 */
'use strict';

(function () {
    var routes = window.dashboardRoutes || {};
    var ORDER_KEY = 'dashboardCardOrder';

    function money(value) {
        var n = Number(value || 0);
        var parts = n.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).split('.');
        var cents = parts[1] ? '<span class="stat-cents">.' + parts[1] + '</span>' : '';
        return '৳ ' + parts[0] + cents;
    }

    function getJson(url) {
        return fetch(url, {
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        }).then(function (res) {
            if (!res.ok) throw new Error('Request failed: ' + url);
            return res.json();
        });
    }

    // --- Stat cards ---------------------------------------------------------
    function loadStats() {
        getJson(routes.stats)
            .then(function (data) {
                Object.keys(data).forEach(function (key) {
                    var el = document.querySelector('.stat-value[data-stat="' + key + '"]');
                    if (el) el.innerHTML = money(data[key]);
                });
            })
            .catch(function () {
                document.querySelectorAll('.stat-value').forEach(function (el) {
                    el.textContent = '—';
                });
            });
    }

    // --- Alerts -------------------------------------------------------------
    function loadAlerts() {
        getJson(routes.alerts)
            .then(function (data) {
                Object.keys(data).forEach(function (key) {
                    var el = document.querySelector('.alert-value[data-alert="' + key + '"]');
                    if (el) el.textContent = data[key];
                });
            })
            .catch(function () {
                document.querySelectorAll('.alert-value').forEach(function (el) {
                    el.textContent = '—';
                });
            });
    }

    // --- Recent sales -------------------------------------------------------
    function loadRecentSales() {
        var body = document.getElementById('recent-sales-body');
        if (!body) return;

        getJson(routes.recentSales)
            .then(function (rows) {
                if (!rows.length) {
                    body.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-4">কোনো বিক্রয় নেই।</td></tr>';
                    return;
                }
                body.innerHTML = rows.map(function (s) {
                    return '<tr>' +
                        '<td class="fw-medium"><a href="' + s.url + '">' + escapeHtml(s.invoice_no) + '</a></td>' +
                        '<td>' + escapeHtml(s.customer) + '</td>' +
                        '<td class="text-end">' + money(s.total) + '</td>' +
                        '</tr>';
                }).join('');
            })
            .catch(function () {
                body.innerHTML = '<tr><td colspan="3" class="text-center text-danger py-4">লোড করা যায়নি।</td></tr>';
            });
    }

    // --- Top products -------------------------------------------------------
    function loadTopProducts() {
        var list = document.getElementById('top-products-list');
        if (!list) return;

        getJson(routes.topProducts)
            .then(function (rows) {
                if (!rows.length) {
                    list.innerHTML = '<li class="list-group-item text-center text-muted py-4">কোনো তথ্য নেই।</li>';
                    return;
                }
                list.innerHTML = rows.map(function (p) {
                    return '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                        '<span>' + escapeHtml(p.name) + '</span>' +
                        '<span class="badge bg-label-primary">' + p.qty + '</span>' +
                        '</li>';
                }).join('');
            })
            .catch(function () {
                list.innerHTML = '<li class="list-group-item text-center text-danger py-4">লোড করা যায়নি।</li>';
            });
    }

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.textContent = str == null ? '' : String(str);
        return div.innerHTML;
    }

    // --- Draggable cards with persisted order -------------------------------
    function restoreOrder(container) {
        var saved;
        try {
            saved = JSON.parse(localStorage.getItem(ORDER_KEY) || '[]');
        } catch (e) {
            saved = [];
        }
        if (!Array.isArray(saved) || !saved.length) return;

        saved.forEach(function (id) {
            var col = container.querySelector('.dashboard-card-col[data-widget-id="' + id + '"]');
            if (col) container.appendChild(col);
        });
    }

    function saveOrder(container) {
        var order = Array.prototype.map.call(
            container.querySelectorAll('.dashboard-card-col'),
            function (col) { return col.getAttribute('data-widget-id'); }
        );
        localStorage.setItem(ORDER_KEY, JSON.stringify(order));
    }

    function initSortable() {
        var container = document.getElementById('dashboard-cards');
        if (!container || typeof Sortable === 'undefined') return;

        restoreOrder(container);

        Sortable.create(container, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'bg-lighter',
            onEnd: function () { saveOrder(container); },
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initSortable();

        // Hydrate widgets asynchronously; each is independent so a slow/failed
        // endpoint never blocks the others.
        loadStats();
        loadAlerts();
        loadRecentSales();
        loadTopProducts();
    });
})();
