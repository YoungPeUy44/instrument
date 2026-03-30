<?php
// สมมติว่าต้องการให้เฉพาะสิทธิ์ > 2 (คือระดับ 3 เท่านั้น) เข้าได้
// ถ้าสิทธิ์ "น้อยกว่าหรือเท่ากับ 2" ให้ดีดกลับ
if (!isset($_SESSION['user_instrument']) || (int)$_SESSION['user_instrument'] < 2) { 
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'จำกัดการเข้าถึง!',
                text: 'คุณไม่มีสิทธิ์ดำเนินการในส่วนนี้ กรุณาติดต่อผู้ดูแลระบบ',
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#ffc107',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // 🔙 ดีดกลับไปหน้าก่อนหน้า
                    window.history.back(); 
                }
            });
        });
    </script>";
    exit; // หยุดการทำงานของ PHP ทันที
}
?>

<?php
/* training/oop/train_form.php */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/helpers.php';

$db = db();
$db->set_charset('utf8mb4');

// ดึงข้อมูลเครื่องตรวจ พร้อมสถานะเพื่อใช้ในการกรอง (ref_atm_status_manual_id)
$sql = "SELECT i.ins_id, m.atm_model_name, m.ref_atm_status_manual_id
        FROM instruments i 
        INNER JOIN automate_model m ON i.ins_id = m.atm_model_id
        WHERE ref_atm_status_manual_id=3
        ORDER BY m.atm_model_name ASC";
$res = $db->query($sql);
$instruments = $res->fetch_all(MYSQLI_ASSOC);

