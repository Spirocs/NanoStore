var code = "";

window.addEventListener("DOMContentLoaded", (event) => {
  var ws = new WebSocket("ws://localhost:8765/");

  ws.onopen = function(){
    console.log("Connection is Established");
    command = "login";
    ws.send(command);
  };

  ws.onmessage = function(evt) {
      code = String(evt.data).toLowerCase();
      console.log(code);
      
      ws.send("stop");
      ws.close();

      jQuery.ajax({
        type: "POST",
        url: "code.php",
        dataType: "json",
        data: { functionname: "check_code", argument: code },

        success: async function (obj, textstatus) {
          if (obj.exist == true) {
            console.log(obj.exist);
            jQuery.ajax({
              type: "POST",
              url: "code.php",
              dataType: "json",
              data: { functionname: "load_products" }
            });

            let welcome1 = document.getElementById("header_1");
            let welcome2 = document.getElementById("header_2");

            welcome1.innerHTML = "Willkommen, " + obj.name;
            document.getElementById('card').remove();
            welcome2.remove();
            await sleep(2000);
            welcome1.style.animation = "fade-out 2s forwards";
            await sleep(1200);

            window.location.href = "http://localhost:4242/cart/cart.php";
          } else {
            console.log(obj.exist);
          }
        },
      });
      code = "";
  };
});

function sleep(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}
