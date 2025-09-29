<form action="{{ $action ?? url()->current() }}" method="{{ $method ?? 'GET' }}" {{ $attributes}}>
    @foreach(request()->except($exclude) as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach

    {{ $slot }}
</form>
