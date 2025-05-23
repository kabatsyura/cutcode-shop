@extends('layouts.auth')
@section('title', 'Восстановление пароля')
@section('content')
    <x-forms.auth-forms title='Восстановление пароля' action="{{ route('password.handle') }}" method="POST">
        @csrf
        <x-forms.text-input type="hidden" name="token" value="{{ $token }}" />
        <x-forms.text-input name="email" value="{{ request('email') }}" type="email" placeholder="E-mail" required="true"
            :isError="$errors->has('email')" />

        @error('email')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.text-input name="password" type="password" placeholder="Пароль" required="true" :isError="$errors->has('password')" />

        @error('password')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.text-input name="password_confirmation" type="password" placeholder="Подтвердите пароль" required="true"
            :isError="$errors->has('password_confirmation')" />

        @error('password_confirmation')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.primary-button>
            Обновить пароль
        </x-forms.primary-button>
        <x-slot:socialAuth></x-slot:socialAuth>
        <x-slot:buttons></x-slot:buttons>
    </x-forms.auth-forms>
@endsection
