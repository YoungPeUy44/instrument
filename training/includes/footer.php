<?php /* instrument/config/footer.php */ ?>

<footer class="main-footer" style="font-size: 12px;">
    <span>
        <strong>&copy; 2024–<?= date('Y') ?> Logins Medical</strong>
        · Executive App
    </span>
    <span class="footer-version">
        <b>Version</b> 2.2
    </span>
</footer>

<style>
    html, body {
        height: 100%;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    /* container หลักขยายเต็มพื้นที่ที่เหลือ ดัน footer ลงล่าง */
    body > .container {
        flex: 1;
    }

    .main-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 1.25rem;
        font-size: 0.78rem;
        color: #6c757d;
        background-color: #ffffff;
        border-top: 1px solid #dee2e6;
        margin-top: auto;
    }

    @media (max-width: 576px) {
        .main-footer {
            flex-direction: column;
            gap: 2px;
            text-align: center;
        }
    }
</style>