document.addEventListener("DOMContentLoaded", function () {
    console.log("Navbar script loaded.");
  });
  
  function search_item(btn) {
    const input = document.getElementById("search-box");
    const keyword = input.value.trim();
  
    if (!keyword) {
      alert("Vui lòng nhập từ khóa tìm kiếm.");
      return;
    }
    window.location.href = `?url=Home/Products&search=${encodeURIComponent(keyword)}`;
  }
  