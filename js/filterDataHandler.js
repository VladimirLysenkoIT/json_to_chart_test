function filterHandler() {
  var params = "";
  var filterSelect = document.getElementById('filter_select');
  var filterCheckboxes = document.getElementsByClassName('filter_checkbox');
  var filerNotification = "choise at least one discipline";
  var filerNotificationWrap = document.getElementById('filter_notification');

  var oneChecked = false;
  var selectedOption = filterSelect.options[filterSelect.selectedIndex].value;

  var checkedBoxes = [];
  var filterCheckBoxesLength = filterCheckboxes.length;
  for (var i = 0; i < filterCheckBoxesLength; i++) {
    if (filterCheckboxes[i].checked) {
      checkedBoxes.push(filterCheckboxes[i].value);
      oneChecked = true;
    }
  }

  if (oneChecked) {
    filerNotificationWrap.innerHTML = "";
    filerNotificationWrap.style.borderWidth = "none";
    filerNotificationWrap.style.borderColor = "none";
    filerNotificationWrap.style.borderStyle = "none";
    params = "selectedPeriod=" + selectedOption + "&" + "selectedDisciplines=" + checkedBoxes;
    sendFilterOptions(params);
  }else{
    filerNotificationWrap.innerHTML = filerNotification;
    filerNotificationWrap.style.borderWidth = "1px";
    filerNotificationWrap.style.borderColor = "red";
    filerNotificationWrap.style.borderStyle = "solid";
  }
}