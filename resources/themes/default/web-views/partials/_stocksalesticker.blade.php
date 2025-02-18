<?php
// Dynamic values
$nameQuote = 'Submit CV';
$keyword = 'Your name';
$description = 'Your Details';
$inputType = 'file';
$quantity = ''; // You can set this based on your form logic.
?>
<section class="fade-in-on-scroll">
    <div class="stocksalesticker-sec" id="sendcv">
        <div class="stocksalesticker-txt">
            <img src="/images/clipart.png" alt="Full Flash Web Design">
        </div>
        <div class="stocksalesticker-form">
            <div>
                <h4>Stock Sale</h4>
                <p class="mb-2">
                    Discover a seamless way to manage stock sales and grow your business. With our platform, you can track inventory, optimize pricing, and reach more customers, all in one place.
                </p>
                <ul class="feature-list">
                    <li>
                        <div class="leftclass">
                            <i class="fa fa-truck"></i>
                        </div>
                        <div class="rightclass">
                            <span>Efficient Delivery</span><br>
                            <strong>Hassle-free delivery</strong>
                        </div>
                    </li>
                    <li>
                        <div class="leftclass">
                            <i class="fa fa-tags"></i>
                        </div>
                        <div class="rightclass">
                            <span>Dynamic Pricing</span><br>
                            <strong>Competitive pricing</strong>
                        </div>
                    </li>
                    <li>
                        <div class="leftclass">
                            <i class="fa fa-chart-line"></i>
                        </div>
                        <div class="rightclass">
                            <span>Real-time Insights</span><br>
                            <strong>Monitor stock performance</strong>
                        </div>
                    </li>
                </ul>
            </div>
            <div>
                <button id="stocksell" class="btn" href="{{ route('stocksale') }}">Check Interest <span>&#8250;</span></button>
            </div>
        </div>
    </div>
</section>
