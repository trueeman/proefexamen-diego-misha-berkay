<?php
require_once("../vendor/autoload.php");
use Proefexamen\ElektronischStemmen\Database;
session_start();

$db = new Database;
if ($db) : ?>

<h3 class="text-light" style="position: absolute;">Connectie geslaagd</h3>

<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie - Proefexamen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/theme.css">
</head>
<body class="bg-dark">
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-sm" style="width: 300px;">

            <!-- Registratie icoon -->
            <div class="d-flex justify-content-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                    <path d="M8 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd" d="M8 9a7 7 0 1 0 0 2h1.5A5.5 5.5 0 0 1 8 16a7 7 0 0 0 0-7z"/>
                    <path fill-rule="evenodd" d="M13 5h-2v1h2v2h1V6h2V5h-2V3h-1v2z"/>
                </svg>
            </div>

            <!-- Registratie formulier -->
            <form class="needs-validation" action="signup_process.php" method="POST" novalidate>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">
                        Vul alstublieft een geldig e-mailadres in.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Gebruikersnaam</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    <div class="invalid-feedback">
                        Vul alstublieft uw gebruikersnaam in.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Wachtwoord</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">
                        Vul alstublieft een wachtwoord in.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Registreren</button>
            </form>

            <!-- Login link -->
            <div class="text-center mt-3">
                <p>Heb je al een account? <a href='login.php'>Log hier in.</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
       
        (() => {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>
