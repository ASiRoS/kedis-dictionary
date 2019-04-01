<div class="list-group">
    @if(count($words) > 0)
        @foreach($words as $word)
            <a href="{{ route('words.show', ['word' => $word]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $word->title }}</h5>
                    <small>{{ $word->formatted_date }}</small>
                </div>
                <p class="mb-1">{{ $word->description }}</p>
            </a>
        @endforeach
        <div class="mt-3">
            {{ $words->links() }}
        </div>
    @else
        <p>Ничего не найдено.</p>
    @endif
</div>