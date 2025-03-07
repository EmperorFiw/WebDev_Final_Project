
<title>เปิดเช็คชื่อกิจกรรม</title>
<div class="bg-gray-300 p-8 rounded-lg shadow-lg text-center max-w-md mx-auto mt-10">
        <h1 class="text-black text-2xl font-bold mb-4">เช็คชื่อกิจกรรม</h1>
        <p class="text-gray-700 mb-6">สแกน QR Code เพื่อเช็คชื่อเข้าร่วมกิจกรรม</p>
        <div id="qrcode" class="flex justify-center mb-6"></div>
        <p class="text-gray-500 text-sm">กรุณาสแกน QR Code </p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script type="text/javascript">
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "<?= $data['url'] ?>",
            width: 200, // ขนาด QR Code
            height: 200, // ขนาด QR Code
            colorDark : "#000000", // สีของ QR Code
            colorLight : "#ffffff", // สีพื้นหลังของ QR Code
            correctLevel : QRCode.CorrectLevel.H // ระดับความผิดพลาดในการอ่าน
        });
    </script>
