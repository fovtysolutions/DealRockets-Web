@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/dealassist.css')}}" />
@section('title',translate('Deal Assist'. ' | ' . $web_config['name']->value))
@section('content')
<div class="mainpagesection">
    <div class="damainbanner">
        <div class="dalefttext">
            <h1>Secured Trading Service</h1>
                <p>From Payment to Delivery,we protect your trading</p>
                <button>Start Order</button>
        </div>
        <div class="darightanimation">
            <img class="darrightanimationimg" src="{{ theme_asset('images/laptopmockup.png') }}" alt="Broken Image" />
        </div>
    </div>
    <div class="datitlesection">
        <h3>Speed Up the Trading Process with Security</h3>
        <p>
            Secured Trading Service (STS) is a secured trading service at Marketplace.com.
            You can complete the whole trading process quickly online to grow your business.
            From safe payment to on-time shipment, we protect your orders.
        </p>
    </div>
    <div class="dacards">
        <h3>Why Choose Secured Trading Service (STS)?</h3>
        <div class="dacardcontainer">
            <div class="dacard">
                <img src="https://www.micstatic.com/deals/img/buyer-publicity/img_icon1.png?_v=1729824330101"
                    alt="image broken" />
                <h5>Secured Trading</h5>
                <p>
                    Pay with credit/debit cards or bank transfer (T/T). We secure your trading from safe payment
                    to on-time-delivery.
                </p>
            </div>
            <div class="dacard">
                <img src="https://www.micstatic.com/deals/img/buyer-publicity/img_icon3.png?_v=1729824330101"
                    alt="image broken" />
                <h5>Refund Policy</h5>
                <p>
                    You can apply for a refund up to 30 days after receipt of the products for any delivery or product
                    issues.
                </p>
            </div>
            <div class="dacard">
                <img src="https://www.micstatic.com/deals/img/buyer-publicity/img_icon2.png?_v=1729824330101"
                    alt="image broken" />
                <h5>Service Guarantee</h5>
                <p>
                    Not satisfied with the products or service?
                    Contact us and we’ll help you 7*24.
                </p>
            </div>
        </div>
    </div>
    <div class="daordersafe">
        <h5>How to Keep the Order Safe?</h5>
        <div class="daimgtextbox">
            <div class="daimgbox">
                <img src="https://www.micstatic.com/deals/img/buyer-publicity/pub-how.png?_v=1729824330101"
                    alt="broken image" />
            </div>
            <div class="datextbox">
                <ul>
                    <li>
                        <h5>
                            Start Order with Secured Trading Service (STS) Suppliers
                        </h5>
                        <p>
                            Search the products you want to order on Marketplace.com and find the Secured Trading
                            suppliers in our
                            Secured Trading Service channel.
                        </p>
                    </li>
                    <li>
                        <h5>
                            Confirm with Supplier
                        </h5>
                        <p>
                            Negotiate with the supplier for the price and shipping to confirm your order.
                        </p>
                    </li>
                    <li>
                        <h5>
                            Pay to Marketplace.com
                        </h5>
                        <p>
                            Make payment with your preferred method on Marketplace.com.
                        </p>
                    </li>
                    <li>
                        <h5>
                            Wait for the Shipment
                        </h5>
                        <p>
                            The supplier will ship the products and the payment will then be released to the supplier.
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="datestimonials">
        <h5>What Buyers Said Matters</h5>
        <div class="dacarouselbox owl-carousel">
            <div class="dacarouselcard">
                <img src="https://www.micstatic.com/deals/img/buyer-publicity/buyer1.png?_v=1729824330101"
                    alt="John Doe" class="testimonial-image" />
                <div class="testimonial-content">
                    <div class="daname">John Doe</div>
                    <div class="dacountry">
                        <p class="dacountryname">USA</p>
                        <img src="https://flagcdn.com/us.svg" alt="USA" class="flag-icon" />
                    </div>
                    <div class="dadescription">"
                        Secured Trading Service (STS) has been a big help for me and our team. We import from China
                        using Marketplace.com to find suppliers and Secured Trading Service (STS) for the payment.
                        It's been authentic to know everything is okay and then to release the payment to the suppliers.
                        I will highly recommend the work with Marketplace.com Secured Trading Service (STS).
                        "</div>
                </div>
            </div>
            <div class="dacarouselcard">
                <img src="https://www.micstatic.com/deals/img/buyer-publicity/buyer2.png?_v=1729824330101"
                    alt="Maria Smith" class="testimonial-image" />
                <div class="testimonial-content">
                    <div class="daname">Maria Smith</div>
                    <div class="dacountry">
                        <p class="dacountryname">Canada</p>
                        <img src="https://flagcdn.com/ca.svg" alt="Canada" class="flag-icon" />
                    </div>
                    <div class="dadescription">"
                        The service helps me secure my payments before I check the product quality. So this kind of
                        service is what is very impressive to me."
                    </div>
                </div>
            </div>
            <div class="dacarouselcard">
                <img src="https://www.micstatic.com/deals/img/buyer-publicity/buyer3.png?_v=1729824330101" alt="Li Wei"
                    class="testimonial-image" />
                <div class="testimonial-content">
                    <div class="daname">Li Wei</div>
                    <div class="dacountry">
                        <p class="dacountryname">China</p>
                        <img src="https://flagcdn.com/cn.svg" alt="China" class="flag-icon" />
                    </div>
                    <div class="dadescription">"
                        I love Marketplace.com Secured Trading Service (STS) and I want more companies to give it a
                        chance. I received the package in good condition. I would love to see you guys be 1,000 times
                        what those other platforms are. I can only talk so much without something to show of why
                        Marketplace.com is so great!
                        "</div>
                </div>
            </div>
        </div>
    </div>
    <div class="dafaq">
        <h5>FAQ</h5>
        <h6>
            <a class="dasmallblue" href="#">Find All FAQ's in Buyer Guide</a>
        </h6>
        <div class="daquestionsbox">
            <div class="daquestions">
                <div class="question-item" data-index="0">What is the return policy?</div>
                <div class="question-item" data-index="1">How long does shipping take?</div>
                <div class="question-item" data-index="2">Can I track my order?</div>
                <div class="question-item" data-index="3">What payment methods are accepted?</div>
                <div class="question-item" data-index="4">How do I contact customer support?</div>
            </div>
            <div class="daanswers">
                <div class="answer-item" style="display: block;">
                    <strong>Q. What is the return policy?</strong>
                    Our return policy allows returns within 30 days of purchase.
                </div>
                <div class="answer-item" style="display: none;">
                    <strong>Q. How long does shipping take?</strong>
                    Shipping usually takes 5-7 business days.
                </div>
                <div class="answer-item" style="display: none;">
                    <strong>Q. Can I track my order?</strong>
                    Yes, you can track your order using the tracking link sent to your email.
                </div>
                <div class="answer-item" style="display: none;">
                    <strong>Q. What payment methods are accepted?</strong>
                    We accept credit cards, PayPal, and bank transfers.
                </div>
                <div class="answer-item" style="display: none;">
                    <strong>Q. How do I contact customer support?</strong>
                    You can contact customer support via the contact form or email us directly.
                </div>
            </div>
        </div>
    </div>
    <div class="dareturn">
        <h5>Return And Refund</h5>
        <h6>
            <a class="dasmallblue" href="#">Read Full Return and Refund Here</a>
        </h6>
        <div class="dareturnbox">
            <div class="dareturncard">
                <div class="card-header">
                    <img src="https://www.micstatic.com/deals/img/buyer-publicity/qa_3fdf1346.png" alt="Return Policy" class="card-icon" />
                    <span class="card-title">What if the products I ordered are defective/not as described?
                    </span>
                </div>
                <div class="card-text">
                    You can request a refund if the products are not as described. The supplier needs to reply to the
                    refund request within 24 hours after you have submitted it. If the refund method is "Refund after
                    return", the supplier must confirm the refund as soon as possible after receiving your return within
                    30 days.

                </div>
            </div>
            <div class="dareturncard">
                <div class="card-header">
                    <img src="https://www.micstatic.com/deals/img/buyer-publicity/qa_3fdf1346.png" alt="Refund Policy" class="card-icon" />
                    <span class="card-title">Can I apply for a return?
                    </span>
                </div>
                <div class="card-text">
                    If the failure to deliver the goods is within the agreed time limit or the failure to receive the
                    goods is caused by the supplier, the buyer has the right to request a refund (return
                    refund/exchange/other compensations). If you need to send back the goods, the original packaging of
                    the goods, warranty card, accessories, and gift items need to be sent back with the goods together
                    and the freight will be charged by the supplier.

                </div>
            </div>
        </div>
    </div>
    <div class="dacontactus">
        <h3>Have a Question?</h3>
        <p>Contact Us: <a> someemail@gmail.com </a></p>
    </div>
</div>
@endsection

<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            items: 1, // Show one item at a time
            autoplay: true, // Enable autoplay
            autoplayTimeout: 3000, // Set autoplay timeout (3000ms = 3 seconds)
            loop: true, // Loop the carousel
            dots: true, // Show dots for navigation
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.question-item').hover(
            function () {
                // Get the index of the hovered question
                const index = $(this).data('index');
                // Hide all answers and show the corresponding answer
                $('.answer-item').hide().eq(index).show();
            },
            function () {
                // Hide all answers when mouse leaves the question
                $('.answer-item').hide();
            }
        );
    });
</script>