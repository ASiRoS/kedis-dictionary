<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('home') }}">Главная</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('words.create') }}" class="nav-link">Добавить слово</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="{{ route('words.search') }}">
                <input name="q" class="form-control mr-sm-2" type="search" placeholder="Поиск">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</header>