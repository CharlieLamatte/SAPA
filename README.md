# SAPA-SportSante86

## Installation locale

1. Installer MAMP (de préférence) ou XAMP ou LAMP

2. Installer Composer : [Lien](https://getcomposer.org/download/)

3. Executer composer dans la racine du dossier (qui contient composer.json)

```bash
composer install
```

4. Ajouter mysql au PATH

Par exemple ajouter le dossier`C:\MAMP\bin\mysql\bin` au PATH
(il faut peut-être redémarrer l'OS pour que le changement soit pris en compte)

5. Initialiser la BDD en executant les scripts SQL suivants:
    - tests/tests/Support/Data/sportsanzbtest2.sql
    - stored_procedures_and_functions/FUNCTION_evaluations.sql

6. Installation de chrome driver

Suivre les instructions de la section **Local Chrome and/or Firefox** de la page
suivante: [Lien](https://codeception.com/docs/modules/WebDriver#Local-Chrome-andor-Firefox).
Il faut parfois re-télécharger chromedriver s'il y a une mise à jour de chrome.

## Execution des tests

### Tests d'acceptance

Démarrer ChromeDriver:

```bash
chromedriver --url-base=/wd/hub
```

Ensuite lancer les tests dans un terminal différent:

```bash
php vendor/bin/codecept run Acceptance --html
```

### Tests unitaires

```bash
php vendor/bin/codecept run Unit --html
```

## Execution des benchmarks
```bash
php vendor/bin/phpbench run --report=aggregate
```

## Comptes utilisateurs

| mail                                        | mot de passe                     | rôle                  |
|---------------------------------------------|----------------------------------|-----------------------|
| TestAdmin@sportsante86.fr                   | testAdmin1.1@A                   | admin                 |
| testcoord1@sportsante86.fr                  | testcoord1.1@A                   | coordo PEPS           |
| testCoordonnateurMSSAbc@gmail.com           | testCoordonnateurMSSAbc@1d       | coordo MSS            |
| testIntervenantAbc@gmail.com                | testIntervenantAbc@1d            | intervenant           |
| testEvaluateurNom@sportsante86.fr           | testEvaluateurNom1.1@A           | evaluateur            |
| testResponsableStructureNom@sportsante86.fr | testResponsableStructureNom1.1@A | Responsable Structure |
| testSuperviseurNom@sportsante86.fr          | testAdmin1.1@A                   | Superviseur PEPS      |
| TestSecretaireNom@sportsante86.fr           | TestSecretaireNom.1@A            | secretaire            |

## Documentation des libraries Javascript utilisées

- Bootstrap 3: [Lien doc jQuery](https://getbootstrap.com/docs/3.3/)
- jQuery: [Lien doc jQuery](https://api.jquery.com/)
- DataTables: [Lien doc DataTables](https://datatables.net/manual/)
- Chart.js: [Lien doc Chart.js](https://www.chartjs.org/docs/latest/)
- PDF.js: [Lien doc PDF.js](https://mozilla.github.io/pdf.js/)
- Fullcalendar: [Lien doc Fullcalendar](https://fullcalendar.io/docs)

## Documentation des libraries PHP utilisées

- FPDF: [Lien doc FPDF](http://www.fpdf.org/)
- Codeception: [Lien doc Codeception](https://codeception.com/)
- Event
  Manager [Lien doc Event Manager](https://www.doctrine-project.org/projects/doctrine-event-manager/en/latest/index.html)
- phpdotenv [Lien doc phpdotenv](https://github.com/vlucas/phpdotenv)
- LeagueCSV [Lien doc LeagueCSV](https://csv.thephpleague.com/9.0/)
- monolog 2.x [Lien doc monolog 2.x](https://github.com/Seldaek/monolog/blob/2.x/README.md)
- fakerphp [Lien doc fakerphp](https://fakerphp.github.io/)
- phpbench [Lien doc phpbench](https://phpbench.readthedocs.io/en/latest/)