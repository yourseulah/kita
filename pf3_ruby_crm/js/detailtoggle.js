function detailtoggle(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("detailhide") == -1) {
    x.className += " detailhide";
  } else {
    x.className = x.className.replace(" detailhide", "");
  }
}
