
<title>เปิดเช็คชื่อกิจกรรม</title>
<div id="qrcode"></div>
<script type="text/javascript">
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: "<?= $data['url'] ?>",
        width: 128, // ขนาด QR Code
        height: 128, // ขนาด QR Code
        colorDark : "#000000", // สีของ QR Code
        colorLight : "#ffffff", // สีพื้นหลังของ QR Code
        correctLevel : QRCode.CorrectLevel.H // ระดับความผิดพลาดในการอ่าน
    });
</script>
