<?php
// Data arrays
$suppliers = [['name' => 'Meet suppliers hassle-free and without boundaries'], ['name' => 'Join our VIP buyer community, find out more'], ['name' => 'Subscribe to receive Global Sources e-magazines - free'], ['name' => 'Watch our videos on the latest trends and products from our suppliers'], ['name' => 'Watch our videos on the latest trends and products from our suppliers'], ['name' => 'Watch our videos on the latest trends and products from our suppliers']];

$supplierCompanies = [['name' => 'Company: ABCD', 'dis' => 'Category - Agriculture'], ['name' => 'Company: ABCD', 'dis' => 'Category - Agriculture'], ['name' => 'Company: ABCD', 'dis' => 'Category - Agriculture'], ['name' => 'Company: ABCD', 'dis' => 'Category - Agriculture'], ['name' => 'Company: ABCD', 'dis' => 'Category - Agriculture'], ['name' => 'Company: ABCD', 'dis' => 'Category - Agriculture']];

$titlename = 'Secure Trading Services';
$vender = ''; // Set this based on your logic (if necessary)
?>
<section class="fade-in-on-scroll">
    <div class="sectrdsvc-sec">
        <div class="container-fluid">
            <h3><?php echo $titlename; ?></h3>
            <div class="row">
                <div class="sectrdsvc-cnt">
                    <!-- Display sectrdsvc descriptions for suppliers -->
                    <?php foreach ($allstocksale->take(6) as $supplier): ?>
                    <a href="{{ route('stocksale') }}" class="sectrdsvc-card" style="display: <?php echo empty($vender) ? 'inline-block' : 'none'; ?>">
                        <div class="sectrdsvc-card-txt">
                            <img src="<?php echo asset('storage/product/thumbnail/' . \App\Utils\ChatManager::getproductimage($supplier['product_id'])); ?>" alt="sectrdsvc Image" />
                            <div class="title"><?php echo $supplier['name']; ?></div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
