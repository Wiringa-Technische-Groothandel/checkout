<div class="row" id="cart-item-container">
    @if ($quote->getItemCount() > 0)
        <div id="cart-overlay">
            <i class="fa fa-3x fa-spinner fa-spin"></i>
        </div>

        @include('checkout::cart.table.header')

        @foreach($quote->getItems() as $item)
            @include('checkout::cart.table.item')
        @endforeach

        @include('checkout::cart.table.footer')
    @else
        <div class="col-sm-6 col-sm-offset-3">
            <div class="alert alert-warning">
                {{ trans('checkout::cart.empty') }}
            </div>
        </div>
    @endif
</div>