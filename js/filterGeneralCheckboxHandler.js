function filterGeneralCheckboxHandler() {
  var checkboxes = document.getElementsByClassName('filter_checkbox');
  var quantityOfCheckboxes = checkboxes.length;
  var generalCheckbox = document.getElementById('filter_check_all');
  if (generalCheckbox.checked == true) {
    for (var i = 0; i < quantityOfCheckboxes; i++) {
      checkboxes[i].checked = true;
    }
  }
}