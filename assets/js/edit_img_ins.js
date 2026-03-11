/**
 * edit_img_ins.js
 * จัดการการพรีวิวรูปภาพและการตรวจสอบขนาดไฟล์ก่อนอัปโหลด
 */

// กำหนดค่าคงที่ (ให้ตรงกับใน save_instrument.php)
const MAX_IMG_SIZE = 5 * 1024 * 1024; // 5MB

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. จัดการพรีวิวและเช็กขนาดรูปหน้าปก (Single File)
    const eqInput = document.querySelector('input[name="equipment_image"]');
    if (eqInput) {
        eqInput.addEventListener('change', function() {
            if (checkFileSize(this)) {
                previewImage(this, 'preview_eq');
            }
        });
    }

    // 2. จัดการเช็กขนาดรูป Setup และ Run (Multiple Files)
    const multiInputs = [
        document.querySelector('input[name="setup_images[]"]'),
        document.querySelector('input[name="run_images[]"]')
    ];

    multiInputs.forEach(input => {
        if (input) {
            input.addEventListener('change', function() {
                checkMultiFileSize(this);
            });
        }
    });
});

/**
 * ตรวจสอบขนาดไฟล์เดี่ยว
 */
function checkFileSize(input) {
    if (input.files && input.files[0]) {
        const size = input.files[0].size;
        if (size > MAX_IMG_SIZE) {
            showSizeError(size);
            input.value = ""; // ล้างค่า
            return false;
        }
    }
    return true;
}

/**
 * ตรวจสอบขนาดไฟล์กรณีเลือกหลายรูป (Multiple)
 */
function checkMultiFileSize(input) {
    if (input.files) {
        for (let i = 0; i < input.files.length; i++) {
            if (input.files[i].size > MAX_IMG_SIZE) {
                showSizeError(input.files[i].size);
                input.value = ""; 
                return false;
            }
        }
    }
    return true;
}

/**
 * แสดง Pop-up แจ้งเตือน
 */
function showSizeError(currentSize) {
    const sizeMB = (currentSize / (1024 * 1024)).toFixed(2);
    Swal.fire({
        icon: 'error',
        title: 'ไฟล์ใหญ่เกินไป!',
        text: `ขนาดไฟล์ของคุณ ${sizeMB} MB ซึ่งเกินขีดจำกัดที่ 5 MB กรุณาย่อขนาดรูปภาพก่อนอัปโหลด`,
        confirmButtonColor: '#28a745'
    });
}

/**
 * แสดงรูปตัวอย่าง (Preview)
 */
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (!preview) return;

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}