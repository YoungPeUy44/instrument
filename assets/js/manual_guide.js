/* assets/js/manual_guide.js */

// ====== Dropdown Bootstrap (โหลดหน้าแรก — PHP render) ======
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.dropdown-toggle').forEach(el => {
        new bootstrap.Dropdown(el, {
            boundary: document.body,
            display: 'dynamic',
            popperConfig: { strategy: 'fixed' }
        });
    });

    // ====== SweetAlert Status ======
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status) {
        const map = {
            cancel_success: { icon: 'info',    title: 'ยกเลิกนัดเทรนเรียบร้อย' },
            delete_success: { icon: 'success', title: 'ลบข้อมูลเรียบร้อย' },
            update_success: { icon: 'success', title: 'บันทึกข้อมูลสำเร็จ' },
            error:          { icon: 'error',   title: 'เกิดข้อผิดพลาด' },
        };
        const s = map[status];
        if (s) {
            Swal.fire({
                icon: s.icon, title: s.title,
                toast: true, position: 'top-end',
                showConfirmButton: false,
                timer: 3000, timerProgressBar: true,
            });
            const url = new URL(window.location.href);
            url.searchParams.delete('status');
            window.history.replaceState(null, '', url.pathname + url.search);
        }
    }
});

// ====== Live Search ======
let _searchTimer;

$(document).ready(function () {

    // พิมพ์แล้ว query ทันที (debounce 400ms)
    $('#searchIns').on('input', function () {
        clearTimeout(_searchTimer);
        _searchTimer = setTimeout(() => loadData(1), 400);
    });

    // เปลี่ยน dropdown กรองทันที
    $('select[name="category_id"], select[name="status_id"]').on('change', function () {
        loadData(1);
    });

    // ป้องกัน form submit โหลดหน้าใหม่
    $('form').on('submit', function (e) {
        e.preventDefault();
        loadData(1);
    });
});

function loadData(page = 1) {
    const kw       = $('#searchIns').val() || '';
    const category = $('select[name="category_id"]').val() || 0;
    const status   = $('select[name="status_id"]').val() || 0;

    const url = `${BASE_SEARCH_URL}?kw=${encodeURIComponent(kw)}&category_id=${category}&status_id=${status}&page=${page}`;

    // แสดง loading
    $('#tableBody').html(`
        <tr><td colspan="6" class="text-center py-5 text-muted">
            <div class="spinner-border spinner-border-sm me-2"></div>กำลังค้นหา...
        </td></tr>
    `);
    $('#mobileList').html(`
        <div class="text-center p-4 text-muted">
            <div class="spinner-border spinner-border-sm me-2"></div>กำลังค้นหา...
        </div>
    `);

    fetch(url)
        .then(res => {
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            return res.json();
        })
        .then(res => {
            renderTable(res.data, res.can_edit);
            renderMobile(res.data, res.can_edit);
            renderPagination(res.total, res.page, res.limit, res.pages);
        })
        .catch(err => {
            console.error('Search error:', err);
            const errHtml = `<tr><td colspan="6" class="text-center text-danger py-5">
                <i class="bi bi-exclamation-triangle d-block mb-2" style="font-size:2rem;opacity:.4"></i>
                เกิดข้อผิดพลาดในการค้นหา</td></tr>`;
            $('#tableBody').html(errHtml);
            $('#mobileList').html(`<div class="text-center text-danger p-4">เกิดข้อผิดพลาดในการค้นหา</div>`);
        });
}

// ── helper: สร้าง dropdown menu items ตาม permission ──
// FIX: เพิ่ม can_edit เพื่อให้แสดงปุ่มแก้ไขเมื่อมีสิทธิ์
function buildDropdownItems(ins_id, can_edit) {
    let items = `
        <li>
            <a class="dropdown-item py-2 small" href="?act=view&id=${ins_id}">
                <i class="bi bi-eye text-primary me-2"></i>ดูรายละเอียด
            </a>
        </li>`;

    if (can_edit) {
        items += `
        <li><hr class="dropdown-divider opacity-50"></li>
        <li>
            <a class="dropdown-item py-2 small" href="?act=edit&id=${ins_id}&mode=basic">
                <i class="bi bi-pencil-square text-warning me-2"></i>แก้ไขข้อมูลเครื่อง
            </a>
        </li>`;
    }

    return items;
}

