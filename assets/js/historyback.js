function smartBack() {
    // 1. ตรวจสอบว่ามีประวัติการเข้าชมใน Tab นี้หรือไม่
    // window.history.length > 1 หมายถึงมีการกดลิงก์ไปมาใน Tab นี้แล้ว
    if (window.history.length > 1) {
        window.history.back();
    } else {
        // 2. ถ้าไม่มีประวัติ (เปิด New Tab มาหน้าแรกเลย) ให้พยายามปิดหน้าต่าง
        window.close();
        
        // 💡 เผื่อกรณี Browser บล็อกคำสั่ง window.close (ส่วนใหญ่จะบล็อกถ้าไม่ได้เปิดด้วย window.open)
        // ให้เด้งกลับไปหน้าหลักแทนเพื่อความปลอดภัย
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 500); 
    }
}