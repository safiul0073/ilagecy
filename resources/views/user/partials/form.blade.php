<form @if(isset($user)) action="{{ route('users.update',$user->id ) }}"
    @else action="{{ route('users.store')}}" @endif method="post">
    @csrf
    @if(isset($user))
        @method('PUT')
    @else
        @method('POST')
    @endif
    <div class="form-group">
        <label for="name">Name  <span
            class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name' , $user->name ?? '')}}">

        @error('name')
            <span class="alert alert-danger mt-3 d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="email">Email  <span
            class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"  value="{{ old('email' , $user->email ?? '')}}" placeholder="Email">

        @error('email')
            <span class="alert alert-danger mt-3 d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="role">Role  <span
            class="text-danger">*</span></label>
        <select name="role" class="form-control @error('role') is-invalid @enderror">
            <option value="">Select a Role</option>
            @foreach(App\Models\User::ROLES as $role)
                <option value="{{$role}}" {{ old('role', optional($user ?? null)->role) == $role ? 'selected' : '' }}>{{$role}}</option>
            @endforeach
        </select>

        @error('role')
            <span class="alert alert-danger mt-3 d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Password  <span
            class="text-danger">*</span></label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">

        @error('password')
            <span class="alert alert-danger mt-3 d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password">

        @error('password_confirmation')
            <span class="alert alert-danger mt-3 d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


    <a class="btn btn-danger" href="{{route('users.index')}}">Back</a> <button type="submit" class="btn btn-primary">Submit</button>
</form>