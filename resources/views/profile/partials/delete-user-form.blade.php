<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('刪除帳號') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('當你刪除帳號後，與你帳號有關的所有資料將會被刪除。') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('刪除帳號') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('確定要刪除帳號?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('當你刪除帳號後，與你帳號有關的所有資料將會被刪除。') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('密碼') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('密碼') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('取消') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('確定刪除帳號') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
