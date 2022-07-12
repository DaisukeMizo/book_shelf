function dropdown($id) {
  document.getElementById($id).classList.toggle("entering-to");
}

function heddenDropdown($id) {
  document.getElementById($id).classList.remove("entering-to");
}

function checkDelete() {
  if (window.confirm("削除しますか?")) {
    return true;
  } else {
    return false;
  }
}

function displayImageName() {
  document.getElementById("displayImageName").innerText =
    document.getElementById("image").files[0].name;
}
