@forelse($categories as $category)
    <div id="category" class="category col-3 d-flex flex-column align-items-center">
        <div class="category-card" data-id="{{ $category->id }}">
            <i class="{{ $category->icon_code }}"></i>
        </div>
        <span class="category-text">
            {{ $category->name }}
        </span>
    </div>
@empty
    <div class="col-lg-12 alert alert-warning text-center">
       @lang('site.categories.not_found')
    </div>
@endforelse
