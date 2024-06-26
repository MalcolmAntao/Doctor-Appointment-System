function addRow() {
  var table = document.getElementById("myTable");
  var rowCount = table.rows.length;
  var row = table.insertRow(rowCount);

  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);

  cell1.innerHTML = rowCount;
  cell2.innerHTML = "Malcolm Antao";
  cell3.innerHTML = "10:30 am";
}
