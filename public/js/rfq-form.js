document.getElementById("uploadBox").addEventListener("click", function () {
    document.getElementById("imageInput").click();
  });

  document.getElementById("imageInput").addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
      alert("Image selected: " + file.name);
      // You can add code here to preview or upload it via AJAX
    }
  });


const inputs = document.querySelectorAll(".counter-fields");
const totalFields = inputs.length;
const progressArc = document.getElementById("progress-arc");
const progressText = document.getElementById("progress-text");

function updateProgress() {
    let filledCount = 0;
    inputs.forEach(input => {
    if (input.value.trim() !== "") {
        filledCount++;
    }
    console.log(filledCount);
});

const percentage = Math.round((filledCount / totalFields) * 100);
const maxArc = 205; // length of half-circle path
const offset = maxArc - (maxArc * percentage / 100);

progressArc.style.strokeDashoffset = offset;
progressText.textContent = `${percentage}%`;
}

inputs.forEach(input => {
  input.addEventListener("input", updateProgress);
  input.addEventListener("change", updateProgress);
});
