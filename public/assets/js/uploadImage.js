const imageInput = document.getElementById('image-input');
const imageContainer = document.getElementById('image-container');
const imageSlider = document.getElementById('image-slider');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');
const deleteButton = document.getElementById('delete-image');
const uploadText = document.getElementById('upload-text');
let images = [];
let currentIndex = 0;

function triggerFileInput() {
    if (images.length === 0) {
        imageInput.click();
    }
}

imageInput.addEventListener('change', (event) => {
    handleFiles(event.target.files);
});

function handleDrop(event) {
    event.preventDefault();
    handleFiles(event.dataTransfer.files);
}

function handleFiles(files) {
    const fileArray = Array.from(files);
    fileArray.forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
            images.push(e.target.result);
            currentIndex = images.length - 1;
            updateSlider();
        };
        reader.readAsDataURL(file);
    });
}

function updateSlider() {
    if (images.length > 0) {
        imageSlider.innerHTML = `<img src="${images[currentIndex]}" class='w-full h-full object-contain' draggable="true" ondragstart="dragStart(event)">`;
        prevButton.classList.toggle('hidden', images.length <= 1);
        nextButton.classList.toggle('hidden', images.length <= 1);
        uploadText.style.display = 'none';
    } else {
        imageSlider.innerHTML = `<span id='upload-text' class='text-sm'>คลิ๊กเพื่ออัปโหลด</span><span class='text-xs'>หรือลากเพื่อวาง</span>`;
        prevButton.classList.add('hidden');
        nextButton.classList.add('hidden');
        currentIndex = 0;
    }
}

function dragStart(event) {
    event.dataTransfer.setData("text/plain", currentIndex);
}

function handleImageReorder(event) {
    event.preventDefault();
    const draggedIndex = event.dataTransfer.getData("text/plain");
    if (draggedIndex !== "" && draggedIndex !== currentIndex.toString()) {
        const movedImage = images.splice(draggedIndex, 1)[0];
        images.splice(currentIndex, 0, movedImage);
        updateSlider();
    }
}

prevButton.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateSlider();
});

nextButton.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % images.length;
    updateSlider();
});

deleteButton.addEventListener('click', () => {
    if (images.length > 0) {
        images.splice(currentIndex, 1);
        currentIndex = Math.min(currentIndex, images.length - 1);
        updateSlider();
    }
});