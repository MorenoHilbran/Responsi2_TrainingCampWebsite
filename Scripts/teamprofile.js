document.addEventListener("DOMContentLoaded", () => {
    const search = document.getElementById("search");
    const cards = document.getElementById("cards");
  
    if (search) {
      search.addEventListener("submit", (e) => e.preventDefault());
      search.addEventListener("input", (e) => {
        e.preventDefault();
        let data = new FormData(search);
        let searchName = data.get("searchName")?.toString().toLowerCase();
  
        // Ambil semua kartu
        let cardElements = cards.querySelectorAll(".card");
  
        cardElements.forEach((card) => {
          let cardName = card.getAttribute("data-name").toLowerCase();
          // Tampilkan atau sembunyikan kartu berdasarkan pencarian
          if (searchName && !cardName.includes(searchName)) {
            card.style.display = "none";
          } else {
            card.style.display = "block";
          }
        });
      });
    }
  });
  