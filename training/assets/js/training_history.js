/* training/assets/js/training_history.js */

/**
 * ฟังก์ชันหลักสำหรับดึงข้อมูลรายละเอียดมาโชว์
 * @param {number} trainingId - ไอดีของการเทรน
 */
function showDetail(trainingId) {
    // 1. ตรวจสอบ jQuery และพื้นที่วางข้อมูล
    // เราใช้ id="dynamic_modal_content" ตามโครงสร้าง Modal ใหม่ที่เราคุยกัน
    const container = $('#dynamic_modal_content');
    
    if (container.length === 0) {
        console.error("หาพื้นที่ id='dynamic_modal_content' ไม่เจอ");
        return;
    }

    // 2. แสดง Loader ให้ผู้ใช้รู้ว่ากำลังโหลด
    container.html(`
        <div class="text-center p-5">
            <div class="spinner-border text-warning" role="status"></div>
            <p class="mt-2 text-muted">กำลังดึงข้อมูลรายละเอียด...</p>
        </div>
    `);
    
    // 3. สั่งเปิด Modal รอไว้เลย
    const modalElement = document.getElementById('detailModal');
    if (modalElement) {
        const myModal = new bootstrap.Modal(modalElement);
        myModal.show();
    }

    // 4. ดึงข้อมูลจากไฟล์แยกผ่านระบบ act
    // ส่ง mode=modal ไปด้วยเพื่อให้ไฟล์ปลายทางรู้ว่า "ไม่ต้องโชว์ปุ่มยืนยัน"
    $.ajax({
    // url: 'index.php', // ส่งกลับไปที่หน้าหลักเพื่อให้ Controller จัดการ
    url: '/xct/instrument/index.php',
    type: 'GET',
    data: { 
        act: 'update_training_detail', // ต้องตรงกับ act ใน URL ที่คุณส่งมาให้ผม
        training_id: trainingId,
        mode: 'modal' 
    },
    success: function(response) {
        // นำข้อมูลที่ได้ (ซึ่งคือ HTML จาก training_history_detail.php) ไปวาง
        $('#dynamic_modal_content').html(response);
    },
    error: function() {
        $('#dynamic_modal_content').html('<div class="p-5 text-center text-danger">เกิดข้อผิดพลาดในการโหลดข้อมูล</div>');
    }
});
}

/** * ฟังก์ชันยืนยันเสร็จสิ้น 
 * (ใช้ร่วมกันทั้งหน้า Full Page และไฟล์ Model)
 */
function confirmFinishInModal(training_id, ins_ids) {
    Swal.fire({
        title: 'ยืนยันบันทึกผลการอบรบ',
        text: "ระบบจะปรับสถานะเครื่องตรวจเป็น 'พร้อม' ทั้งหมด",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'กลับ'
    }).then((result) => {
        if (result.isConfirmed) {
           window.location.href = `?act=update_training_complete&training_id=${training_id}&ins_ids=${ins_ids}`;
        }
    });
}

/** ฟังก์ชันลบประวัติ */
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

/** ฟังก์ชันยกเลิกนัด */
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
//เด้งเตือนนัดหมายเทรนสำเร็จ
document.addEventListener('DOMContentLoaded', function() {
    // 1. ดึง Status จาก URL
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    // 2. ตรวจสอบเงื่อนไข status=order_success เท่านั้น
    if (status === 'order_success') {
        Swal.fire({
            icon: 'success',
            title: 'นัดหมายสำเร็จ', // หรือข้อความที่นายต้องการ
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // ✅ ล้าง Parameter 'status' ออกจาก URL ทันทีเพื่อให้ URL สวยงามและไม่เด้งซ้ำ
        const url = new URL(window.location.href);
        url.searchParams.delete('status');
        window.history.replaceState(null, '', url.pathname + url.search);
    }
});