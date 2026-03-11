// -------- พรีวิวภาพหน้าปก --------
const fileInput = document.getElementById('equipmentImage');
if (fileInput) {
  fileInput.addEventListener('change', (e) => {
    const file = e.target.files && e.target.files[0];
    if (!file) return;
    const img = document.querySelector('img.cover');
    if (!img) return;
    const reader = new FileReader();
    reader.onload = ev => { img.src = ev.target.result; };
    reader.readAsDataURL(file);
  });
}

// -------- ขยาย textarea อัตโนมัติขณะพิมพ์ (ไม่กระทบบันทึก) --------
function autoGrow(el) {
  el.style.height = 'auto';
  el.style.height = (el.scrollHeight + 6) + 'px';
}
document.querySelectorAll('textarea.js-autogrow').forEach(el => {
  autoGrow(el);
  el.addEventListener('input', () => autoGrow(el));
});

// -------- ปิด autocomplete แบบกันเหนียวในระดับฟิลด์ (กรณีบางเบราว์เซอร์ไม่เชื่อฟอร์ม) --------
const nameInput = document.querySelector('input[name="name"]');
if (nameInput) {
  nameInput.setAttribute('autocomplete', 'new-password');
}
async function saveOrder(listEl) {
  if (!listEl) return;
  const insId = listEl.dataset.ins;   // ← ดึงจาก data-ins
  const type  = listEl.dataset.type;  // 'setup' หรือ 'run'
  const ids   = [...listEl.querySelectorAll('.image-item')].map(li => li.dataset.id);

  if (!insId || !type || ids.length === 0) {
    alert('ข้อมูลไม่ครบ: instrument_id หรือ type หรือรายการภาพหายไป');
    return;
  }

  const form = new FormData();
  form.append('instrument_id', insId);
  form.append('type', type);
  form.append('order', JSON.stringify(ids));  // ส่งเป็น JSON string

  try {
    const res = await fetch('reorder_images.php', { method: 'POST', body: form });
    const text = await res.text();

    if (text.trim().toUpperCase().includes('OK')) {
      alert('✅ บันทึกลำดับเรียบร้อย');
    } else {
      alert('⚠️ เซิร์ฟเวอร์ตอบกลับไม่ถูกต้อง: ' + text);
    }
  } catch (err) {
    alert('❌ เกิดข้อผิดพลาดในการเชื่อมต่อ: ' + err.message);
  }
}

document.getElementById('saveSetupOrder')?.addEventListener('click', e => {
  e.preventDefault(); saveOrder(document.getElementById('setupList'));
});
document.getElementById('saveRunOrder')?.addEventListener('click', e => {
  e.preventDefault(); saveOrder(document.getElementById('runList'));
});

// assets/edit.js (final)
// - ปุ่ม #saveSetupOrder / #saveRunOrder จะ POST ไป re_images.php
// - ส่ง instrument_id, type, order เป็น JSON

async function saveOrder(listEl) {
  if (!listEl) return alert('ไม่พบรายการภาพ');
  const insId = listEl.dataset.ins;
  const type  = listEl.dataset.type;
  const ids   = [...listEl.querySelectorAll('.image-item')].map(li => li.dataset.id);

  if (!insId) return alert('ไม่พบ instrument_id (data-ins)');
  if (!type)  return alert('ไม่พบ type ของลิสต์');
  if (ids.length === 0) return alert('ยังไม่มีรูปให้จัดลำดับ');

  const form = new FormData();
  form.append('instrument_id', insId);
  form.append('type', type);
  form.append('order', JSON.stringify(ids));

  try {
    const res  = await fetch('re_images.php', { method: 'POST', body: form });
    const text = await res.text();
    if (text.trim().toUpperCase().includes('OK')) {
      alert('✅ บันทึกลำดับเรียบร้อย');
    } else {
      alert('⚠️ เซิร์ฟเวอร์ตอบกลับ: ' + text);
    }
  } catch (err) {
    alert('❌ เชื่อมต่อไม่ได้: ' + err.message);
  }
}


