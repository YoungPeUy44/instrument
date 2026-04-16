function showDetail(data) {
    const modalContent = document.getElementById('modalContent');
    const cancelBtnArea = document.getElementById('cancelBtnArea');
    
    const startDate = new Date(data.training_start);
    const endDate = new Date(data.training_end);
    const createdAt = new Date(data.created_at);
    
    const instruments = data.instruments ? data.instruments.split(', ') : [];
    
    // กำหนดสถานะ Badge
    let statusHtml = '';
    const st = parseInt(data.training_status);
    

    if (st === 2) {
        statusHtml = '<span class="badge rounded-pill bg-secondary px-3 py-2">ยกเลิกแล้ว</span>';
    } else if (st === 1 || (new Date() > endDate)) {
        statusHtml = '<span class="badge-status-completed px-3 py-2">เสร็จสิ้น</span>';
    } else {
        statusHtml = '<span class="badge-status-pending px-3 py-2">กำลังดำเนินการ</span>';
    }

    // จัดการปุ่มยกเลิก
    if (st !== 2) {
        cancelBtnArea.innerHTML = `
            <button type="button" class="btn btn-danger rounded-pill px-4" onclick="confirmCancel(${data.training_id})">
                <i class="bi bi-trash3 me-1"></i> ยกเลิกการเทรน
            </button>
        `;
    } else {
        cancelBtnArea.innerHTML = '<span class="text-muted small">รายการนี้ยกเลิกแล้ว</span>';
    }
    
    new bootstrap.Modal(document.getElementById('detailModal')).show();

    

    modalContent.innerHTML = `
        <div class="row g-4">
            <div class="col-md-7">
                <div class="detail-label">หัวข้อการเทรน</div>
                <div class="detail-value fw-bold fs-5">${escapeHtml(data.training_topic)}</div>
            </div>
            <div class="col-md-5">
                <div class="detail-label">สถานที่</div>
                <div class="detail-value">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                    ${escapeHtml(data.training_location || '-')}
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">วันที่เริ่มต้น</div>
                <div class="detail-value border p-2 rounded-3 bg-white">
                    <i class="bi bi-calendar-check me-2 text-primary"></i>
                    ${startDate.toLocaleDateString('th-TH', { day:'numeric', month:'long', year:'numeric' })} ${startDate.toLocaleTimeString('th-TH', { hour:'2-digit', minute:'2-digit' })}
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">วันที่สิ้นสุด</div>
                <div class="detail-value border p-2 rounded-3 bg-white">
                    <i class="bi bi-calendar-x me-2 text-primary"></i>
                    ${endDate.toLocaleDateString('th-TH', { day:'numeric', month:'long', year:'numeric' })} ${endDate.toLocaleTimeString('th-TH', { hour:'2-digit', minute:'2-digit' })}
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">ผู้นัดเทรน / ผู้บันทึก</div>
                <div class="detail-value small"><i class="bi bi-person-circle me-1 text-primary"></i> ${escapeHtml(data.created_by || 'ระบบ')}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">วันที่บันทึกข้อมูล</div>
                <div class="detail-value small"><i class="bi bi-clock me-1 text-primary"></i> ${createdAt.toLocaleString('th-TH')}</div>
            </div>
            <div class="col-12">
                <div class="detail-label">เครื่องตรวจที่เกี่ยวข้อง</div>
                <div class="d-flex flex-wrap gap-1 mt-1">
                    ${instruments.map(ins => `<span class="badge-instrument">${escapeHtml(ins)}</span>`).join('')}
                </div>
            </div>
            <div class="col-12">
                <div class="detail-label">รายละเอียดเพิ่มเติม</div>
                <div class="p-3 bg-light rounded-3" style="min-height: 60px;">
                    ${data.training_detail ? escapeHtml(data.training_detail) : '<span class="text-muted small">- ไม่มีรายละเอียด -</span>'}
                </div>
            </div>
            <div class="col-12">
                <div class="detail-label">สถานะ</div>
                <div class="mt-1">${statusHtml}</div>
            </div>
        </div>
    `;
    
    // จัดการปุ่มยกเลิก (แสดงเฉพาะถ้ายังไม่ยกเลิก)
    if (data.training_status != 2) {
        cancelBtnArea.innerHTML = `
            <button type="button" class="btn btn-danger rounded-pill px-4" onclick="confirmCancel(${data.training_id})">
                <i class="bi bi-trash3 me-1"></i> ยกเลิกการเทรน
            </button>
        `;
    } else {
        cancelBtnArea.innerHTML = '';
    }
    
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function confirmCancel(id) {
    Swal.fire({
        title: 'ยืนยันการยกเลิก?',
        text: "เมื่อยกเลิกแล้ว สถานะเครื่องจะกลับเป็น 'ไม่พร้อม' ทันที",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'ยืนยันยกเลิก',
        cancelButtonText: 'กลับ'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `?act=update_training_status&id=${id}&status=2`;
        }
    });
}



function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}/* training/assets/js/training_history.js */

