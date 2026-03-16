/* assets/js/save_instrument.js */
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('mainUploadForm');
    
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            const fileInputs = this.querySelectorAll('input[type="file"]');
            let totalSize = 0;
            const limit = 50 * 1024 * 1024; // 80MB

            fileInputs.forEach(input => {
                for (let i = 0; i < input.files.length; i++) {
                    totalSize += input.files[i].size;
                }
            });

            if (totalSize > limit) {
                // ✅ หยุดการส่งฟอร์มทันที ไม่ให้ไปถึง PHP
                e.preventDefault(); 
                e.stopPropagation();
                
                Swal.fire({
                    icon: 'error',
                    title: 'ไฟล์ใหญ่เกินไป!',
                    text: `ขนาดรวม ${(totalSize / (1024 * 1024)).toFixed(2)} MB เกินขีดจำกัด 50MB กรุณาลดขนาดรูปก่อนอัปโหลด`,
                    confirmButtonColor: '#d33'
                });
                return false;
            }
        });
    }
});