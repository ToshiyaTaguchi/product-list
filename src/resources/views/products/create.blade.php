@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<section class="create">
    <h2 class="create__title">商品登録</h2>

    <form class="create-form" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- 商品名 -->
        <div class="create-form__group">
            <label class="create-form__label" for="name">商品名 <span class="required">必須</span></label>
            <input class="create-form__input" type="text" id="name" name="name" placeholder="商品名を入力" value="{{ old('name') }}">
            @error('name')
                <div class="create-form__error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 値段 -->
        <div class="create-form__group">
            <label class="create-form__label" for="price">値段 <span class="required">必須</span></label>
            <input class="create-form__input" type="number" id="price" name="price" placeholder="値段を入力" value="{{ old('price') }}">
            @error('price')
                <div class="create-form__error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 商品画像 -->
        <div class="create-form__group">
            <label class="create-form__label" for="image">商品画像 <span class="required">必須</span></label>
            <input class="create-form__file" type="file" id="image" name="image">
            @error('image')
                <div class="create-form__error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 季節 -->
        <div class="create-form__group">
            <label class="create-form__label">季節 <span class="required">必須</span></label>
            <div class="create-form__checkboxes">
                @foreach ($seasons as $season)
                    <label class="create-form__checkbox-item">
                        <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                            {{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                        {{ $season->name }}
                    </label>
                @endforeach
            </div>
            @error('seasons')
                <div class="create-form__error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 商品説明 -->
        <div class="create-form__group">
            <label class="create-form__label" for="description">商品説明 <span class="required">必須</span></label>
            <textarea class="create-form__textarea" id="description" name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description')
                <div class="create-form__error">{{ $message }}</div>
            @enderror
        </div>

        <!-- ボタン -->
        <div class="create-form__buttons">
            <a href="{{ route('products.index') }}" class="create-form__btn create-form__btn--back">戻る</a>
            <button type="submit" class="create-form__btn create-form__btn--submit">登録</button>
        </div>
    </form>
</section>
@endsection