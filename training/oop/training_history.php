<?php
/* training/oop/training_history.php */
// session_start();
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../../config/permission.php';

$db = db();
$db->set_charset('utf8mb4');

$user_level      = isset($_SESSION['user_instrument']) ? (int)$_SESSION['user_instrument'] : 0;
$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$user_dept       = isset($_SESSION['user_department']) ? $_SESSION['user_department'] : '';

$is_full_page = isset($_GET['tid']);

// 1. กำหนดจำนวนแถวต่อหน้า
$limit  = 7;
$page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// 2. Query นับจำนวนแถวทั้งหมด
$sql_count  = "SELECT COUNT(*) AS total FROM instrument_training";
$res_count  = $db->query($sql_count);
$total_rows = $res_count->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// 3. ✅ Query เดียว พร้อม LIMIT OFFSET — ไม่ query ซ้ำใน tbody อีกแล้ว
$sql = "SELECT t.*,
               GROUP_CONCAT(m.atm_model_name SEPARATOR ', ') AS instruments,
               GROUP_CONCAT(m.atm_model_id   SEPARATOR ',')  AS ins_id_list
        FROM instrument_training t
        LEFT JOIN instrument_training_items ti ON t.training_id = ti.training_id
        LEFT JOIN automate_model m ON ti.instrument_id = m.atm_model_id
        GROUP BY t.training_id
        ORDER BY t.training_id DESC
        LIMIT $limit OFFSET $offset";
$res = $db->query($sql);

// เก็บข้อมูลไว้ใช้ทั้ง desktop table และ mobile card
$rows = [];
if ($res && $res->num_rows > 0) {
    while ($r = $res->fetch_assoc()) $rows[] = $r;
}

