@if(session()->has('success'))
    <div class="alert alert-success msg">
        {{ session()->get('success') }}
    </div>
@endif