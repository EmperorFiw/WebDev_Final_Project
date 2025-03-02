const prevBtns = document.querySelectorAll('.prevBtn');
const nextBtns = document.querySelectorAll('.nextBtn');
const delBtn = document.getElementById("delete-image-edit");

document.querySelectorAll('.carousel').forEach((carousel, index) => {
    const carouseCon = carousel.querySelectorAll('.carousel-container');
    let currentIndex = 0;

    // delBtn.addEventListener('click', () => {
    //     carouseCon.forEach((item, i) => { 
    //         if (i === index) {
    //             item.classList.add('active');
    //             alert('fuck');
    //         }
    //     });
    // });

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
});