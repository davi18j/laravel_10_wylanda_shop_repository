<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{route('admin.dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->



        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#Category-nav" data-bs-toggle="collapse" href="#">
                <i class="ri-folder-line"></i><span>Categorias</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="Category-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{route('categories.index')}}">
                        <i class="bi bi-circle"></i><span>Categoria</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('sub-categories.index')}}">
                        <i class="bi bi-circle"></i><span>Subcategoria</span>
                    </a>
                </li>
            </ul>
        </li><!-- Fim do Menu de Categorias -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('brands.index')}}">
                <i class="ri-price-tag-line"></i>
                <span>Marcas</span>
            </a>
        </li><!-- Fim do Menu de Perfil -->
        
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('products.index')}}">
                <i class="ri-product-hunt-line"></i>
                <span>Produtos</span>
            </a>
        </li><!-- Fim do Menu de Perguntas Frequentes -->
        
        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-contact.html">
                <i class="ri-truck-line"></i>
                <span>Entrega</span>
            </a>
        </li><!-- Fim do Menu de Contato -->
        
        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-register.html">
                <i class="ri-file-list-line"></i>
                <span>Pedidos</span>
            </a>
        </li><!-- Fim do Menu de Registro -->
        
        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-login.html">
                <i class="ri-percent-line"></i>
                <span>Desconto</span>
            </a>
        </li><!-- Fim do Menu de Login -->
        
        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-error-404.html">
                <i class="ri-user-line"></i>
                <span>Usuários</span>
            </a>
        </li><!-- Fim do Menu de Página de Erro 404 -->
        
        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-blank.html">
                <i class="bi bi-file-earmark"></i>
                <span>Páginas</span>
            </a>
        </li><!-- Fim do Menu de Página em Branco -->

    </ul>

</aside>