// ── render desktop table rows ──
// FIX: รับ can_edit และส่งต่อให้ buildDropdownItems
function renderTable(data, can_edit = false) {
    if (!data || data.length === 0) {
        $('#tableBody').html(`
            <tr><td colspan="6" class="text-center py-5 text-muted">
                <i class="bi bi-search d-block mb-2" style="font-size:2rem;opacity:.3"></i>
                ไม่พบข้อมูลเครื่องตรวจ
            </td></tr>`);
        return;
    }

    let html = '';
    data.forEach(row => {
        const badge  = statusBadge(row.ref_atm_status_manual_id, false, row.setup_comfirmed_tmp);
        const imgSrc = row.equipment_image
            ? `${BASE_URL}assets/imgs/ins_setup/${row.equipment_image}`
            : `${BASE_URL}assets/imgs/ins_setup/noImage.jpg`;

        html += `
        <tr onclick="window.location='?act=view&id=${row.ins_id}'" style="cursor:pointer;">
            <td style="width:140px;">
                <div class="table-thumb-box shadow-sm border bg-white">
                    <img src="${imgSrc}" onerror="this.src='${BASE_URL}assets/imgs/ins_setup/noImage.jpg'">
                </div>
            </td>
            <td>
                <div class="fw-bold text-dark">${escHtml(row.name)}</div>
                <div class="small text-muted">ID: #${row.ins_id}</div>
            </td>
            <td class="text-center">${badge}</td>
            <td>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill mb-1">${escHtml(row.atm_category_name)}</span><br>
                <span class="badge badge-soft rounded-pill" style="font-size:.7rem;">${escHtml(row.cable_name)}</span>
            </td>
            <td class="small text-muted d-none d-lg-table-cell">${escHtml(row.updated_at)}</td>
            <td class="text-center" onclick="event.stopPropagation();">
                <div class="dropdown">
                    <button class="btn btn-light border shadow-sm dropdown-toggle btn-action-menu"
                            type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                        ${buildDropdownItems(row.ins_id, can_edit)}
                    </ul>
                </div>
            </td>
        </tr>`;
    });

    $('#tableBody').html(html);

    // FIX: re-init dropdown หลัง inject HTML ใหม่ พร้อม strategy: fixed
    document.querySelectorAll('#tableBody .dropdown-toggle').forEach(el => {
        new bootstrap.Dropdown(el, {
            boundary: document.body,
            display: 'dynamic',
            popperConfig: { strategy: 'fixed' }
        });
    });
}

