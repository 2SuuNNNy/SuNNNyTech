<div class="swiper brand-swiper" data-aos="fade-up">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="/SuNNNyTech/images/logos/logo-razer.png" alt="Brand 1"></div>
        <div class="swiper-slide"><img src="/SuNNNyTech/images/logos/logo-msi.png" alt="Brand 2"></div>
        <div class="swiper-slide"><img src="/SuNNNyTech/images/logos/logo-rfg.png" alt="Brand 3"></div>
        <div class="swiper-slide"><img src="/SuNNNyTech/images/logos/logo-logi.png" alt="Brand 4"></div>
        <div class="swiper-slide"><img src="/SuNNNyTech/images/logos/logo-assus.png" alt="Brand 5"></div>
    </div>
    <!-- Add Pagination Dots -->
    <div class="swiper-pagination"></div>
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
        const swiper = new Swiper('.brand-swiper', {
            slidesPerView: 2,
            spaceBetween: 10,
            breakpoints: {
                640: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 30 }
            },
            loop: true,
            autoplay: { delay: 2000, disableOnInteraction: false }
        });
</script>

<!-- Swiper CSS styles -->
<style>
    .swiper {
        width: 700px;
        max-width: 800px;
        height: 100px;
        margin: 2px auto;
        margin-bottom: 100px;
    }

    .swiper-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-left: 40%;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;  /* Prevent the slides from shrinking */
    }

    .swiper-slide img {
        max-width: 120px;
        max-height: 60px;
        object-fit: contain;
    }

    /* Optional: Hover effect for images */
    .swiper-slide img:hover {
        transform: scale(1.1);  /* Slight zoom on hover */
    }

</style>
