function initializeMultiStepForm() {
    const steps = document.querySelectorAll(".step-section");
    const stepIndicators = document.querySelectorAll(".step");

    function showStep(step) {
        console.log('show step',step);
        steps.forEach((s) => s.classList.add("d-none"));
        const currentStep = document.querySelector(
            `.step-section[data-step="${step}"]`
        );
        if (currentStep) {
            currentStep.classList.remove("d-none");
        }

        stepIndicators.forEach((ind, i) => {
            const currentStepIndex = step - 1;
            ind.classList.toggle("active", i <= currentStepIndex);
        });
    }

    function validateStepInputs(currentStepSection) {
        const requiredInputs = currentStepSection.querySelectorAll(
            "input[required], select[required], textarea[required]"
        );
        let allFilled = true;

        requiredInputs.forEach((input) => {
            if (!input.value.trim()) {
                allFilled = false;
                input.classList.add("input-error");
            } else {
                input.classList.remove("input-error");
            }
        });

        return allFilled;
    }

    document.querySelectorAll(".next-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            const currentStepSection = btn.closest(".step-section");
            if (validateStepInputs(currentStepSection)) {
                showStep(btn.dataset.next);
            } else {
                toastr.info("Please fill in all required fields.");
            }
        });
    });

    document.querySelectorAll(".prev-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            showStep(btn.dataset.prev);
        });
    });

    showStep(1);
}

// Call the function when DOM is ready
document.addEventListener("DOMContentLoaded", initializeMultiStepForm);

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