// ── render mobile cards ──
// FIX: เพิ่ม dropdown ⋮ ใน card มือถือ + รับ can_edit + re-init dropdown
function renderMobile(data, can_edit = false) {
    if (!data || data.length === 0) {
        $('#mobileList').html(`
            <div class="text-center p-5 text-muted bg-white rounded-4 shadow-sm">
                <i class="bi bi-search d-block mb-2" style="font-size:2rem;opacity:.3"></i>
                ไม่พบข้อมูลเครื่องตรวจ
            </div>`);
        return;
    }

    let html = '';
    data.forEach(row => {
        const badge  = statusBadge(row.ref_atm_status_manual_id, true, row.setup_comfirmed_tmp);
        const imgSrc = row.equipment_image
            ? `${BASE_URL}assets/imgs/ins_setup/${row.equipment_image}`
            : `${BASE_URL}assets/imgs/ins_setup/noImage.jpg`;

        html += `
        <div class="card mb-3 shadow-sm border-0 rounded-4"
             onclick="window.location='?act=view&id=${row.ins_id}'"
             style="cursor:pointer; background:#fff;">
            <div class="row g-0 align-items-center">
                <div class="col-4">
                    <div style="aspect-ratio:1/1; overflow:hidden; border-radius:16px 0 0 16px;">
                        <img src="${imgSrc}" class="w-100 h-100" style="object-fit:cover;"
                             onerror="this.src='${BASE_URL}assets/imgs/ins_setup/noImage.jpg'">
                    </div>
                </div>
                <div class="col-8">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div class="text-truncate pe-2">
                                <h6 class="fw-bold mb-0 text-dark text-truncate" style="font-size:.9rem;">${escHtml(row.name)}</h6>
                                <small class="text-muted" style="font-size:.7rem;">ID: #${row.ins_id}</small>
                            </div>
                            <!-- FIX: เพิ่ม dropdown ⋮ ที่ขาดไปใน mobile ──────── -->
                            <div class="dropdown" onclick="event.stopPropagation();">
                                <button class="btn btn-light btn-sm border-0 rounded-circle dropdown-toggle"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        style="width:32px;height:32px;padding:0;">
                                    <i class="bi bi-three-dots-vertical text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                                    ${buildDropdownItems(row.ins_id, can_edit)}
                                </ul>
                            </div>
                            <!-- ─────────────────────────────────────────────── -->
                        </div>
                        <div class="mb-2">${badge}</div>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill" style="font-size:.6rem;">${escHtml(row.atm_category_name)}</span>
                            <span class="badge border text-muted rounded-pill" style="font-size:.6rem;">${escHtml(row.cable_name)}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    });

    $('#mobileList').html(html);

    // FIX: re-init dropdown มือถือ — จุดนี้ขาดไปทั้งหมดในไฟล์เดิม
    document.querySelectorAll('#mobileList .dropdown-toggle').forEach(el => {
        new bootstrap.Dropdown(el, {
            boundary: document.body,
            display: 'dynamic',
            popperConfig: { strategy: 'fixed' }
        });
    });
}

// ── render pagination ──
function renderPagination(total, page, limit, pages) {
    if (pages <= 1) { $('#paginationWrap').html(''); return; }

    let html = `<ul class="pagination pagination-sm justify-content-center mb-0">`;

    // prev
    html += `<li class="page-item ${page <= 1 ? 'disabled' : ''}">
        <a class="page-link shadow-sm mx-1 rounded-3" href="#" onclick="loadData(${page - 1});return false;">
            <i class="bi bi-chevron-left"></i></a></li>`;

    // smart window
    const w = 2;
    let lastShown = null;
    for (let i = 1; i <= pages; i++) {
        if (i === 1 || i === pages || (i >= page - w && i <= page + w)) {
            if (lastShown !== null && i - lastShown > 1) {
                html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
            }
            html += `<li class="page-item ${i === page ? 'active' : ''}">
                <a class="page-link shadow-sm mx-1 rounded-3" href="#" onclick="loadData(${i});return false;">${i}</a></li>`;
            lastShown = i;
        }
    }

    // next
    html += `<li class="page-item ${page >= pages ? 'disabled' : ''}">
        <a class="page-link shadow-sm mx-1 rounded-3" href="#" onclick="loadData(${page + 1});return false;">
            <i class="bi bi-chevron-right"></i></a></li>`;

    html += `</ul>`;
    $('#paginationWrap').html(html);
}

// ── helpers ──
function statusBadge(id, small = false, setup_comfirmed_tmp = 1) {
    const sz = small ? 'font-size:0.65rem;' : '';
    if (id == 1) return `<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill" style="${sz}"><i class="bi bi-check-circle-fill me-1"></i>พร้อม</span>`;
    if (id == 3) return `<span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill text-dark" style="${sz}"><i class="bi bi-clock-history me-1"></i>รอเทรน</span>`;
    // FIX: เพิ่มสถานะ "ข้อมูลไม่ครบ" เมื่อ ref_atm_status_manual_id=2 และ setup_comfirmed_tmp=0
    if (id == 2 && setup_comfirmed_tmp == 0) return `<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill" style="${sz}"><i class="bi bi-exclamation-circle-fill me-1"></i>ข้อมูลไม่ครบ</span>`;
    return `<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill" style="${sz}"><i class="bi bi-dash-circle me-1"></i>ไม่พร้อม</span>`;
}

function escHtml(str) {
    if (!str) return '—';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}