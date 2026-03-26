/* training/assets/js/train_form.js */

const selectAllCheckbox = document.getElementById('selectAll');
const instrumentCheckboxes = document.querySelectorAll('.ins-checkbox');
const selectedCountSpan = document.getElementById('selectedCount');
const searchInput = document.getElementById('searchIns');
const instrumentItems = document.querySelectorAll('.instrument-item');

/**
 * 1. ฟังก์ชันอัปเดตจำนวนที่เลือกและไฮไลท์แถว (selected class)
 */
function updateSelectedCount() {
    const checked = document.querySelectorAll('.ins-checkbox:checked');
    const count = checked.length;
    if (selectedCountSpan) selectedCountSpan.textContent = count;
    
    if (selectAllCheckbox) {
        // นับเฉพาะตัวที่เลือกได้ (ไม่โดน disabled)
        const enabledCheckboxes = Array.from(instrumentCheckboxes).filter(cb => !cb.disabled);
        const enabledCheckedCount = Array.from(checked).filter(cb => !cb.disabled).length;

        if (enabledCheckedCount === enabledCheckboxes.length && enabledCheckboxes.length > 0) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.indeterminate = false;
        } else if (enabledCheckedCount > 0 && enabledCheckedCount < enabledCheckboxes.length) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = true;
        } else {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        }
    }
    
    // เพิ่ม/ลบคลาส selected เพื่อเปลี่ยนสีพื้นหลังแถว
    instrumentItems.forEach(item => {
        const checkbox = item.querySelector('.ins-checkbox');
        if (checkbox && checkbox.checked) {
            item.classList.add('selected');
        } else {
            item.classList.remove('selected');
        }
    });
}

/**
 * 2. ระบบ Select All (กรองเฉพาะสถานะ 2=ไม่พร้อม และ 3=รอเทรน และต้องมองเห็นอยู่)
 */
if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', function(e) {
        const isChecked = e.target.checked;
        instrumentItems.forEach(item => {
            const isVisible = item.style.display !== 'none';
            const statusId = item.getAttribute('data-status-id'); 
            const checkbox = item.querySelector('.ins-checkbox');

            if (isVisible && checkbox && (statusId === '2' || statusId === '3')) {
                checkbox.checked = isChecked;
            }
        });
        updateSelectedCount();
    });
}

/**
 * 3. ผูก Event ให้ Checkbox แต่ละตัว และทำให้แถวคลิกเพื่อเลือกได้
 */
instrumentItems.forEach(item => {
    const checkbox = item.querySelector('.ins-checkbox');
    if (checkbox) {
        // เมื่อสถานะ checkbox เปลี่ยน
        checkbox.addEventListener('change', updateSelectedCount);
        
        // ทำให้คลิกที่พื้นที่แถวแล้วเป็นการติ๊ก checkbox (ยกเว้นคลิกโดนตัว checkbox ตรงๆ)
        item.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox' && !checkbox.disabled) {
                checkbox.checked = !checkbox.checked;
                updateSelectedCount();
            }
        });
    }
});

/**
 * 4. ระบบค้นหา (Search) - ฉบับแก้ไขให้ทำงานร่วมกับ ID searchIns
 */
if (searchInput) {
    searchInput.addEventListener('input', function(e) {
        // 1. รับค่าและจัดการช่องว่าง
        const searchTerm = e.target.value.toLowerCase().trim();
        
        // 2. วนลูปเช็ค instrument-item ทุกตัว
        instrumentItems.forEach(item => {
            // ดึงชื่อเครื่องจาก Attribute หรือจากเนื้อหา h6 (ตัวหนา)
            const nameFromAttr = item.getAttribute('data-name') || '';
            const nameFromText = item.querySelector('.fw-bold')?.textContent || '';
            
            const fullName = (nameFromAttr + ' ' + nameFromText).toLowerCase();
            
            // 3. ตรวจสอบว่าตรงกับคำค้นหาไหม
            if (searchTerm === '' || fullName.includes(searchTerm)) {
                // แสดงผล (ใช้ flex เพื่อให้สัดส่วนการ์ดไม่เพี้ยน)
                item.style.setProperty('display', 'flex', 'important');
            } else {
                // ซ่อน
                item.style.setProperty('display', 'none', 'important');
            }
        });

        // 4. อัปเดตจำนวน (เผื่อมีตัวที่เลือกไว้แต่โดนซ่อน)
        updateSelectedCount();
    });
}

