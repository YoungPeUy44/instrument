document.addEventListener('DOMContentLoaded', function() {
    // เลือก dropdown ทั้งหมดในหน้าจอ
    const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
    
    
    dropdownElementList.forEach(dropdownToggleEl => {
        new bootstrap.Dropdown(dropdownToggleEl, {
            // ⭐ บังคับให้เมนูจัดการลอยไปอยู่ที่ body เพื่อไม่ให้โดนตัดขอบตาราง
            boundary: document.body,
            display: 'dynamic',
            popperConfig: {
                strategy: 'fixed' // บังคับให้ตำแหน่งคงที่เทียบกับหน้าจอ
            }
        });
    });
});

$(document).ready(function() {
    // เมื่อมีการพิมพ์ในช่องค้นหา
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase(); // รับค่าที่พิมพ์และเปลี่ยนเป็นตัวเล็ก

        // สั่งให้ค้นหาในทุก <tr> ภายใน <tbody> ของตารางคู่มือ
        // (ถ้านายใช้ ID อื่นที่ตาราง ให้เปลี่ยนจาก #manualTable เป็น ID นั้น)
        $("#manualTable tbody tr").filter(function() {
            // ถ้าเนื้อหาในแถวนั้นมีคำที่พิมพ์อยู่ ให้โชว์ (Toggle)
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });

        // ✅ (Optional) แสดงข้อความ "ไม่พบข้อมูล" ถ้ากรองแล้วหายหมด
        var visibleRows = $("#manualTable tbody tr:visible").length;
        if (visibleRows === 0) {
            if ($("#no-data-msg").length === 0) {
                $("#manualTable tbody").append('<tr id="no-data-msg"><td colspan="10" class="text-center py-5 text-muted">ไม่พบข้อมูลที่ตรงกับคำค้นหา</td></tr>');
            }
        } else {
            $("#no-data-msg").remove();
        }
    });
});



