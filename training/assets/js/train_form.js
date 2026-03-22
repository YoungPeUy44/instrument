/* training/assets/js/train_form.js */

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchIns');
    const checkboxes = document.querySelectorAll('.ins-checkbox');
    const selectAll = document.getElementById('selectAll');
    const selectedCount = document.getElementById('selectedCount');
    const trainForm = document.getElementById('trainForm');

    // --- 1. ระบบค้นหา Real-time ---
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const items = document.querySelectorAll('.btn-instrument-item');
            
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchText) ? 'flex' : 'none';
            });
        });
    }

    // --- 2. ระบบนับจำนวนที่เลือก ---
    function updateCount() {
        const checked = document.querySelectorAll('.ins-checkbox:checked').length;
        selectedCount.textContent = checked + ' รายการ';
        
        // ถ้าเลือกทั้งหมดจริง ให้ติ๊ก switch Select All ด้วย
        selectAll.checked = (checked === checkboxes.length && checked > 0);
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateCount);
    });

    // --- 3. ระบบเลือกทั้งหมด ---
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const isChecked = this.checked;
            checkboxes.forEach(cb => {
                // ติ๊กเฉพาะรายการที่ไม่ได้ถูกซ่อนจากผลการค้นหา (Optional)
                if (cb.closest('.btn-instrument-item').style.display !== 'none') {
                    cb.checked = isChecked;
                }
            });
            updateCount();
        });
    }

    // --- 4. ตรวจสอบก่อนส่งฟอร์ม ---
    if (trainForm) {
        trainForm.addEventListener('submit', function(e) {
            const checkedCount = document.querySelectorAll('.ins-checkbox:checked').length;
            
            if (checkedCount === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณาเลือกเครื่องตรวจ',
                    text: 'คุณยังไม่ได้เลือกเครื่องมือที่ต้องการจัดเทรนอย่างน้อย 1 รายการ',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            // แสดง Loading
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> กำลังบันทึกนัดหมาย...';
        });
    }
});