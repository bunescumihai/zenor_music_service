<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenor, profil</title>
    <link href="css/bootstrap.css" rel ="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/auth.css">
  </head>
  <body>
    <section id="auth-screen">
        <div id="auth-block" class="shadow shadow-info shadow-intensity-lg">
            <header>
                <div class="logo">
                    <img src="img/logo.png" alt="">
                    <span><p>ENOR</p></span>
                </div>
            </header>
            <h2>Authentification</h2>
            <form action="php/login.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-10">
                        <label for="inputEmail4">E-mail</label>
                        <input name="email" type="email" class="form-control" id="inputEmail4" placeholder="e-mail">
                    </div>
                    <div class="form-group col-md-10">
                        <label for="inputPassword4">Password</label>
                        <input name="password" type="password" class="form-control" id="inputPassword4" placeholder="password">
                    </div>
                </div>
                <br/>
                <input type="submit" class="auth-button" value="Sign In">
            </form>
            <div class="options">
                <a href="index.php">Page d'accueil</a>
                <a href="reg.php">Page de registration</a>
            </div>
        </div>
    </section>
  </body>
</html>