/**
 * 5. ระบบส่งฟอร์ม (Validation + SweetAlert2)
 */
const trainForm = document.getElementById('trainForm');
if (trainForm) {
    trainForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const topic = document.querySelector('[name="training_topic"]').value;
        const location = document.querySelector('[name="training_location"]').value;
        const start = document.querySelector('[name="training_start"]').value;
        const end = document.querySelector('[name="training_end"]').value;
        const detail = document.querySelector('[name="training_detail"]').value;
        const createdBy = document.querySelector('[name="created_by"]').value;

        // --- ตรวจสอบเวลาเริ่มต้นและสิ้นสุด ---
        if (start && end) {
            const startDate = new Date(start);
            const endDate = new Date(end);

            if (endDate <= startDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'ช่วงเวลาไม่ถูกต้อง',
                    text: 'เวลาเริ่มต้นต้องน้อยกว่าเวลาสิ้นสุด กรุณาตรวจสอบอีกครั้ง',
                    confirmButtonColor: '#ffc107',
                });
                return false;
            }
        }
        
        // --- ดึงข้อมูล ID และ ชื่อเครื่องตรวจ ---
        const selectedCheckboxes = document.querySelectorAll('.ins-checkbox:checked');
        const instrumentsData = Array.from(selectedCheckboxes).map(cb => {
            const parentItem = cb.closest('.instrument-item');
            return {
                id: cb.value,
                name: parentItem.querySelector('.fw-bold').textContent.trim()
            };
        });

        if (instrumentsData.length === 0) {
            Swal.fire('ไม่พบเครื่องตรวจ', '⚠️ กรุณาเลือกเครื่องตรวจอย่างน้อย 1 เครื่อง', 'error');
            return;
        }

        // --- สร้างรายการ HTML (แบ่ง 2 คอลัมน์เพื่อประหยัดพื้นที่และลด scroll) ---
        const instrumentListHtml = instrumentsData
            .map(ins => `<li class="mb-1 small"><strong>ID ${ins.id}:</strong> ${ins.name}</li>`)
            .join('');

        // --- แสดง SweetAlert2 สรุปข้อมูล ---
        Swal.fire({
            title: 'ยืนยันการบันทึกนัดหมาย',
            html: `
                <div class="text-start p-2">
                    <p class="mb-1"><strong>หัวข้อ:</strong> ${topic}</p>
                    <p class="mb-1"><strong>สถานที่:</strong> ${location || '-'}</p>
                    <p class="mb-1"><strong>เริ่ม:</strong> ${start.replace('T', ' ')}</p>
                    <p class="mb-1"><strong>สิ้นสุด:</strong> ${end.replace('T', ' ')}</p>
                    <p class="mb-1"><strong>ผู้บันทึก:</strong> ${createdBy}</p>
                    <hr class="my-2">
                    <p class="text-primary fw-bold mb-2">เครื่องตรวจที่เลือก (${instrumentsData.length} เครื่อง):</p>
                    <ul class="ps-3 mb-0" style="list-style-type: decimal; column-count: ${instrumentsData.length > 10 ? '2' : '1'};">
                        ${instrumentListHtml}
                    </ul>
                </div>
            `,
            icon: 'question',
            width: '600px',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ยืนยันและส่งข้อมูล',
            cancelButtonText: 'แก้ไขข้อมูล',
            customClass: {
                htmlContainer: 'no-scrollbar' // ใช้คลาสเพื่อคุมไม่ให้มีแถวเลื่อนถ้าไม่จำเป็น
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ 
                    title: 'กำลังบันทึก...', 
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); } 
                });
                this.submit(); 
            }
        });
    });
}

// รันครั้งแรกเมื่อโหลดหน้า
updateSelectedCount();