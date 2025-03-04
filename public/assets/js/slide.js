const prevBtns = document.querySelectorAll('.prevBtn');
const nextBtns = document.querySelectorAll('.nextBtn');
const delBtn = document.getElementById("delete-image-edit");

document.querySelectorAll('.carousel').forEach((carousel, index) => {
    const carouselItems = carousel.querySelectorAll('.carousel-item');
    let currentIndex = 0;

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

    nextBtns[index].addEventListener('click', () => {
        currentIndex = (currentIndex === carouselItems.length - 1) ? 0 : currentIndex + 1;
        showSlide(currentIndex);
    });
    showSlide(0);
});



document.addEventListener('DOMContentLoaded', function() {
    const delBtn = document.getElementById('delete-image-edit');
    
    console.log('Button:', delBtn); // ตรวจสอบว่า button ถูกโหลดหรือไม่

    if ( delBtn) {
        delBtn.addEventListener('click', function(event) {
            console.log('sds');
            event.preventDefault();
            const activeImage = document.querySelector('.carousel-item:not(.hidden) img');
            if (activeImage) {
                const imageContainer = activeImage.closest('.carousel-item');
                imageContainer.remove();
                updateImg();
            }
        });
    } else {
        console.error('Form or Button not found!');
    }
    function updateImg() 
    {
        showSlide(0);
    }

});