@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
<section class="edit">
    <a href="{{ route('products.index') }}" class="edit__back">商品一覧</a> ＞ {{ $product->name }} 編集
        {{-- 更新フォーム --}}
        <form class="edit-form" method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="edit-form__image">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <input type="file" name="image">
                @error('image')
                    <div class="edit-form__error">{{ $message }}</div>
                @enderror
            </div>

            <div class="edit-form__inputs">
                <label>商品名
                    <input type="text" name="name" value="{{ old('name', $product->name) }}">
                    @error('name')
                        <div class="edit-form__error">{{ $message }}</div>
                    @enderror
                </label>

                <label>値段
                    <input type="number" name="price" value="{{ old('price', $product->price) }}">
                    @error('price')
                        <div class="edit-form__error">{{ $message }}</div>
                    @enderror
                </label>

                <label>季節</label>
                <div class="edit-form__checkboxes">
                    @foreach ($seasons as $season)
                        <label class="edit-form__checkbox-item">
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                {{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                            {{ $season->name }}
                        </label>
                    @endforeach
                </div>
                @error('seasons')
                    <div class="edit-form__error">{{ $message }}</div>
                @enderror
            </div>

            <div class="edit-form__description">
                <label>商品説明
                    <textarea name="description">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="edit-form__error">{{ $message }}</div>
                    @enderror
                </label>
            </div>

        <div class="edit-form__buttons">
            <a href="{{ route('products.index') }}" class="edit-form__btn edit-form__btn--back">戻る</a>
            <button type="submit" class="edit-form__btn edit-form__btn--submit">変更を保存</button>
        </div>
    </form>

    {{-- 削除フォーム --}}
    <div class="edit-form__delete">
        @if (!$errors->any())
        <form class="edit-form__delete-form" method="POST" action="{{ route('products.destroy', $product->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="edit-form__btn edit-form__btn--delete">
                <img src="{{ asset('storage/images/trash-icon.png') }}" alt="削除">
            </button>
        </form>
        @endif
    </div>
    
</section>
@endsection
