<h2>Hi {{ $vendor->name ?? ($vendor->f_name . ' ' . $vendor->l_name) }}</h2>
<p>Your Product Inquiry<strong>{{ $stock->name }}</strong> has been sent.</p>
<p>You will hear from Vendor Shortly.</p>
