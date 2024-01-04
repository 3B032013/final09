<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update',$user->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="row mb-3">
            <label for="photo" class="col-md-4 col-form-label text-md-end">{{ __('個人頭像 / photo') }}</label>
            <div class="col-md-6">
                <label for="photo" class="form-label">頭像</label>
                <input id="photo" name="photo" type="file" class="form-control" onchange="previewImage(this);">
                @if ($user->photo == 'head.jpg')
                    <img id="image-preview" src="{{ asset('images/head.jpg') }}" alt="圖片預覽" style="width:200px; height:200px; display: {{ $user->photo ? 'block' : 'none' }}" >
                @else
                    <img id="image-preview" src="{{ $user->photo ? asset('storage/user/' . $user->photo) : '#' }}" alt="圖片預覽" style="width:200px; height:200px; display: {{ $user->photo ? 'block' : 'none' }}" >
                @endif

                @error('photo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('姓名 / Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('信箱 / Email') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="sex" class="col-md-4 col-form-label text-md-end">{{ __('性別 / Sex') }}</label>

            <div class="col-md-6">
                <div class="col-md-6">
                    @if ($user->sex == '男')
                        男<input id="sex" type="radio" name="sex" value="{{ '男' }}" required autocomplete="sex" checked="checked">
                        女<input id="sex" type="radio" name="sex" value="{{ '女' }}" required autocomplete="sex">
                    @else
                        男<input id="sex" type="radio" name="sex" value="{{ '男' }}" required autocomplete="sex">
                        女<input id="sex" type="radio" name="sex" value="{{ '女' }}" required autocomplete="sex" checked="checked">
                    @endif
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="birthday" class="col-md-4 col-form-label text-md-end">{{ __('生日 / Birthday') }}</label>

            <div class="col-md-6">
                <input id="birthday" type="text" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{ $user->birthday }}" required autocomplete="current-password">

                @error('birthday')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('電話 / Phone') }}</label>

            <div class="col-md-6">
                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="current-password">

                @error('phone')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('地址 / Address') }}</label>

            <div class="col-md-6">
                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $user->address }}" required autocomplete="current-password">

                @error('address')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="bank_branch" class="col-md-4 col-form-label text-md-end">{{ __('分行代碼 / bank_branch') }}</label>

            <div class="col-md-6">
                <input id="bank_branch" type="text" class="form-control @error('bank_branch') is-invalid @enderror" name="bank_branch" value="{{ $user->bank_branch }}" >

                @error('bank_branch')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="bank_account" class="col-md-4 col-form-label text-md-end">{{ __('銀行帳號 / bank_account') }}</label>
            <div class="col-md-6">
                <input id="bank_account" type="text" class="form-control @error('bank_account') is-invalid @enderror" name="bank_account" value="{{ $user-> bank_account }}" >

                @error('bank_account')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    <script>
        function previewImage(input) {
            var preview = document.getElementById('image-preview');
            var file = input.files[0];
            var reader = new FileReader();
            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }
    </script>
</section>
