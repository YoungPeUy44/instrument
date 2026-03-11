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