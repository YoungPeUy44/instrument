<?php
/* instrument/config/footer.php */
?>
<footer class="main-footer py-3 bg-white border-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <strong>Copyright © 2025 - <?= date('Y') ?></strong> Support The Operation, Executive Team
            </div>
            <div class="col-md-6 text-center text-md-end text-muted">
                <small>
                    <b>Version</b> 2.0
                </small>
            </div>
        </div>
    </div>
</footer>

<style>
    .main-footer {
        font-size: 0.85rem;
        background-color: #ffffff;
    }
    /* ปรับแต่งระยะห่างสำหรับมือถือ */
    @media (max-width: 768px) {
        .main-footer {
            padding: 1rem 0;
        }
    }
</style>