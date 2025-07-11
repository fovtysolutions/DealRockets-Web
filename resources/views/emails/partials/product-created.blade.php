<h2>Hello {{ $vendor->name ?? ($vendor->f_name . ' ' . $vendor->l_name) }}</h2>
<p>Your product <strong>{{ $product->name }}</strong> has been successfully submitted for review.</p>
<p>We will notify you once it's approved.</p>
