# GoFundMe Clone

Dit project is een eenvoudige webapplicatie waarmee gebruikers campagnes kunnen bekijken en doneren(via redirectie naar GoFundMe website), en beheerders campagnes kunnen beheren (toevoegen, bewerken, verwijderen). Het maakt gebruik van PHP, MySQL, en XAMPP voor de server- en database-instellingen.

## Inhoud
1. [Projectoverzicht](#projectoverzicht)
2. [Installatie-instructies](#installatie-instructies)
   - [XAMPP Installeren](#xampp-installeren)
   - [Database Configureren](#database-configureren)
3. [Bestanden Uitleg](#bestanden-uitleg)
   - [db.php](#dbphp)
   - [index.php](#indexphp)
   - [detail.php](#detailphp)
   - [edit.php](#editphp)
   - [add.php](#addphp)
   - [register.php](#registerphp)
   - [login.php](#loginphp)
   - [logout.php](#logoutphp)
4. [Gebruikersrollen en Toegang](#gebruikersrollen-en-toegang)
5. [Campagnes Beheren](#campagnes-beheren)
6. [Beveiliging](#beveiliging)
7. [Conclusie](#conclusie)

---

## Projectoverzicht

Deze webapplicatie is een eenvoudige implementatie van een platform voor het beheren van crowdfundingcampagnes. Gebruikers kunnen zich registreren als lid of als admin. Alleen admins kunnen nieuwe campagnes toevoegen, bewerken en verwijderen.

---

## Installatie-instructies

### XAMPP Installeren

1. **Download XAMPP** van de officiële website:
   - Ga naar [https://www.apachefriends.org](https://www.apachefriends.org) en download XAMPP voor jouw besturingssysteem (Windows, MacOS, Linux).

2. **Installatie**:
   - Volg de installatie-instructies van de XAMPP-wizard. Zorg ervoor dat je **Apache** en **MySQL** selecteert.

3. **Start XAMPP**:
   - Open het **XAMPP Control Panel** en klik op "Start" naast **Apache** en **MySQL**.
   - Dit start de webserver (Apache) en de database server (MySQL) op je lokale machine.

4. **Test de installatie**:
   - Open je webbrowser en typ `localhost` in de adresbalk. Je zou de XAMPP-welkomstpagina moeten zien, wat betekent dat alles goed is ingesteld.

---

### Database Configureren

1. **Open phpMyAdmin**:
   - In XAMPP, klik op **Admin** naast **MySQL** om naar de phpMyAdmin-interface te gaan.

2. **Maak een nieuwe database**:
   - Maak een database genaamd `gofundme`.

3. **Maak de benodigde tabellen**:
   - **Tabel `users`**:
     ```sql
     CREATE TABLE users (
         id INT AUTO_INCREMENT PRIMARY KEY,
         username VARCHAR(255) NOT NULL,
         password VARCHAR(255) NOT NULL,
         role VARCHAR(50) NOT NULL
     );
     ```

   - **Tabel `campaigns`**:
     ```sql
     CREATE TABLE campaigns (
         id INT AUTO_INCREMENT PRIMARY KEY,
         family VARCHAR(255) NOT NULL,
         description TEXT NOT NULL,
         link VARCHAR(255) NOT NULL,
         image VARCHAR(255) NOT NULL
     );
     ```

4. **Voeg een admin-gebruiker toe**:
   - In de `users` tabel kun je een admin toevoegen door deze query uit te voeren:
     ```sql
     INSERT INTO users (username, password, role) VALUES ('admin', 'gehashedwachtwoord', 'admin');
     ```
   - **Opmerking**: Vervang `gehashedwachtwoord` door een veilig gehashd wachtwoord, bijvoorbeeld met PHP `password_hash()`.

---

## Bestanden Uitleg

### [db.php](#dbphp)

Dit bestand maakt verbinding met de MySQL-database.

```php
<?php
$host = "localhost"; 
$dbname = "gofundme"; 
$username = "root"; 
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
```
## Verbinding
- Het bestand maakt verbinding met de MySQL-database `gofundme`.

## Foutafhandeling
- Als er een probleem is met de verbinding, wordt er een foutmelding weergegeven.

## Bestanden en Functionaliteiten

### `index.php`
- Dit bestand toont de lijst van campagnes. Gebruikers kunnen campagnes bekijken en doneren(via redirectie naar GoFundMe website), maar alleen admins kunnen campagnes beheren.

#### PHP-code:
```php
<?php // Hier komt de PHP-code voor de indexpagina ?> 
```
### `detail.php`
- Het toont de details van een specifieke campagne, zoals de naam van de familie, de beschrijving, de link, en de afbeelding.
- Beheerders kunnen de campagne bewerken of verwijderen via knoppen op de pagina. 

#### PHP-code:
```php
<?php // Hier komt de PHP-code voor de detail campagne ?> 
```

### `edit.php`
- Het bevat een formulier waarmee admins de details van een campagne kunnen wijzigen, zoals de naam van de familie, beschrijving, en link.
Na het indienen worden de wijzigingen opgeslagen in de database.

#### PHP-code:
```php
<?php // Hier komt de PHP-code voor het bewerken van een campagne ?>
```

### add.php
- Dit bestand is voor het toevoegen van nieuwe campagnes. Alleen admins kunnen hier toegang toe krijgen. 
- Beheerders kunnen hier informatie zoals family, description, en link invoeren, en een afbeelding uploaden.


#### PHP-code:
```php
<?php // Hier komt de PHP-code voor het toevoegen van een campagne ?>
```

### register.php
- Dit bestand is voor gebruikersregistratie. Gebruikers kunnen zich registreren als member of als admin(beheerders)
   - Gebruikers kunnen username, password, en role (member of admin) invoeren.
- Maximaal 2 admins kunnen worden geregistreerd. 
   - Als er al twee admins zijn, krijgen gebruikers een foutmelding bij het registreren als admin.

#### PHP-code: 
```php
<?php // Hier komt de PHP-code voor registratie ?>
```

### login.php
Dit bestand is voor het inloggen van gebruikers. Het valideert de gebruikersnaam en het wachtwoord.
   - Als de gebruikersnaam en het wachtwoord overeenkomen, wordt de gebruiker doorgestuurd naar index.php.
   - Als de inloggegevens onjuist zijn, wordt er een foutmelding weergegeven.

### username en password voor admin
   - **username:** test1
   - **password:** passwordtest1

### FIRST username en password voor member
   - **username:** bobby
   - **paassword:** bobby

### SECOND username en password voor member

   - **username:** nick
   - **password:** nick


## Beheer van sessies: 
- Zodra een gebruiker inlogt of registreet, wordt er een sessie aangemaakt die hen als lid of admin identificeert.

#### PHP-code: 
```php
<?php // Hier komt de PHP-code voor inloggen ?>
```

### logout.php
Dit bestand is voor het uitloggen van een gebruiker. Het vernietigt de sessie en stuurt de gebruiker terug naar de loginpagina.

#### PHP-code:
```php 
<?php // Hier komt de PHP-code voor uitloggen ?>
```

### Gebruikersrollen en Toegang
   - **Leden**: Gebruikers die zich registreren met de rol "Member" hebben alleen toegang om campagnes te bekijken.
   - **Admins**: Beheerders kunnen campagnes toevoegen, bewerken, en verwijderen. Er kunnen maximaal 2 beheerders zijn.
  

## Als admin, ga naar de pagina add.php om een nieuwe campagne toe te voegen.
- Vul de campagnegegevens in, zoals family, description, en een afbeelding.

## Campagne bewerken:
- Als admin, ga naar de pagina edit.php om een bestaande campagne te bewerken. Pas de details van de campagne aan, zoals de beschrijving, link, en afbeelding.

## Campagne verwijderen:
- Als admin, ga naar de pagina index.php, kies een campagne en klik op "Verwijder" om de campagne uit de database te verwijderen.

### Beveiliging
 ## Wachtwoordbeveiliging: 
 - Wachtwoorden worden gehashed met de functie password_hash() tijdens registratie en geverifieerd met password_verify() tijdens het inloggen.

## Conclusie
- Met deze webapplicatie kunnen leden campagnes steunen, terwijl beheerders volledige controle hebben over het beheren van de campagnes. Je kunt de applicatie lokaal draaien met XAMPP en een MySQL

### Veel succes met het gebruiken van dit systeem!