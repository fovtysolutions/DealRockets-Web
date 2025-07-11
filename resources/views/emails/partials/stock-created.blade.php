<h2>Hi {{ $vendor->name ?? ($vendor->f_name . ' ' . $vendor->l_name) }}</h2>
<p>Your stock listing <strong>{{ $stock->description }}</strong> has been submitted.</p>
<p>We'll review and notify you upon approval.</p>
