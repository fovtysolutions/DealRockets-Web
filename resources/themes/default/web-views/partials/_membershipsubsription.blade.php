<section class="mainpagesection">
    <div class="bestseller-sec">
        <div class="container-fluid">
            <h3><?php echo TITLE_NAME; ?></h3>
            <div class="row">
                <div class="bestseller-cnt">
                    <!-- Loop through suppliers -->
                    <?php foreach (SUPPLIERS as $item): ?>
                    <div class="bestseller-card" style="display: inline-block;">
                        <div class="bestseller-card-txt">
                            <!-- Use image constants based on the vendor condition -->
                            <img src="<?php echo VENDER === '' ? asset($item['image']) : asset(VENDOR_IMAGE); ?>" 
                                 alt="<?php echo VENDER === '' ? 'bestseller Image' : 'Vendor Image'; ?>" />
                            
                            <div class="title"><?php echo $item['name']; ?></div>
                            
                            <!-- Display additional information for vendor view -->
                            <?php if (VENDER !== ''): ?>
                            <div class="manufacture">****</div>
                            <div class="business"><?php echo $item['dis']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>