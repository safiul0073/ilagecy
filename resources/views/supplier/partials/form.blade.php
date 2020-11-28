<form @if(isset($supplier)) action="{{ route('suppliers.update',$supplier->id ) }}"
    @else action="{{ route('suppliers.store')}}" @endif method="post">
    @csrf
    @if(isset($supplier))
        @method('PUT')
    @else
        @method('POST')
    @endif

    <div class="form-group">
        <label for="api">API Key  <span
            class="text-danger">*</span></label>
        <input type="text" name="api" class="form-control @error('api') is-invalid @enderror" id="api" placeholder="api key" value="{{ old('api' , $supplier->api ?? '')}}">

        @error('api')
            <span class="alert alert-danger mt-3 d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="name">Name  <span
            class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name' , $supplier->name ?? '')}}">

        @error('name')
            <span class="alert alert-danger mt-3 d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email  <span
            class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"  value="{{ old('email' , $supplier->email ?? '')}}" placeholder="Email">

        @error('email')
            <span class="alert alert-danger mt-3 d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone">Phone </label>
        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"  value="{{ old('phone' , $supplier->phone ?? '')}}" placeholder="Phone">

        @error('phone')
            <span class="alert alert-danger mt-3 d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="address">Address </label>
        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" >
            {{ old('address' , $supplier->address ?? '') }}
        </textarea>

        @error('address')
            <span class="alert alert-danger mt-3 d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="note">Note </label>
        <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note" >
            {{ old('note' , $supplier->note ?? '') }}
        </textarea>

        @error('note')
            <span class="alert alert-danger mt-3 d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>




    <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">

    <a class="btn btn-danger" href="{{route('suppliers.index')}}">Back</a> <button type="submit" class="btn btn-primary">Submit</button>
</form>