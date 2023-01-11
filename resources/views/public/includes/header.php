<link rel="stylesheet" href="{{URL}}/resources/views/public/styles/header.css">

<header>

    <div class="box-main">
        <div class="box-content">
            <div class="box-logo">
                <a href="{{URL}}" class="logo"><img src="{{URL}}/resources/assets/images/logo-lubus.png"></a>
            </div>
            <div class="box-menu-content">
                <div class="menu-left left">
                    <ul class="navbar">
                        <li><a href="{{URL}}" class="{{home_active}}">Início</a></li>
                        <li><a href="{{URL}}/catalogo" class="{{catalogo_active}}">Catálogo</a></li>
                        <li><a href="{{URL}}/suporte" class="{{suporte_active}}">Suporte</a></li>
                    </ul>
                    <div class="fa fa-bars" id="menu-icon"></div>
                </div>
                <div class="menu-right right">
                    <div class="main-header">
                        <a href="#" class="search"><i class="fa-solid fa-magnifying-glass"></i></a>
                        <a href="#" class="cart"><i class="fa-solid fa-cart-shopping"></i></a>
                        <div class="item">
                            <a href="{{URL}}/account/login" class="user"><i class="fa-solid fa-user"></i>Minha conta</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>

<script src="{URL}}/resources/assets/public/js/jquery.js"></script>
<script src="{URL}}/resources/assets/public/js/header_menu.js"></script>