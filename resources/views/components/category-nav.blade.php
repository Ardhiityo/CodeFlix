<ul class="mb-2 navbar-nav me-auto mb-lg-0">
    <li class="nav-item dropdown kategori-dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            KATEGORI
        </a>
        <div class="dropdown-menu w-auto">
            @foreach ($categories as $chunk)
                <ul>
                    @foreach ($chunk as $category)
                        <li>
                            <a class="dropdown-item" href="{{ route('category.show', $category->slug) }}">
                                {{ $category->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </li>
    <li class="nav-item d-flex align-items-center">
        <a href="{{ route('movies.all') }}" class="nav-link d-inline text-white">
            MOVIES
        </a>
    </li>
</ul>
