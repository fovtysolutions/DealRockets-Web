document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll(".step-section");
    const stepIndicators = document.querySelectorAll(".step");

    function showStep(step) {
        steps.forEach((s) => s.classList.add("d-none"));
        document
            .querySelector(`.step-section[data-step="${step}"]`)
            .classList.remove("d-none");

        stepIndicators.forEach((ind, i) => {
            // Step 1 = index 0, Step 2 = index 2, Step 3 = index 4, etc.
            const currentStepIndex = step - 1;
            ind.classList.toggle("active", i <= currentStepIndex);
        });
    }

    document.querySelectorAll(".next-btn").forEach((btn) => {
        btn.addEventListener("click", () => showStep(btn.dataset.next));
    });

    document.querySelectorAll(".prev-btn").forEach((btn) => {
        btn.addEventListener("click", () => showStep(btn.dataset.prev));
    });
});

function submitRegistrationVendor() {
    const getFormId = "quotation-form";
    let formData = new FormData(document.getElementById(getFormId));
    $.ajaxSetup({
        headers: {
            "X-XSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.post({
        url: $("#" + getFormId).attr("action"),
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $("#loading").addClass("d-grid");
        },
        success: function (data) {
            if (data.errors) {
                for (let index = 0; index < data.errors.length; index++) {
                    toastr.error(data.errors[index].message, {
                        CloseButton: true,
                        ProgressBar: true,
                    });
                }
            } else if (data.error) {
                toastr.error(data.error, {
                    CloseButton: true,
                    ProgressBar: true,
                });
            } else {
                $(".registration-success-modal").modal("show");
                setTimeout(function () {
                    location.href = data.redirectRoute;
                }, 4000);
            }
        },
        complete: function () {
            $("#loading").removeClass("d-grid");
        },
    });
}
