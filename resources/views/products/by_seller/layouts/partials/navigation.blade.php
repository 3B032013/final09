<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{ url('/') }}">二手零件交易平台</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">類別搜尋</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach ($sellerCategories as $category)
                            <li><a class="dropdown-item" href="{{ route('products.by_seller_and_category', ['seller_id' => $seller->id, 'category_id' => $category->id]) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
{{--                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">最新公告</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link" href="#!">聯絡我們</a></li>--}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>--}}
{{--                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--                        <li><a class="dropdown-item" href="#!">All Products</a></li>--}}
{{--                        <li><hr class="dropdown-divider" /></li>--}}
{{--                        <li><a class="dropdown-item" href="#!">Popular Items</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#!">New Arrivals</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
            </ul>

            <ul class="navbar-nav">
            @guest
                @if (Route::has('login'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('登入') }}</a></li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('註冊') }}</a></li>
                @endif
            @else
                <form class="d-flex" action="{{ route('cart_items.index') }}">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        購物車
                        <span class="badge bg-dark text-white ms-1 rounded-pill">{{ count($cartItems) }}</span>
                    </button>
                </form>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{ Auth::user()->name }} </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @if (Auth::check() && Auth::user()->isSeller())
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}" style="color:black">{{ __('個人資料') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}" style="color:black">{{ __('訂購清單') }}</a>
                            </li>
                            @if(Auth::User()->Seller->status==0)
                                <li>
                                    <a class="dropdown-item" href="{{ route('sellers.create') }}" style="color:black">{{ __('賣家申請失敗') }}</a>
                                </li>
                            @elseif(Auth::User()->Seller->status==1)
                                <li>
                                    <a class="dropdown-item" href="{{ route('sellers.create') }}" style="color:black">{{ __('賣場已被停權') }}</a>
                                </li>
                            @elseif(Auth::User()->Seller->status==2)
                                <li>
                                    <a class="dropdown-item" href="{{ route('sellers.products.index') }}" style="color:black">{{ __('賣家後台') }}</a>
                                </li>
                            @elseif(Auth::User()->Seller->status==3)
                                <li>
                                    <a class="dropdown-item" href="{{ route('home') }}" style="color:black">{{ __('賣家申請中') }}</a>
                                </li>
                            @endif
                        @else
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}" style="color:black">{{ __('個人資料') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('sellers.create') }}" style="color:black">{{ __('申請成為賣家') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}" style="color:black">{{ __('訂購清單') }}</a>
                            </li>
                        @endif
                        @if (Auth::check() && Auth::user()->isAdmin())
                            <li>
                                <a class="dropdown-item" href="{{ route('admins.dashboard') }}" style="color:black">{{ __('後台管理') }}</a>
                            </li>
                        @endif
                        <li>
                            <hr class="dropdown-divider"/>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" style="color:black">{{ __('登出') }}</a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
            @endguest
            </ul>
        </div>
    </div>
</nav>
