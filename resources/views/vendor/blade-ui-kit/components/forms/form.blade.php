<form method="{{ $method !== 'GET' ? 'POST' : 'GET' }}" @isset($action) action="{{ $action }}" @endisset {!! $hasFiles ? 'enctype="multipart/form-data"' : '' !!} {{ $attributes }}>
    @csrf
    @method($method)

    {{ $slot }}

    <input type="hidden" name="previous_url" value="{{ old('previous_url', url()->previous()) }}">
</form>
