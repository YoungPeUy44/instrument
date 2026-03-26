/* training/assets/js/training_history.js */

function showDetail(data, userLevel) {
    const modalContent = document.getElementById('modalContent');
    const cancelBtnArea = document.getElementById('cancelBtnArea');
    
    const startDate = new Date(data.training_start);
    const endDate = new Date(data.training_end);
    const createdAt = new Date(data.created_at);
    const instruments = data.instruments ? data.instruments.split(', ') : [];
    
    // 1. สถานะ Badge (ไม่เช็คเวลาแล้ว)
    let statusHtml = '';
    const st = parseInt(data.training_status);
    if (st === 1) {
        statusHtml = '<span class="badge rounded-pill bg-success px-3 py-2 text-white">เสร็จสิ้น</span>';
    } else if (st === 2) {
        statusHtml = '<span class="badge rounded-pill bg-secondary px-3 py-2 text-white">ยกเลิกแล้ว</span>';
    } else {
        statusHtml = '<span class="badge rounded-pill bg-warning px-3 py-2 text-dark">กำลังดำเนินการ</span>';
    }

    modalContent.innerHTML = `
        <div class="row g-4">
            <div class="col-md-7">
                <div class="detail-label text-muted small">หัวข้อการเทรน</div>
                <div class="detail-value fw-bold fs-5 text-dark">${escapeHtml(data.training_topic)}</div>
            </div>
            <div class="col-md-5 text-end">
                <div class="detail-label text-muted small">สถานะ</div>
                <div class="mt-1">${statusHtml}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-label text-muted small">วัน-เวลาเริ่มต้น</div>
                <div class="detail-value border p-2 rounded-3 bg-white text-dark">
                    ${startDate.toLocaleDateString('th-TH')} ${startDate.toLocaleTimeString('th-TH', {hour:'2-digit', minute:'2-digit'})} น.
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-label text-muted small">วัน-เวลาสิ้นสุด</div>
                <div class="detail-value border p-2 rounded-3 bg-white text-dark">
                    ${endDate.toLocaleDateString('th-TH')} ${endDate.toLocaleTimeString('th-TH', {hour:'2-digit', minute:'2-digit'})} น.
                </div>
            </div>
            <div class="col-12">
                <div class="detail-label text-muted small">เครื่องตรวจที่นัดเทรน</div>
                <div class="d-flex flex-wrap gap-1 mt-1">
                    ${instruments.map(ins => `<span class="badge-instrument">${escapeHtml(ins)}</span>`).join('')}
                </div>
            </div>
            <div class="col-12 p-3 bg-light rounded-3">
                <div class="detail-label text-muted small">รายละเอียดเพิ่มเติม</div>
                <div class="text-dark">${escapeHtml(data.training_detail || '- ไม่มีรายละเอียด -')}</div>
            </div>
            <div class="col-12 small text-muted">
                ผู้นัดหมาย: ${escapeHtml(data.created_by)} | วันที่บันทึก: ${createdAt.toLocaleString('th-TH')}
            </div>
        </div>
    `;

    // 3. จัดการปุ่ม
    let buttonsHtml = '';

    if (userLevel >= 3) {
        buttonsHtml += `
            <button type="button" class="btn btn-outline-danger rounded-pill px-4 me-auto" onclick="confirmDelete(${data.training_id})">
                <i class="bi bi-trash-fill"></i> ลบประวัติ
            </button>
        `;
    }

    // ปุ่มยืนยัน และ ยกเลิก: แสดงถ้าสถานะยังเป็น 0
    if (st === 0) {
        // ✅ ปรับเงื่อนไขให้ Level 1 ขึ้นไปกดยืนยันได้
        if (userLevel >= 1) {
            buttonsHtml += `
                <button type="button" class="btn btn-success rounded-pill px-4 me-2" onclick="confirmFinishInModal(${data.training_id}, '${data.ins_id_list}')">
                    ยืนยันเสร็จสิ้น
                </button>
            `;
        }
        
        // ปุ่มยกเลิกนัด (ถ้าต้องการให้สิทธิ์ 1 ยกเลิกได้ด้วย)
        if (userLevel >= 2) {
            buttonsHtml += `
                <button type="button" class="btn btn-danger rounded-pill px-4" onclick="confirmCancel(${data.training_id})">
                    ยกเลิกนัด
                </button>
            `;
        }
    }

    cancelBtnArea.innerHTML = buttonsHtml;
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function confirmFinishInModal(trainingId, insIds) {
    Swal.fire({
        title: 'ยืนยันบันทึกผลการเทรน?',
        text: "ระบบจะปรับสถานะเครื่องตรวจเป็น 'พร้อม' ทั้งหมด",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'กลับ'
    }).then((result) => {
        if (result.isConfirmed) {
           window.location.href = `?act=update_training_complete&training_id=${trainingId}&ins_ids=${insIds}`;
        }
    });
}

function confirmDelete(id) {
    Swal.fire({
        title: 'ลบประวัติถาวร?',
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'ลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `?act=delete_training&id=${id}`;
        }
    });
}

function confirmCancel(id) {
    Swal.fire({
        title: 'ยกเลิกนัดหมายนี้?',
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
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}