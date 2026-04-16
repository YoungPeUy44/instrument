<?php
/* instrument/config/footer.php */
?>
<footer class="main-footer py-2 bg-white border-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-1 mb-md-0">
                <span class="copyright-text">
                    Copyright © 2025 - <?= date('Y') ?> <span class="d-none d-sm-inline">|</span> 
                    <span class="fw-semibold">Support The Operation, Executive App.</span>
                </span>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <span class="version-text text-muted">
                    <i class="bi bi-info-circle me-1"></i>Version 2.1
                </span>
            </div>
        </div>
    </div>
</footer>

<style>
    .main-footer {
        /* ปรับฟอนต์ให้เล็กลงจาก 0.85 เป็น 0.75-0.80 */
        font-size: 0.78rem; 
        background-color: #ffffff;
        color: #6c757d; /* สีเทามาตรฐาน Bootstrap (text-muted) */
    }

    .copyright-text strong, .copyright-text .fw-semibold {
        color: #495057; /* สีเทาเข้มกว่านิดหน่อยสำหรับเน้นชื่อ */
    }

    .version-text {
        font-size: 0.72rem;
        letter-spacing: 0.3px;
    }

    /* ปรับระยะห่างให้เหลือน้อยที่สุด */
    .main-footer.py-2 {
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
    }

    /* สำหรับมือถือ ให้ระยะห่างแคบลงอีก */
    @media (max-width: 768px) {
        .main-footer {
            padding: 0.6rem 0 !important;
        }
        .copyright-text {
            display: block;
            margin-bottom: 2px;
        }
    }
</style>