// helper แสดง badge สถานะ
function statusBadge(int $st): string {
    return match($st) {
        1       => '<span class="badge rounded-pill bg-success px-3 py-2 text-white"><i class="bi bi-check-circle-fill me-1"></i>เสร็จสิ้น</span>',
        2       => '<span class="badge rounded-pill bg-secondary px-3 py-2 text-white"><i class="bi bi-x-circle-fill me-1"></i>ยกเลิก</span>',
        default => '<span class="badge rounded-pill bg-warning text-dark px-3 py-2"><i class="bi bi-hourglass-split me-1"></i>ดำเนินการ</span>',
    };
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>Automate Guide</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>assets/imgs/logo/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= TRAIN_CSS_URL ?>training_history.css?v=<?= time() ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* ── Mobile card ── */
        .train-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            padding: 1rem 1rem .85rem;
            margin-bottom: .65rem;
            cursor: pointer;
            transition: box-shadow .15s, transform .1s;
        }
        .train-card:active { transform: scale(.99); }
        .train-card:hover  { box-shadow: 0 4px 18px rgba(0,0,0,.09); }
        .train-card .card-topic { font-weight: 600; font-size: .95rem; color: #212529; }
        .train-card .card-meta  { font-size: .78rem; color: #6c757d; }

        /* ── Responsive show/hide ── */
        @media (max-width: 767.98px) {
            .desktop-only { display: none !important; }
            .mobile-only  { display: block !important; }
        }
        @media (min-width: 768px) {
            .desktop-only { display: block !important; }
            .mobile-only  { display: none !important; }
        }
    </style>
</head>
<body>

<div class="container py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #2c3e50;">
                <i class="bi bi-clock-history me-2" style="color: var(--primary-color);"></i>
                <?= $is_full_page ? 'รายละเอียดการเทรน' : 'ประวัติการเทรน' ?>
            </h2>
        </div>
        <a href="<?= BASE_URL ?>?act=manual_guide" class="btn btn-outline-dark btn-sm rounded-pill shadow-sm">
            <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
        </a>
    </div>

    <?php if ($is_full_page): ?>
        <!-- ===== Full detail ===== -->
        <div class="container py-2">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
                <div id="full_page_content">
                    <div class="text-center p-5">
                        <div class="spinner-border text-warning" role="status"></div>
                        <p class="mt-2 text-muted">กำลังโหลดรายละเอียด...</p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#full_page_content').load('?act=update_training_detail&mode=full&training_id=<?= (int)$_GET['tid'] ?>');
            });
        </script>

    <?php else: ?>

        <?php if (!empty($rows)): ?>

        <!-- ── Desktop: Table ── -->
        <div class="desktop-only card card-custom shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 35%">หัวข้อการเทรน</th>
                                <th style="width: 30%">เครื่องตรวจ</th>
                                <th style="width: 15%">สถานที่</th>
                                <th style="width: 15%">วัน-เวลา</th>
                                <th style="width: 5%" class="text-center">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr onclick="window.location.href='?act=training_history&tid=<?= $row['training_id'] ?>'" style="cursor: pointer;">
                                    <td>
                                        <div class="training-topic fw-bold text-dark" title="<?= htmlspecialchars($row['training_topic']) ?>">
                                            <?= htmlspecialchars($row['training_topic']) ?>
                                            <a href="?act=training_history&tid=<?= $row['training_id'] ?>"
                                               class="ms-2 text-primary shadow-none"
                                               onclick="event.stopPropagation();" title="ดูหน้าขยาย">
                                                <i class="bi bi-link-45deg" style="font-size: 0.85rem;"></i>
                                            </a>
                                        </div>
                                        <?php if (!empty($row['training_detail'])): ?>
                                            <div class="text-muted small mt-1">
                                                <i class="bi bi-file-text me-1"></i>
                                                <?= mb_substr(htmlspecialchars($row['training_detail']), 0, 35) . (mb_strlen($row['training_detail']) > 35 ? '…' : '') ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="instruments-container d-flex flex-wrap gap-1">
                                            <?php foreach (explode(', ', $row['instruments'] ?? '') as $ins): if (!$ins) continue; ?>
                                                <span class="badge-instrument">
                                                    <i class="bi bi-hdd-stack"></i> <?= htmlspecialchars($ins) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                            <?= htmlspecialchars($row['training_location'] ?: '-') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small fw-bold mb-1">
                                            <i class="bi bi-calendar3 me-1 text-muted"></i>
                                            <?= date('d/m/Y', strtotime($row['training_start'])) ?>
                                        </div>
                                        <div class="small">
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2 py-1">
                                                <i class="bi bi-clock me-1"></i>
                                                <?= date('H:i', strtotime($row['training_start'])) ?> - <?= date('H:i', strtotime($row['training_end'])) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= statusBadge((int)$row['training_status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ── Mobile: Cards ── -->
        <div class="mobile-only">
            <?php foreach ($rows as $row): ?>
            <div class="train-card" onclick="window.location.href='?act=training_history&tid=<?= $row['training_id'] ?>'">

                <!-- หัวข้อ + สถานะ -->
                <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                    <div class="card-topic"><?= htmlspecialchars($row['training_topic']) ?></div>
                    <?= statusBadge((int)$row['training_status']) ?>
                </div>

                <!-- รายละเอียด -->
                <?php if (!empty($row['training_detail'])): ?>
                    <div class="card-meta mb-1">
                        <i class="bi bi-file-text me-1"></i>
                        <?= mb_substr(htmlspecialchars($row['training_detail']), 0, 55) . (mb_strlen($row['training_detail']) > 55 ? '…' : '') ?>
                    </div>
                <?php endif; ?>

                <!-- สถานที่ + วันเวลา -->
                <div class="card-meta mb-2">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i><?= htmlspecialchars($row['training_location'] ?: '-') ?>
                    &nbsp;·&nbsp;
                    <i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y', strtotime($row['training_start'])) ?>
                    &nbsp;
                    <i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($row['training_start'])) ?>–<?= date('H:i', strtotime($row['training_end'])) ?>
                </div>

                <!-- เครื่องตรวจ -->
                <?php if (!empty($row['instruments'])): ?>
                    <div class="d-flex flex-wrap gap-1">
                        <?php foreach (explode(', ', $row['instruments']) as $ins): if (!$ins) continue; ?>
                            <span class="badge-instrument">
                                <i class="bi bi-hdd-stack"></i> <?= htmlspecialchars($ins) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
            <?php endforeach; ?>
        </div>

        <?php else: ?>
            <div class="text-center p-5 text-muted">
                <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>ไม่พบประวัติการเทรน
            </div>
        <?php endif; ?>

        <!-- ===== Pagination ===== -->
        <?php if ($total_pages > 1): ?>
        <div class="d-flex flex-column align-items-center mt-3 px-3 pb-3">
            <div class="text-muted small mb-2">
                แสดง <?= number_format($offset + 1) ?>–<?= number_format(min($offset + $limit, $total_rows)) ?>
                จาก <?= number_format($total_rows) ?> รายการ
            </div>
            <nav>
                <ul class="pagination pagination-sm justify-content-center mb-0">

                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link shadow-sm mx-1 rounded-3" href="?act=training_history&page=<?= $page - 1 ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>

                    <?php
                    $window = 2;
                    $prev   = null;
                    for ($i = 1; $i <= $total_pages; $i++):
                        $show = ($i == 1 || $i == $total_pages || abs($i - $page) <= $window);
                        if (!$show) {
                            if ($prev !== null && $prev !== '...') {
                                echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                                $prev = '...';
                            }
                            continue;
                        }
                    ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                            <a class="page-link shadow-sm mx-1 rounded-3" href="?act=training_history&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php $prev = $i; endfor; ?>

                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link shadow-sm mx-1 rounded-3" href="?act=training_history&page=<?= $page + 1 ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
        <?php endif; ?>

    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= TRAIN_JS_URL ?>training_history.js?v=<?= time() ?>"></script>

<?php if (isset($_GET['status'])): ?>
    <script>
        $(document).ready(function() {
            const status = "<?= $_GET['status'] ?>";
            if (status === 'update_success') {
                Swal.fire({ icon: 'success', title: 'บันทึกสำเร็จ', timer: 2000, showConfirmButton: false });
            }
        });
    </script>
<?php endif; ?>

</body>
</html>
