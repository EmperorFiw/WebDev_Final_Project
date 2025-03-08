const imageInput = document.getElementById('image-input');
const addImg = document.getElementById('addImg');
const imageContainer = document.getElementById('image-container');
const imageSlider = document.getElementById('image-slider');
const uploadText = document.getElementById('upload-text');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');
// const delBtn = document.getElementById("delete-image-edit");
const prevBtns = document.querySelectorAll('.prevBtn');
const nextBtns = document.querySelectorAll('.nextBtn');

let imageList = [];
let currentIndex = 0;

function initCarousel()
{
    document.querySelectorAll('.carousel').forEach((carousel, index) => {
        const carouselItems = carousel.querySelectorAll('.carousel-item');
        function showSlide(index) {
            carouselItems.forEach((item, i) => { 
                if (i === index) {
                    item.classList.add('active');
                }
                else
                {
                    item.classList.remove('active');
                    item.classList.add('hidden');
                }
            });
        }
    
        function getNowIndex() {
            let nowIndex = -1; // ค่าเริ่มต้นเป็น -1 เผื่อว่าไม่มี active
            carouselItems.forEach((item, i) => {
                if (item.classList.contains('active')) {
                    nowIndex = i; // ถ้าพบ active ก็อัปเดตค่า
                }
            });
            return nowIndex; // คืนค่า index ของ item ที่ active อยู่
        }
        
        prevButton.removeEventListener('click', prevImageHandler);
        nextButton.removeEventListener('click', nextImageHandler);
    
        function prevImageHandler() {
            let currentIndex = getNowIndex(); // หาค่าตำแหน่งปัจจุบัน

            if (currentIndex === -1) return; // ป้องกัน error ถ้าไม่มีภาพ
        
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : imageList.length - 1; // เลื่อนซ้าย
        
            showSlide(currentIndex);

        }
        
        function nextImageHandler() {
            let currentIndex = getNowIndex(); // หาค่าตำแหน่งปัจจุบัน

            if (currentIndex === -1) return; // ป้องกัน error ถ้าไม่มีภาพ
        
            currentIndex = (currentIndex < imageList.length - 1) ? currentIndex + 1 : 0; // เลื่อนขวา
        
            showSlide(currentIndex);
        }
    
        prevButton.addEventListener('click', prevImageHandler);
        nextButton.addEventListener('click', nextImageHandler);

        showSlide(0);
    });
}


function updateImage() {
    imageSlider.innerHTML = "";
    if (imageList.length > 0) {
        imageList.forEach((image, index) => {
            const isActive = index === currentIndex;
            const carouselItem = document.createElement("div");

            carouselItem.className = `carousel-item absolute inset-0 w-full h-full ${isActive ? "active" : "hidden"}`;
            carouselItem.innerHTML = `
                <img src="${image}" alt="Image ${index + 1}" class="w-full h-full object-cover">
            `;

            imageSlider.appendChild(carouselItem);
        });

        addImg.innerText = "เพิ่มรูปภาพเพิ่ม";
    } else {
        imageSlider.innerHTML = `
            <div class="flex flex-col justify-center items-center h-full">
                <span id="upload-text" class="text-sm mb-2">คลิ๊กเพื่ออัปโหลด</span>
                <span class="text-xs">หรือลากเพื่อวาง</span>
            </div>
        `;
        addImg.innerText = "เพิ่มรูปภาพ";
        // delBtn.classList.add("hidden");
    }
    initCarousel();
}

document.addEventListener('DOMContentLoaded', function() {

    initCarousel();

    addImg.addEventListener('click', function() {
        imageInput.click();
    });


    getAllImageSources();
});

////////////////////////////////////////////////////


function triggerFileInput() {
    imageInput.click();
}

imageInput.addEventListener('change', (event) => {
    handleFiles(event.target.files); 
});

function handleDrop(event) {
    event.preventDefault(); 
    handleFiles(event.dataTransfer.files);
}

function handleFiles(files) {
    for (let file of files) { 
        const reader = new FileReader();
        reader.onload = (e) => { 
            imageList.push(e.target.result); 
            currentIndex = imageList.length - 1;
            updateImage();
        };
        reader.readAsDataURL(file);
    }
}

function prevImage(event) {
    event.stopPropagation(); 
}

function nextImage(event) {
    event.stopPropagation(); 
}

function getAllImageSources() {
    imageList = []; // เคลียร์ imageList ก่อน

    // ดึง src ของทุก <img> ใน .carousel
    const images = document.querySelectorAll('.carousel img');
    images.forEach(img => {
        imageList.push(img.src); // เพิ่ม src ของแต่ละรูปเข้า imageList
    });

    console.log(imageList); 
    if (imageList.length == 0)
    {
        imageSlider.innerHTML = `
        <div class="flex flex-col justify-center items-center h-full">
            <span id="upload-text" class="text-sm mb-2">คลิ๊กเพื่ออัปโหลด</span>
            <span class="text-xs">หรือลากเพื่อวาง</span>
        </div>
        `;
        addImg.innerText = "เพิ่มรูปภาพ";
    }
}
