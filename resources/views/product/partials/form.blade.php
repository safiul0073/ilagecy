<form @if(isset($product)) action="{{ route('products.update',$product->id ) }}"
    @else action="{{ route('products.store')}}" @endif method="post">
    @csrf
    @if(isset($product))
        @method('PUT')
    @else
        @method('POST')
    @endif

    <div class="form-group">
        <label for="name">Name  <span
            class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name' , $product->name ?? '')}}">

        @error('name')
            <span class="alert alert-danger mt-3 d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>


    <div class="form-group">
        <label for="note">Note </label>
        <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note" >
            {{ old('note' , $product->note ?? '') }}
        </textarea>

        @error('note')
            <span class="alert alert-danger mt-3 d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <a class="btn btn-danger" href="{{route('products.index')}}">Back</a> <button type="submit" class="btn btn-primary">Submit</button>
</form>