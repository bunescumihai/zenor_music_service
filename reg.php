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
        <div id="reg-block" class="shadow shadow-info shadow-intensity-lg">
            <header>
                <div class="logo">
                    <img src="img/logo.png" alt="">
                    <span><p>ENOR</p></span>
                </div>
                <h1>Registration</h1>
            </header>
            <form id="auth-content" name="regForm" method="post"  onsubmit="return validation();" action="php/registration.php">
                <section id="auth-block-left">
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="inputEmail">E-mail</label>
                            <input name="email" type="email" class="form-control" id="inputEmail" placeholder="e-mail">
                            <p class="error-msg" id="errEmail"></p>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="inputPassword">Mot de passe</label>
                            <input name="password" type="password" class="form-control" id="inputPassword" placeholder="mot de passe">
                            <p class="error-msg" id="errPassword"></p>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="inputConfirmPassword">Confirmer mot de passe</label>
                            <input name="password2" type="password" class="form-control" id="inputConfirmPassword" placeholder="confirmer mot de passe">
                            <p class="error-msg" id="errConfirmPassword"></p>
                        </div>
                    </div>
                    <div class="form-group col-md-10">
                        <label for="inputPhoneNumber">Numéro de téléphone</label>
                        <input name="tell_number" type="text" class="form-control" id="inputPhoneNumber" placeholder="+373">
                        <p class="error-msg" id="errPhoneNumber"></p>
                    </div>
                    <div class="form-inline col-md-10">
                        <label class="my-1 mr-2" for="selectCountry">Pays</label>
                        <select class="form-select" aria-label="Default select example" name="countries">
                            <option value="0" selected>Autres...</option>
                            <option value="1">Republique de Moldova</option>
                            <option value="2">USA</option>
                            <option value="3">UK</option>
                            <option value="4">France</option>
                            <option value="5">Germany</option>
                        </select>
                    </div>
                </section>
                <section id="auth-block-right">

                    <div class="form-group col-md-10">
                        <label for="inputFirstName">Nom</label>
                        <input name="first_name" type="text" class="form-control" id="inputFirstName" placeholder="nom">
                        <p class="error-msg" id="errFirstName"></p>
                    </div>
                    <div class="form-group col-md-10">
                        <label for="inputLastName">Prénom</label>
                        <input name="last_name" type="text" class="form-control" id="inputLastName" placeholder="prenom">
                        <p class="error-msg" id="errLastName"></p>
                    </div>
                    <div class="form-group col-md-10">
                        <label for="inputNickName">Nick name</label>
                        <input name="nick_name" type="text" class="form-control" id="inputNickName" placeholder="nick name">
                        <p class="error-msg" id="errNickName"></p>
                    </div>
                    <p>Utiliser</p>
                    <div class="form-group">
                        <input class="form-check-input" type="radio" name="usage" value="np" id="flexRadioDefault1">
                        <label style="margin: 0" class="form-check-label" for="flexRadioDefault1">
                            Nom/prenom
                        </label>
                    </div>
                    <div class="form-group">
                        <input class="form-check-input" type="radio" name="usage" value="nn" id="flexRadioDefault2" checked>
                        <label style="margin: 0" class="form-check-label" for="flexRadioDefault2">
                            Nick name
                        </label>
                    </div>
                    <div class="form-group">
                        <input class="form-check-input" type="radio" name="usage" value="em" id="flexRadioDefault3">
                        <label style="margin: 0" class="form-check-label" for="flexRadioDefault3">
                            E-mail
                        </label>
                    </div>
                    <p class="error-msg"></p>
                    <div id="auth-block-right-music-type">
                        <p style="margin: 10px 0">Type de musique préféré</p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="musicType[]" type="checkbox" id="music-type-1" value="hip-hop">
                            <label class="form-check-label" for="music-type-1">hip-hop</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="musicType[]" type="checkbox" id="music-type-2" value="pop">
                            <label class="form-check-label" for="music-type-2">pop</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="musicType[]" type="checkbox" id="music-type-3" value="electronique">
                            <label class="form-check-label" for="music-type-3">électronique</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="musicType[]" type="checkbox" id="music-type-4" value="rock">
                            <label class="form-check-label" for="music-type-4">rock</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="musicType[]" type="checkbox" id="music-type-5" value="classique">
                            <label class="form-check-label" for="music-type-5">classique</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="musicType[]" type="checkbox" id="music-type-6" value="jazz">
                            <label class="form-check-label" for="music-type-6">jazz</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="musicType[]" type="checkbox" id="music-type-7" value="folk">
                            <label class="form-check-label" for="music-type-7">folk</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="musicType[]" type="checkbox" id="music-type-8" value="soul">
                            <label class="form-check-label" for="music-type-8">soul</label>
                        </div>
                        <br/>
                        <input type="submit" class="auth-button">
                        <input type="reset" class="auth-button">
                    </div>
                </section>
                </form>
            <div class="options">
                <a href="index.php">Page d'accueil</a>
                <a href="auth.php">Page d'authentification</a>
            </div>
        </div>
    </section>
    <script src="js/validation.js"></script>
  </body>
</html>
