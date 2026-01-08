<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | My Daily Journal</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    <link rel="icon" href="img/logo.png" />
  </head>
  <body class="bg-danger-subtle">

        <div class="container mt-5 pt-5">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-6 m-auto">
                    <div class="card border-0 shadow rounded-5">
                        <div class="card-body">
                            							<div class="text-center mb-3">
                <i class="bi bi-person-circle h1 display-4"></i>
                <p>My Daily Journal</p>
                <hr />
              </div>
              <form action="" method="post" id="loginForm">
                <input
                  type="text"
                  name="user"
                  id="user"
                  class="form-control my-4 py-2 rounded-4"
                  placeholder="Username"
                />
                <input
                  type="password"
                  name="pass"
                  id="pass"
                  class="form-control my-4 py-2 rounded-4"
                  placeholder="Password"
                />
                <div class="text-center my-3 d-grid">
                  <button class="btn btn-danger rounded-4">Login</button>
                </div>
                <p id="errorMsg" class="text-danger"></p>
              </form>
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                    </div> 
 <?php
//set variable username dan password dummy
$username = "admin";
$password = "123456";

//check apakah ada request dengan method POST yang dilakukan
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ambil nilai input 
    $userInput = $_POST['user'];
    $passInput = $_POST['pass'];

    // --- VALIDASI EMPTY FIELD ---
    if ($userInput == "") {
        echo "Username tidak boleh kosong!";
        exit; // hentikan proses
    }

    if ($passInput == "") {
        echo "Password tidak boleh kosong!";
        exit; // hentikan proses
    }

		//jika lolos semua validasi 
    //tampilkan isi dari variable array POST menggunakan perulangan
    foreach($_POST as $key => $val){
        echo $key . " : " . $val . "<br>";
    }

    //jika lolos semua validasi 
    //check apakah username dan password yang di POST sama dengan data dummy
    if ($userInput == $username AND $passInput == $password) {
        echo "Username dan Password Benar";
    } else {
        echo "Username dan Password Salah";
    }
}
?>

<script>
  document.getElementById("loginForm").addEventListener("submit", function(event) {
      const user = document.getElementById("user").value.trim();
      const pass = document.getElementById("pass").value.trim();
      const errorMsg = document.getElementById("errorMsg");

      // Reset pesan error
      errorMsg.textContent = "";

      // Cek username kosong
      if (user === "") {
          errorMsg.textContent = "Username tidak boleh kosong!";
          event.preventDefault(); // stop submit (stop kirim data dari form ke server)
          return;
      }

      // Cek password kosong
      if (pass === "") {
          errorMsg.textContent = "Password tidak boleh kosong!";
          event.preventDefault(); // stop submit (stop kirim data dari form ke server)
          return;
      }

      // Jika lolos semua validasi, form akan submit (kirim data dari form ke server)
  });
</script>
      
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>