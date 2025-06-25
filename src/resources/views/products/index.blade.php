@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="product-index">
    <div class="product-index__header">
        <h1 class="product-index__title">商品一覧</h1>
        <a href="{{ route('products.create') }}" class="product-index__create-button">+ 商品を追加</a>
    </div>

    <section class="product-index__sidebar">
        <form action="{{ route('products.search') }}" method="GET" class="product-index__search-form">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索" class="product-index__search-input">
            <button type="submit" class="product-index__search-button">検索</button>

            <div class="product-index__sort">
                <label for="sort">価格順で表示</label>
                <select name="sort" id="sort" onchange="this.form.submit()" class="product-index__sort-select">
                    <option value="">価格で並べ替え</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>高い順に表示</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>低い順に表示</option>
                </select>
            </div>
        </form>

        @if(request('sort'))
            <div class="product-index__sort-tag">
                並び順: {{ request('sort') == 'price_asc' ? '低い順' : '高い順' }}
                <a href="{{ route('products.search', ['keyword' => request('keyword')]) }}" class="product-index__tag-close">×</a>
            </div>
        @endif
    </section>

    <section class="product-index__main">
        <div class="product-index__cards">
            @foreach($products as $product)
                <a href="{{ route('products.edit', $product->id) }}" class="product-card">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-card__image">
                    <div class="product-card__body">
                        <p class="product-card__name">{{ $product->name }}</p>
                        <p class="product-card__price">¥{{ number_format($product->price) }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="product-list__pagination">
            {{ $products->links('vendor.pagination.custom') }}
        </div>
    </section>
</div>
@endsection
