function filterCheckboxesHandler() {
  var checkboxes = document.getElementsByClassName('filter_checkbox');
  var quantityOfCheckboxes = checkboxes.length;
  var generalCheckbox = document.getElementById('filter_check_all');
  var allBoxesChecked = true;

  for (var i = 0; i < quantityOfCheckboxes; i++) {
    if (!checkboxes[i].checked) {
      allBoxesChecked = false;
    }
  }

  if (allBoxesChecked) {
    generalCheckbox.checked = true;
  }else{
    generalCheckbox.checked = false;
  }
}