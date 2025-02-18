<?php
// Dynamic values
$nameQuote = 'Submit CV';
$keyword = 'Your name';
$description = 'Your Details';
$inputType = 'file';
$quantity = ''; // You can set this based on your form logic.
?>
<section class="mainpagesection fade-in-on-scroll shadow">
    <div class="agrotradex-sec">
        <div class="agrotradex-form">
            <div>
                <h4>Agro Tradex</h4>
                <p class="mb-2" style="line-height: 1.3;">
                    Streamline your agricultural trade operations and boost your business. With Agro Tradex, you can manage crop inventory, access real-time market insights, and connect with buyers or suppliers effortlessly.
                </p>
                <ul class="feature-list">
                    <li>
                        <div class="leftclass">
                            <i class="fa fa-seedling"></i>
                        </div>
                        <div class="rightclass">
                            <span>Optimized Supply Chain</span><br>
                            <strong>Efficient crop distribution</strong>
                        </div>
                    </li>
                    <li>
                        <div class="leftclass">
                            <i class="fa fa-balance-scale"></i>
                        </div>
                        <div class="rightclass">
                            <span>Fair Market Pricing</span><br>
                            <strong>Stay competitive and profitable</strong>
                        </div>
                    </li>
                    <li>
                        <div class="leftclass">
                            <i class="fa fa-chart-area"></i>
                        </div>
                        <div class="rightclass">
                            <span>Real-time Market Insights</span><br>
                            <strong>Make informed trading decisions</strong>
                        </div>
                    </li>
                </ul>
            </div>            
            <div>
                <a class="btn" href="{{ route('agrotradex') }}">Read More <span>&#8250;</span></a>
            </div>
        </div>
        <div class="agrotradex-txt">
            <img src="/images/agrotradexbanner.jpeg" alt="Full Flash Web Design">
        </div>
    </div>
</section>
