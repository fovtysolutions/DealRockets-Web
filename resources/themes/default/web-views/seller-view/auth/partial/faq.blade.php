<section class="pt-4 pt-lg-5">
    <section class="faq-section">
        <div class="container">
            <h3 class="faq-title">Frequently asked questions</h3>
            <p class="faq-subtitle">Everything you need to know about the product and billing.</p>

            <div class="faq-item open">
                <div class="faq-question">
                    <strong>How do I handle customer inquiries?</strong>
                    <i class="bi quetion-icon  bi-dash-lg"></i>
                </div>
                <div class="faq-answer">
                    You can manage customer inquiries directly through our platform’s messaging system, ensuring quick
                    and efficient communication.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <strong>How do I upload products?</strong>
                    <i class="bi quetion-icon bi-plus-lg"></i>
                </div>
                <div class="faq-answer">
                    <!-- Hidden until toggled -->
                    You can upload products through your dashboard, using our easy-to-use upload form and product
                    editor.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <strong>What are the fees for selling?</strong>
                    <i class="bi quetion-icon  bi-plus-lg"></i>
                </div>
                <div class="faq-answer">
                    <!-- Hidden until toggled -->
                    We charge a small commission per successful sale. Check our pricing page for full details.
                </div>
            </div>
        </div>
    </section>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const faqItems = document.querySelectorAll(".faq-item");

        faqItems.forEach(item => {
            const question = item.querySelector(".faq-question");

            question.addEventListener("click", () => {
                const isOpen = item.classList.contains("open");

                // Close all others
                faqItems.forEach(i => {
                    i.classList.remove("open");
                    const icon = i.querySelector("i");
                    icon.classList.remove("bi-dash-lg");
                    icon.classList.add("bi-plus-lg");
                });

                // Toggle this item
                if (!isOpen) {
                    item.classList.add("open");
                    const icon = item.querySelector("i");
                    icon.classList.remove("bi-plus-lg");
                    icon.classList.add("bi-dash-lg");
                }
            });
        });
    });
</script>
