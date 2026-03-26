
function showDetail(data) {
    const modalContent = document.getElementById('modalContent');
    const cancelBtnArea = document.getElementById('cancelBtnArea');
    
    const startDate = new Date(data.training_start);
    const endDate = new Date(data.training_end);
    const createdAt = new Date(data.created_at);
    
    const instruments = data.instruments ? data.instruments.split(', ') : [];
    
    // กำหนดสถานะ Badge
    let statusHtml = '';
    if (data.training_status == 2) {
        statusHtml = '<span class="badge rounded-pill bg-secondary px-3 py-2"><i class="bi bi-x-circle me-1"></i> ยกเลิกแล้ว</span>';
    } else if (data.training_status == 1 || (new Date() > endDate)) {
        statusHtml = '<span class="badge-status-completed px-3 py-2"><i class="bi bi-check-lg me-1"></i> เสร็จสิ้นแล้ว</span>';
    } else {
        statusHtml = '<span class="badge-status-pending px-3 py-2"><i class="bi bi-hourglass-split me-1"></i> รอดำเนินการ</span>';
    }

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
    
   if (data.training_status != 2) {
        cancelBtnArea.innerHTML = `
            <button type="button" class="btn btn-danger rounded-pill px-4" onclick="confirmCancel(${data.training_id})">
                <i class="bi bi-trash3 me-1"></i> ยกเลิกการเทรน
            </button>
        `;
    } else {
        cancelBtnArea.innerHTML = '<span class="text-muted small">รายการนี้ยกเลิกแล้ว</span>';
    }
    
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

// ฟังก์ชันยืนยันการยกเลิก
function confirmCancel(id) {
    Swal.fire({
        title: 'ยืนยันการยกเลิก?',
        text: "สถานะการเทรนจะถูกยกเลิก และเครื่องตรวจจะถูกตั้งสถานะใหม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'ยืนยันยกเลิก',
        cancelButtonText: 'กลับ'
    }).then((result) => {
        if (result.isConfirmed) {
            // เรียกไฟล์อัปเดตสถานะ
            window.location.href = `../db/update_status.php?id=${id}&status=2`;
        }
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}