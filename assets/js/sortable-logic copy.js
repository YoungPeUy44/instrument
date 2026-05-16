/**
 * 1. ตรวจสอบและประกาศ Toast แบบ Global
 */
if (typeof window.Toast === 'undefined') {
    window.Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });
}

/**
 * 2. การตั้งค่า SortableJS สำหรับมือถือ (แก้ปัญหาลากติดมือขณะเลื่อนจอ)
 */
const sortOptions = {
    animation: 250,         // เพิ่มความนุ่มนวลเวลาสลับตำแหน่ง
    ghostClass: 'sortable-ghost',
    handle: '.drag-handle', // บังคับให้ลากเฉพาะจุดจับเท่านั้น
    forceFallback: true,    // ช่วยให้แสดงผลเสถียรบน iPhone/Android
    
    // ⭐ ส่วนสำคัญ: แก้ไขปัญหาการลากยากบนมือถือ
    delay: 200,             // ต้องกดค้าง 0.2 วินาที ถึงจะเริ่มลาก (ช่วยให้ Scroll จอได้ปกติ)
    delayOnTouchOnly: true, // ใช้ delay เฉพาะบนจอสัมผัส
    touchStartThreshold: 5  // ถ้านิ้วขยับเกิน 5px ให้ถือว่าเป็นการเลื่อนจอ ไม่ใช่การลากรูป
};

/**
 * 3. ฟังก์ชันบันทึกลำดับ (พร้อมระบบปิดปุ่มป้องกันการกดซ้ำ)
 */
window.saveOrder = function(type, insId, baseUrl) {
    const btn = event.currentTarget; // ดึงปุ่มที่กด
    const container = document.getElementById(type + '-sortable');
    if (!container || !btn) return;

    const items = container.querySelectorAll('.workbench-item, .sortable-item');
    const order = Array.from(items).map(item => item.dataset.id);

    if (order.length === 0) return;

    // ปิดปุ่มและแสดงสถานะกำลังโหลด
    const originalHTML = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...';

    const formData = new FormData();
    formData.append('type', type);
    formData.append('instrument_id', insId);
    formData.append('order', JSON.stringify(order));

    const cleanPath = baseUrl.endsWith('/') ? baseUrl : baseUrl + '/';

    fetch(cleanPath + '?act=re_images', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === 'OK') {
            window.Toast.fire({ icon: 'success', title: 'จัดลำดับเรียบร้อย' });
        } else {
            Swal.fire('Error', data, 'error');
        }
    })
    .catch(err => Swal.fire('Error', 'ไม่สามารถติดต่อ Server ได้', 'error'))
    .finally(() => {
        // เปิดปุ่มคืนค่าเดิม
        btn.disabled = false;
        btn.innerHTML = originalHTML;
    });
};

/**
 * 4. เริ่มทำงานเมื่อ DOM พร้อม (ป้องกันการประกาศซ้ำ)
 */
document.addEventListener('DOMContentLoaded', function() {
    const setupEl = document.getElementById('setup-sortable');
    if (setupEl && typeof Sortable !== 'undefined' && !setupEl.classList.contains('js-sortable-loaded')) {
        new Sortable(setupEl, sortOptions);
        setupEl.classList.add('js-sortable-loaded'); //
    }

    const runEl = document.getElementById('run-sortable');
    if (runEl && typeof Sortable !== 'undefined' && !runEl.classList.contains('js-sortable-loaded')) {
        new Sortable(runEl, sortOptions);
        runEl.classList.add('js-sortable-loaded');
    }
});

/**
 * 5. ฟังก์ชันลบรูปภาพแบบ POST (ลบจากหน้าจอทันที ไม่ต้อง Reload)
 */
window.deleteImgPOST = function(type, id, insId, baseUrl) {
    Swal.fire({
        title: 'ลบรูปภาพนี้?',
        text: "ข้อมูลจะถูกลบออกจากระบบทันที",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'ลบเลย',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('act', 'delete_img');
            formData.append('type', type);
            formData.append('id', id);
            formData.append('ins_id', insId);

            const cleanPath = baseUrl.endsWith('/') ? baseUrl : baseUrl + '/';
            fetch(cleanPath + 'db/save_instrument.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                if (data.trim() === 'OK') {
                    // ลบ Element ออกจากหน้าจอทันที
                    const item = document.querySelector(`[data-id="${id}"]`);
                    if (item) item.remove();
                    window.Toast.fire({ icon: 'success', title: 'ลบรูปภาพสำเร็จ' });
                } else {
                    Swal.fire('Error', data, 'error');
                }
            });
        }
    });
};

/**
 * 6. ฟังก์ชันลบไฟล์ Determination
 */
window.deleteFilePOST = function(deterId, insId, baseUrl) {
    Swal.fire({
        title: 'ลบไฟล์เอกสาร?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((swalResult) => {
        if (swalResult.isConfirmed) {
            const formData = new FormData();
            formData.append('act', 'delete_file');
            formData.append('id', deterId);
            formData.append('ins_id', insId);

            const cleanPath = baseUrl.endsWith('/') ? baseUrl : baseUrl + '/';
            fetch(cleanPath + 'db/save_instrument.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                if (data.trim() === 'OK') {
                    window.Toast.fire({ icon: 'success', title: 'ลบไฟล์สำเร็จ' })
                    .then(() => location.reload()); //
                } else {
                    Swal.fire('Error', data, 'error');
                }
            });
        }
    });
};