// ดึงชื่อผู้ใช้ปัจจุบันจาก Session ที่ตรวจพบคือก่อนหน้านี้
$fname = $_SESSION['user_firstname'] ?? '';
$lname = $_SESSION['user_lastname'] ?? '';
$current_user = trim($fname . " " . $lname);
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>นัดหมายการเทรนเครื่องตรวจ</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>assets/imgs/logo/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?= TRAIN_CSS_URL ?>train_form.css?v=<?= time() ?>">
</head>
<body>

    <div class="container py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1" style="color: #2c3e50;">
                    <i class="bi bi-calendar-check-fill" style="color: #ffc107;"></i> 
                    นัดหมายการเทรนเครื่องตรวจ
                </h2>
                <p class="text-muted small">สร้างรายการนัดหมายและเลือกเครื่องมือที่ต้องการเปลี่ยนสถานะเป็น "รอเทรน"</p>
            </div>
            <a href="<?= BASE_URL ?>?act=manual_guide" class="btn btn-outline-dark btn-sm rounded-pill">
                <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
            </a>
        </div>

        <form id="trainForm" action="<?= TRAIN_DB_URL ?>save_training.php" method="POST">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 20px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-info-circle-fill me-2 text-warning"></i>
                                รายละเอียดการนัดหมาย
                            </h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">หัวข้อการนัดหมาย <span class="text-danger">*</span></label>
                                <input type="text" name="training_topic" class="form-control" placeholder="เช่น การใช้งานเบื้องต้นประจำปี" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">สถานที่ <span class="text-danger">*</span></label>
                                <input type="text" name="training_location" class="form-control" placeholder="ห้องปฏิบัติการ / ตึก / ชั้น..." required>
                            </div>
                            <!-- เวลา -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-semibold small">
                                        <i class="bi bi-calendar-plus me-1"></i> เริ่มเวลา <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                        id="training_start" 
                                        name="training_start" 
                                        class="form-control bg-white" 
                                        placeholder="เลือกวัน/เวลาเริ่ม"
                                        readonly
                                        required>
                                    <small class="text-muted" id="startDisplay"></small>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold small">
                                        <i class="bi bi-calendar-minus me-1"></i> สิ้นสุดเวลา <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                        id="training_end" 
                                        name="training_end" 
                                        class="form-control bg-white" 
                                        placeholder="เลือกวัน/เวลาสิ้นสุด"
                                        readonly
                                        required>
                                    <small class="text-muted" id="endDisplay"></small>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold small">รายละเอียดเพิ่มเติม</label>
                                <textarea name="training_detail" class="form-control" rows="3" placeholder="ระบุข้อมูลเพิ่มเติม..."></textarea>
                            </div>

                            <div class="p-3 bg-light rounded-3 mb-4 border border-dashed">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle fs-4 me-2 text-secondary"></i>
                                    <div>
                                        <div class="small text-muted mb-0" style="font-size: 0.75rem;">ผู้นัดเทรน / ผู้บันทึก</div>
                                        <div class="fw-bold text-dark">
                                            <?= !empty($current_user) ? htmlspecialchars($current_user) : 'ระบบ (ไม่ระบุชื่อ)' ?>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="created_by" value="<?= htmlspecialchars($current_user) ?>">
                            </div>
                            
                            <button type="submit" class="btn btn-warning w-100 fw-bold py-2 rounded-3 shadow-sm">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i> บันทึกข้อมูลนัดหมาย
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">
                                    <i class="bi bi-hdd-stack-fill me-2 text-warning"></i>
                                    เลือกเครื่องตรวจ
                                    <span class="badge bg-warning text-dark rounded-pill ms-2" id="selectedCount" style="font-size: 0.8rem;">0</span>
                                </h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                    <label class="form-check-label small fw-bold" for="selectAll">เลือกทั้งหมด </label>
                                </div>
                            </div>
                            
                            <div class="position-relative mb-3">
                                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                <input type="text" id="searchIns" class="form-control ps-5 rounded-pill" placeholder="ค้นหาชื่อเครื่องตรวจ...">
                            </div>
                            
                            <div class="instrument-list" style="max-height: 500px; overflow-y: auto;">
                                <?php foreach ($instruments as $row): 
                                    $status_id = $row['ref_atm_status_manual_id'];
                                    
                                    // กำหนดชื่อและสีสถานะ
                                    $status_text = 'พร้อม';
                                    $badge_color = 'bg-success'; 

                                    if ($status_id == 2) {
                                        $status_text = 'ไม่พร้อม';
                                        $badge_color = 'bg-secondary'; 
                                    } else if ($status_id == 3) {
                                        $status_text = 'รอเทรน';
                                        $badge_color = 'bg-warning text-dark'; 
                                    }

                                    // เงื่อนไขการเลือก (เฉพาะ 2 และ 3)
                                    $can_select = ($status_id == 2 || $status_id == 3);
                                ?>
                                    <div class="instrument-item d-flex align-items-center p-3 mb-2 border rounded-3" 
                                        data-name="<?= strtolower(htmlspecialchars($row['atm_model_name'])) ?>" 
                                        data-status-id="<?= $status_id ?>"
                                        style="<?= !$can_select ? 'opacity: 0.6; background-color: #f8f9fa; cursor: not-allowed;' : 'cursor: pointer;' ?>">
                                        
                                        <div class="me-3">
                                            <input type="checkbox" name="ins_ids[]" class="ins-checkbox form-check-input" 
                                                value="<?= $row['ins_id'] ?>" 
                                                <?= !$can_select ? 'disabled' : '' ?>
                                                style="width: 20px; height: 20px;">
                                        </div>
                                        
                                        <div class="flex-grow-1">
                                            <div class="fw-bold text-dark small"><?= htmlspecialchars($row['atm_model_name']) ?></div>
                                            <span class="badge rounded-pill <?= $badge_color ?>" style="font-size: 0.65rem;">
                                                <?= $status_text ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. ดึง Query String จาก URL
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    // 2. ถ้า status ตรงกับที่ส่งมาจาก save_training.php
    if (status === 'train_success') {
        const Toast = Swal.mixin({
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

        Toast.fire({
            icon: 'success',
            title: 'บันทึกข้อมูลนัดหมายเรียบร้อยแล้ว',
            background: '#ffffff',
            iconColor: '#28a745',
            customClass: {
                popup: 'colored-toast'
            }
        });

        // (Optional) ลบ query string ออกจาก URL เพื่อไม่ให้เด้งซ้ำตอน Refresh หน้า
        window.history.replaceState({}, document.title, window.location.pathname + (window.location.search.replace(/[?&]status=train_success/, '').replace(/^&/, '?')));
    }
});
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('status') === 'error') {
    const errorMsg = urlParams.get('msg');
    Swal.fire({
        icon: 'error',
        title: 'บันทึกไม่สำเร็จ',
        text: errorMsg, // จะแสดงข้อความ "เวลาเริ่มต้นต้องน้อยกว่าเวลาสิ้นสุด"
        confirmButtonColor: '#dc3545',
    });
}
// กำหนดค่าเริ่มต้นของ Flatpickr
document.addEventListener('DOMContentLoaded', function() {
    // ตั้งค่าเริ่มต้นเวลาเริ่มต้นเป็น +1 ชั่วโมง, เวลาสิ้นสุดเป็น +2 ชั่วโมง
    const now = new Date();
    const defaultStart = new Date(now);
    defaultStart.setHours(now.getHours() + 1);
    defaultStart.setMinutes(0);
    
    const defaultEnd = new Date(now);
    defaultEnd.setHours(now.getHours() + 2);
    defaultEnd.setMinutes(0);
    
    // ฟังก์ชันแปลงวันที่เป็นรูปแบบ Y-m-d H:i
    function formatDateTime(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${year}-${month}-${day} ${hours}:${minutes}`;
    }
    
    // ฟังก์ชันแปลงวันที่เป็นรูปแบบแสดงผล
    function formatDisplayDateTime(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear() + 543; // แปลงเป็น พ.ศ.
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${day}/${month}/${year} ${hours}:${minutes} น.`;
    }
    
    // ตัวเลือกของ Flatpickr
    const dateConfig = {
        enableTime: true,
        time_24hr: true,                    // ใช้เวลา 24 ชั่วโมง
        dateFormat: "Y-m-d H:i",            // รูปแบบที่จะส่งไป backend
        minuteIncrement: 1,                 // เพิ่มนาทีทีละ 1
        allowInput: true,                   // ให้พิมพ์เองได้
        locale: 'th',                       // ภาษาไทย
        static: true,                       // ป้องกันการเลื่อนตาม scroll
        onOpen: function(selectedDates, dateStr, instance) {
            // ปรับตำแหน่งให้แสดงถูกต้อง
        },
        onChange: function(selectedDates, dateStr, instance) {
            // อัปเดตข้อความแสดง
            if (instance.element.id === 'training_start') {
                const displaySpan = document.getElementById('startDisplay');
                if (displaySpan && selectedDates[0]) {
                    displaySpan.innerHTML = `<i class="bi bi-clock"></i> ${formatDisplayDateTime(selectedDates[0])}`;
                }
                validateDateTime();
            } else if (instance.element.id === 'training_end') {
                const displaySpan = document.getElementById('endDisplay');
                if (displaySpan && selectedDates[0]) {
                    displaySpan.innerHTML = `<i class="bi bi-clock"></i> ${formatDisplayDateTime(selectedDates[0])}`;
                }
                validateDateTime();
            }
        }
    };
    
    // เริ่มต้น Flatpickr
    const startPicker = flatpickr("#training_start", {
        ...dateConfig,
        defaultDate: formatDateTime(defaultStart),
        minDate: "today",
        onChange: function(selectedDates, dateStr, instance) {
            // เมื่อเลือกเวลาเริ่มต้น ให้ตั้งเวลาสิ้นสุดขั้นต่ำเป็นเวลาเริ่มต้น
            if (selectedDates[0] && endPicker) {
                endPicker.set('minDate', selectedDates[0]);
                
                // ถ้าเวลาสิ้นสุดน้อยกว่าเวลาเริ่มต้น ให้ปรับเวลาสิ้นสุด
                const endDate = endPicker.selectedDates[0];
                if (endDate && endDate <= selectedDates[0]) {
                    const newEnd = new Date(selectedDates[0]);
                    newEnd.setHours(selectedDates[0].getHours() + 1);
                    endPicker.setDate(newEnd);
                }
            }
            const displaySpan = document.getElementById('startDisplay');
            if (displaySpan && selectedDates[0]) {
                displaySpan.innerHTML = `<i class="bi bi-clock"></i> ${formatDisplayDateTime(selectedDates[0])}`;
            }
            validateDateTime();
        }
    });
    
    const endPicker = flatpickr("#training_end", {
        ...dateConfig,
        defaultDate: formatDateTime(defaultEnd),
        minDate: defaultStart,
        onChange: function(selectedDates, dateStr, instance) {
            const displaySpan = document.getElementById('endDisplay');
            if (displaySpan && selectedDates[0]) {
                displaySpan.innerHTML = `<i class="bi bi-clock"></i> ${formatDisplayDateTime(selectedDates[0])}`;
            }
            validateDateTime();
        }
    });
    
    // ฟังก์ชันตรวจสอบเวลา
    function validateDateTime() {
        const startInput = document.getElementById('training_start');
        const endInput = document.getElementById('training_end');
        
        if (startInput && endInput && startInput.value && endInput.value) {
            const startDate = new Date(startInput.value);
            const endDate = new Date(endInput.value);
            
            if (endDate <= startDate) {
                // แสดงข้อความเตือน (ไม่บังคับ ให้แค่เตือน)
                const endDisplay = document.getElementById('endDisplay');
                if (endDisplay) {
                    endDisplay.innerHTML = `<i class="bi bi-exclamation-triangle text-warning"></i> เวลาสิ้นสุดต้องมากกว่าเวลาเริ่มต้น`;
                }
                return false;
            } else {
                const endDisplay = document.getElementById('endDisplay');
                if (endDisplay && endPicker.selectedDates[0]) {
                    endDisplay.innerHTML = `<i class="bi bi-clock"></i> ${formatDisplayDateTime(endPicker.selectedDates[0])}`;
                }
                return true;
            }
        }
        return true;
    }
    
    // เพิ่มปุ่มล้างค่า (optional)
    function addClearButtons() {
        const startContainer = document.getElementById('training_start')?.parentNode;
        const endContainer = document.getElementById('training_end')?.parentNode;
        
        if (startContainer && !startContainer.querySelector('.clear-btn')) {
            const clearStart = document.createElement('button');
            clearStart.type = 'button';
            clearStart.className = 'btn btn-sm btn-outline-secondary mt-1 clear-btn';
            clearStart.innerHTML = '<i class="bi bi-x-circle"></i> ล้าง';
            clearStart.onclick = () => {
                startPicker.clear();
                document.getElementById('startDisplay').innerHTML = '';
            };
            startContainer.appendChild(clearStart);
        }
        
        if (endContainer && !endContainer.querySelector('.clear-btn')) {
            const clearEnd = document.createElement('button');
            clearEnd.type = 'button';
            clearEnd.className = 'btn btn-sm btn-outline-secondary mt-1 clear-btn';
            clearEnd.innerHTML = '<i class="bi bi-x-circle"></i> ล้าง';
            clearEnd.onclick = () => {
                endPicker.clear();
                document.getElementById('endDisplay').innerHTML = '';
            };
            endContainer.appendChild(clearEnd);
        }
    }
    
    // addClearButtons();
    
    // แสดงข้อความเริ่มต้น
    const startDisplay = document.getElementById('startDisplay');
    if (startDisplay && startPicker.selectedDates[0]) {
        startDisplay.innerHTML = `<i class="bi bi-clock"></i> ${formatDisplayDateTime(startPicker.selectedDates[0])}`;
    }
    
    const endDisplay = document.getElementById('endDisplay');
    if (endDisplay && endPicker.selectedDates[0]) {
        endDisplay.innerHTML = `<i class="bi bi-clock"></i> ${formatDisplayDateTime(endPicker.selectedDates[0])}`;
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= TRAIN_JS_URL ?>train_form.js?v=<?= time() ?>"></script>
</body>
</html>