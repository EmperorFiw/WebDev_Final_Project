// เปิด Modal
function openModal() {
    const modal = document.getElementById('userModal');
    modal.classList.remove('hidden');
    modal.classList.add('translate-x-0');  // เริ่มจากขวาไปซ้าย
}

// ปิด Modal
function closeModal() {
    const modal = document.getElementById('userModal');
    modal.classList.add('hidden');
    modal.classList.remove('translate-x-0');  // ซ่อน Modal
}
