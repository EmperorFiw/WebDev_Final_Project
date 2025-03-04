const imageInput = document.getElementById('image-input');
const addImg = document.getElementById('addImg');
const imageContainer = document.getElementById('image-container');
const imageSlider = document.getElementById('image-slider');
const deleteButton = document.getElementById('delete-image');
const uploadText = document.getElementById('upload-text');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');

let imageList = [];
let currentIndex = 0;

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


addImg.addEventListener('click', function() {
    imageInput.click();
});

function prevImage(event) {
    event.stopPropagation(); 
}

function nextImage(event) {
    event.stopPropagation(); 
}

function updateImage() {
    if (imageList.length > 0) {
        imageSlider.innerHTML = `<img src="${imageList[currentIndex]}" class="w-full h-full object-cover" draggable="true">`;
        uploadText.classList.add('hidden');
        deleteButton.classList.remove('hidden'); 
        addImg.innerText = 'เพิ่มรูปภาพเพิ่ม';
    } else {
        imageSlider.innerHTML = `
            <span id="upload-text" class="text-sm">คลิ๊กเพื่ออัปโหลด</span>
            <span class="text-xs">หรือลากเพื่อวาง</span>
        `;
        addImg.innerText = 'เพิ่มรูปภาพ'; 
        deleteButton.classList.add('hidden'); 
    }

    prevButton.classList.toggle('hidden', imageList.length <= 1);
    nextButton.classList.toggle('hidden', imageList.length <= 1);
}

deleteButton.addEventListener('click', () => {
    if (imageList.length > 0) {
        imageList.splice(currentIndex, 1);
        currentIndex = Math.max(0, currentIndex - 1);
        updateImage();
    }
});

prevButton.addEventListener('click', () => {
    if (currentIndex > 0) {
        currentIndex--;
        updateImage();
    }
});

nextButton.addEventListener('click', () => {
    if (currentIndex < imageList.length - 1) {
        currentIndex++;
        updateImage();
    }
});