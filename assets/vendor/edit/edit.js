document.addEventListener("DOMContentLoaded", function () {
    const btnBlack = document.querySelector("button[type='button-black']");
    const btnColor = document.querySelector("button[type='button-color']");

    btnBlack.addEventListener("click", function () {
        btnBlack.style.backgroundColor = "black";
        btnBlack.style.color = "white";
        btnColor.style.backgroundColor = "";
        btnColor.style.color = "";
    });

    btnColor.addEventListener("click", function () {
        btnColor.style.backgroundColor = "#800000"; // Puedes cambiar el color deseado
        btnColor.style.color = "white";
        btnBlack.style.backgroundColor = "";
        btnBlack.style.color = "";
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("php-email-form");
    const colorInput = document.getElementById("colorInput");
  
    document.getElementById("btn-black").addEventListener("click", function () {
      colorInput.value = "Negro";
      form.requestSubmit(); // Usar esto en lugar de form.submit()  
    });
  
    document.getElementById("btn-color").addEventListener("click", function () {
      colorInput.value = "Color";
      form.requestSubmit(); // También acá
    });
  });

  