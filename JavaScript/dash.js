document.addEventListener("DOMContentLoaded", function () {
  var modeSwitch = document.querySelector(".mode-switch");
  modeSwitch.addEventListener("click", function () {
    document.documentElement.classList.toggle("dark");
    modeSwitch.classList.toggle("active");
  });
  // var listView = document.querySelector('.list-view');
  var gridView = document.querySelector(".grid-view");
  var projectsList = document.querySelector(".project-boxes");
  listView.addEventListener("click", function () {
    gridView.classList.remove("active");
    listView.classList.add("active");
    projectsList.classList.remove("jsGridView");
    projectsList.classList.add("jsListView");
  });
  gridView.addEventListener("click", function () {
    gridView.classList.add("active");
    listView.classList.remove("active");
    projectsList.classList.remove("jsListView");
    projectsList.classList.add("jsGridView");
  });
  document
    .querySelector(".messages-btn")
    .addEventListener("click", function () {
      document.querySelector(".messages-section").classList.add("show");
    });
  document
    .querySelector(".messages-close")
    .addEventListener("click", function () {
      document.querySelector(".messages-section").classList.remove("show");
    });
});

let selectedTimeslot = null;

document.querySelectorAll(".timeslot").forEach(function (timeslot) {
  timeslot.addEventListener("click", function () {
    if (selectedTimeslot && selectedTimeslot !== this) {
      selectedTimeslot.classList.remove("clicked");
    }

    this.classList.toggle("clicked");
    selectedTimeslot = this.classList.contains("clicked") ? this : null;
  });
});

// Add your code here to handle the list data
console.log("Prescription list data:");
const prescriptionList = document.getElementById("prescription-list");
const listItems = prescriptionList.getElementsByTagName("li");
for (let i = 0; i < listItems.length; i++) {
  const listItem = listItems[i];
  const spans = listItem.getElementsByTagName("span");
  console.log(
    `Medication: ${spans[0].innerText}, Dosage: ${spans[1].innerText}, Instructions: ${spans[2].innerText}, Quantity: ${spans[3].innerText}, Refills: ${spans[4].innerText}`
  );
}
