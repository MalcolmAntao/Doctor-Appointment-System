const day = document.getElementById("day");
const date = document.getElementById("date");
const time = document.getElementById("time");

const days = [
  "Sunday",
  "Monday",
  "Tuesday",
  "Wednesday",
  "Thursday",
  "Friday",
  "Saturday",
];
const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

const now = new Date();

day.textContent = days[now.getDay()];
date.textContent = `${
  months[now.getMonth()]
} ${now.getDate()}, ${now.getFullYear()}`;
time.textContent = now.toLocaleTimeString();

setInterval(() => {
  time.textContent = new Date().toLocaleTimeString();
}, 1000);
