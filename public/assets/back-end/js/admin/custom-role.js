'use strict';

$('#submit-create-role').on('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    // Clear any previously added hidden inputs
    $(".dynamic-hidden-input").remove();

    let fields = $(".module-permission-special");
    let formattedInput = [];

    // Iterate through all checkboxes (checked and unchecked)
    fields.each(function () {
        let continent = $(this).data('continent'); // Get continent
        let module = $(this).data('key'); // Get module key
        let permission = $(this).data('permission'); // Get permission type (read, write, delete)
        let isChecked = $(this).is(":checked") ? "yes" : "no"; // Determine if the checkbox is checked

        // Push the data into the formattedInput array
        formattedInput.push({
            continent: continent,
            module: module,
            permission: permission,
            value: isChecked
        });

        // Create a hidden input for each item in the formattedInput array
        let inputName = `permissions[${continent}][${module}][${permission}]`;
        let hiddenInput = `<input type="hidden" name="${inputName}" value="${isChecked}" class="dynamic-hidden-input">`;
        $('#submit-create-role').append(hiddenInput);
    });

    // Submit the form after appending the hidden inputs
    $(this).unbind('submit').submit();
});

$("#select-all").on('change', function () {
    if ($(this).is(":checked") === true) {
        $(".module-permission").prop("checked", true);
    } else {
        $(".module-permission").removeAttr("checked");
    }
});

$(".select-all-specific").on('change', function () {
    let continent = $(this).data('continent');
    let modules = `.module-permission-${continent}`;
    if ($(this).is(":checked") === true) {
        $(modules).prop("checked", true);
    } else {
        $(modules).removeAttr("checked");
    }
});

$(document).ready(function(){
    checkboxSelectionCheck();
})

function checkboxSelectionCheck() {
    let nonEmptyCount = 0;
    $(".module-permission").each(function() {
        if ($(this).is(":checked") !== true) {
            nonEmptyCount++;
        }
    });

    let selectAll = $("#select-all");
    if (nonEmptyCount === 0) {
        selectAll.prop("checked", true);
    }else{
        selectAll.removeAttr("checked");
    }
}

$('.module-permission').click(function(){
    checkboxSelectionCheck();
});