function showDetail(data) {
    const modalContent = document.getElementById('modalContent');
    const cancelBtnArea = document.getElementById('cancelBtnArea');
    
    const startDate = new Date(data.training_start);
    const endDate = new Date(data.training_end);
    const createdAt = new Date(data.created_at);
    const instruments = data.instruments ? data.instruments.split(', ') : [];
    
    // 1. กำหนดสถานะ Badge
    let statusHtml = '';
    const st = parseInt(data.training_status);
    if (st === 2) {
        statusHtml = '<span class="badge rounded-pill bg-secondary px-3 py-2">ยกเลิกแล้ว</span>';
    } else if (st === 1 || (new Date() > endDate)) {
        statusHtml = '<span class="badge-status-completed px-3 py-2">เสร็จสิ้น</span>';
    } else {
        statusHtml = '<span class="badge-status-pending px-3 py-2">กำลังดำเนินการ</span>';
    }

    // 2. แสดงเนื้อหารายละเอียดใน Modal
    modalContent.innerHTML = `
        <div class="row g-4">
            <div class="col-md-7">
                <div class="detail-label">หัวข้อการเทรน</div>
                <div class="detail-value fw-bold fs-5">${escapeHtml(data.training_topic)}</div>
            </div>
            <div class="col-md-5">
                <div class="detail-label">สถานที่</div>
                <div class="detail-value">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                    ${escapeHtml(data.training_location || '-')}
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">วันที่เริ่มต้น</div>
                <div class="detail-value border p-2 rounded-3 bg-white">
                    <i class="bi bi-calendar-check me-2 text-primary"></i>
                    ${startDate.toLocaleDateString('th-TH', { day:'numeric', month:'long', year:'numeric' })} ${startDate.toLocaleTimeString('th-TH', { hour:'2-digit', minute:'2-digit' })}
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">วันที่สิ้นสุด</div>
                <div class="detail-value border p-2 rounded-3 bg-white">
                    <i class="bi bi-calendar-x me-2 text-primary"></i>
                    ${endDate.toLocaleDateString('th-TH', { day:'numeric', month:'long', year:'numeric' })} ${endDate.toLocaleTimeString('th-TH', { hour:'2-digit', minute:'2-digit' })}
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">ผู้นัดเทรน / ผู้บันทึก</div>
                <div class="detail-value small"><i class="bi bi-person-circle me-1 text-primary"></i> ${escapeHtml(data.created_by || 'ระบบ')}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">วันที่บันทึกข้อมูล</div>
                <div class="detail-value small"><i class="bi bi-clock me-1 text-primary"></i> ${createdAt.toLocaleString('th-TH')}</div>
            </div>
            <div class="col-12">
                <div class="detail-label">เครื่องตรวจที่เกี่ยวข้อง</div>
                <div class="d-flex flex-wrap gap-1 mt-1">
                    ${instruments.map(ins => `<span class="badge-instrument">${escapeHtml(ins)}</span>`).join('')}
                </div>
            </div>
            <div class="col-12">
                <div class="detail-label">รายละเอียดเพิ่มเติม</div>
                <div class="p-3 bg-light rounded-3" style="min-height: 60px;">
                    ${data.training_detail ? escapeHtml(data.training_detail) : '<span class="text-muted small">- ไม่มีรายละเอียด -</span>'}
                </div>
            </div>
            <div class="col-12">
                <div class="detail-label">สถานะ</div>
                <div class="mt-1">${statusHtml}</div>
            </div>
        </div>
    `;

    // 3. จัดการปุ่มใน Footer
    let buttonsHtml = '';

    // ปุ่มลบ: สำหรับ TEST ให้โชว์เสมอ
    buttonsHtml += `
        <button type="button" class="btn btn-outline-danger rounded-pill px-4 me-auto" onclick="confirmDelete(${data.training_id})">
            <i class="bi bi-trash-fill me-1"></i> ลบข้อมูล (Test)
        </button>
    `;

    // ปุ่มยกเลิก: แสดงเฉพาะถ้าสถานะยังไม่ยกเลิก
    if (st !== 2) {
        buttonsHtml += `
            <button type="button" class="btn btn-danger rounded-pill px-4" onclick="confirmCancel(${data.training_id})">
                <i class="bi bi-trash3 me-1"></i> ยกเลิกการเทรน
            </button>
        `;
    }

    cancelBtnArea.innerHTML = buttonsHtml;
    
    // 4. สั่งเปิด Modal
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

// --- ย้ายฟังก์ชันพวกนี้ออกมาไว้ข้างนอก (Global Scope) ---

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function confirmDelete(id) {
    Swal.fire({
        title: 'ยืนยันการลบถาวร?',
        text: "ข้อมูลนี้จะถูกลบออกจากฐานข้อมูลทันที!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'ลบข้อมูล',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `?act=delete_training&id=${id}`;
        }
    });
}

function confirmCancel(id) {
    Swal.fire({
        title: 'ยืนยันการยกเลิก?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'ยืนยันยกเลิก',
        cancelButtonText: 'กลับ'
    }).then((result) => {
        if (result.isConfirmed) {
           window.location.href = `?act=update_training_status&id=${id}&status=2`;
        }
    });
}