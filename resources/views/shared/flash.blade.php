@if ($message = session('message'))
    <div class="alert alert-success">
        {{ $message }}
        @if ($undoRoute = session('undoRoute'))
            <form action="{{ $undoRoute }}" method="POST" style="display: inline">
                @csrf
                @method('DELETE')
                <button class="btn alert-link">undo</button>
            </form>
        @endif
    </div>
@endif
