<form action="{{ route('checkout.payment', $file) }}" method="POST">
    {{ csrf_field() }}
    {{ $file->price }}€
    <script
        src="https://checkout.stripe.com/checkout.js"
        class="stripe-button"
        data-key="{{ $file->user->stripe_key }}"
        data-amount="{{ $file->price * 100 }}"
        data-name="{{ $file->title }}"
        data-description="{{ $file->overview_short }}"
        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
        data-locale="auto"
        data-currency="eur"
    >
    </script>
</form>
