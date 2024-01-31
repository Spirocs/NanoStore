$(document).ready(function () {
      jQuery.ajax({
        type: "POST",
        url: "option.php",
        dataType: "json",
        data: { functionname: "get_timeout" },

        beforeSend: function(xhr) {
          jQuery.ajax({
            type: "POST",
            url: "test.php",
            data: {},
    
            success: async function (obj, textstatus) {
              console.log("worked");
            },
          });
        },

        success: async function (obj, textstatus) {
          if (obj.exist == true) {
            setTimeout(()=> {
                window.location.href = "http://localhost:4242/welcome/welcome.php";
             }
             ,obj.timeout);
          } else {
            console.log(obj.exist);
          }
        },
      });
});