<link rel="stylesheet" href="{{URL}}/resources/views/public/styles/secao_categorias.css">
<section class="categorias">
    <div class="col">
        <div class="col m-auto text-center">
            <h1>Categorias</h1>
        </div>
    </div>
    <div class="container py-5 container-categorias swiper categoriasSwiper">
        <div class="col swiper-wrapper">
                {{itens}}
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>