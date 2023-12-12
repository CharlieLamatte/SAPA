<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;

class PAPprescMedCest  // /!\ Cest est obligatoire après le nom de la classe
{
    //DATE
    public function cas9(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 9: Ok
        //On saisie une Date correct : 11/06/2019 + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
        //Affichage message de succès


        // J'essaie d'aller sur la page pap.php
        $I->amOnPage('pap.php');
        // Je vérifie que je suis bien sur pap.php
        $I->seeInCurrentUrl('/pap.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        //Je verifie que le champ de prescription d'activité physique est coché en "non" 
        $I->seeCheckBoxIsChecked('non');

        //Je verifie que aucune prescription n'a été joint
        $I->

        // Je rempli le champ "date de prescription" (champ date de prescription) avec la valeur "11/06/2020"
        $I->fillField('date', '11/06/2020');

        //Je verifie que l'une des options du champ "Type d'activité à privilégier" est coché, ici : Endurance cardio-respiratoire
        $I->seeCheckBoxIsChecked('Endurance cardio-respiratoire');

        //Je verifie que l'une des options du champ "Intensité recommandé est coché, ici : Légère
        $I->seeCheckBoxIsChecked('Légère');

        //Je verifie que l'une des options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->seeCheckBoxIsChecked('Endurance');

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur "60"
        $I->fillField('frequence_cardiaque', '60');

        //Je verifie que l'une des options du champ "Articulation à ne pas solliciter" est coché, ici : Rachis
        $I->seeCheckBoxIsChecked('Rachis');

        //Je verifie que l'une des options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->seeCheckBoxIsChecked('Courrir');

         //Je verifie que l'une des options du champ "arret en cas de" est coché, ici : Fatigue
        $I->seeCheckBoxIsChecked('Fatigue');

        // Je rempli le champ "autre" (autre) avec la valeur "Ceci est un test"
        $I->fillField('autre', 'Ceci est un test');

        // Je click sur le bouton pour enregistrer les données
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Message d'erreur"
        $I->dontSee('Message d erreur');

    }

    public function cas10(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 10 : Erreur
        //On saisie une Date absurde avec autre chose que des chiffres : PPMRDTP + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
        //Affichage message d’erreur



        // J'essaie d'aller sur la page pap.php
        $I->amOnPage('pap.php');
        // Je vérifie que je suis bien sur pap.php
        $I->seeInCurrentUrl('/pap.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        //Je verifie que le champ de prescription d'activité physique est coché en "non" 
        $I->seeCheckBoxIsChecked('non');

        //Je verifie que aucune prescription n'a été joint
        $I->

        // Je rempli le champ "date de prescription" (champ date de prescription) avec la valeur "PPMRDTP"
        $I->fillField('date', 'PPMRDTP');

        //Je verifie que l'une des options du champ "Type d'activité à privilégier" est coché, ici : Endurance cardio-respiratoire
        $I->seeCheckBoxIsChecked('Endurance cardio-respiratoire');

        //Je verifie que l'une des options du champ "Intensité recommandé est coché, ici : Légère
        $I->seeCheckBoxIsChecked('Légère');

        //Je verifie que l'une des options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->seeCheckBoxIsChecked('Endurance');

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur "60"
        $I->fillField('frequence_cardiaque', '60');

        //Je verifie que l'une des options du champ "Articulation à ne pas solliciter" est coché, ici : Rachis
        $I->seeCheckBoxIsChecked('Rachis');

        //Je verifie que l'une des options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->seeCheckBoxIsChecked('Courrir');

         //Je verifie que l'une des options du champ "arret en cas de" est coché, ici : Fatigue
        $I->seeCheckBoxIsChecked('Fatigue');

        // Je rempli le champ "autre" (autre) avec la valeur "Ceci est un test"
        $I->fillField('autre', 'Ceci est un test');

        // Je click sur le bouton pour enregistrer les données
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il y est le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');

    }

    public function cas11(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 11 : Erreur
        //On saisit une Date absurde avec une date négative : 16/08/-600 + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
        //Affichage message d’erreur


        // J'essaie d'aller sur la page pap.php
        $I->amOnPage('pap.php');
        // Je vérifie que je suis bien sur pap.php
        $I->seeInCurrentUrl('/pap.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        //Je verifie que le champ de prescription d'activité physique est coché en "non" 
        $I->seeCheckBoxIsChecked('non');

        //Je verifie que aucune prescription n'a été joint
        $I->

        // Je rempli le champ "date de prescription" (champ date de prescription) avec la valeur "16/08/-600"
        $I->fillField('date', '16/08/-600');

        //Je verifie que l'une des options du champ "Type d'activité à privilégier" est coché, ici : Endurance cardio-respiratoire
        $I->seeCheckBoxIsChecked('Endurance cardio-respiratoire');

        //Je verifie que l'une des options du champ "Intensité recommandé est coché, ici : Légère
        $I->seeCheckBoxIsChecked('Légère');

        //Je verifie que l'une des options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->seeCheckBoxIsChecked('Endurance');

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur "60"
        $I->fillField('frequence_cardiaque', '60');

        //Je verifie que l'une des options du champ "Articulation à ne pas solliciter" est coché, ici : Rachis
        $I->seeCheckBoxIsChecked('Rachis');

        //Je verifie que l'une des options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->seeCheckBoxIsChecked('Courrir');

         //Je verifie que l'une des options du champ "arret en cas de" est coché, ici : Fatigue
        $I->seeCheckBoxIsChecked('Fatigue');

        // Je rempli le champ "autre" (autre) avec la valeur "Ceci est un test"
        $I->fillField('autre', 'Ceci est un test');

        // Je click sur le bouton pour enregistrer les données
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il y est le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');

    }

    public function cas12(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 12 : Erreur
        //On saisie une Date absurde : 16/03/2200 + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
        //Affichage message d’erreur



        // J'essaie d'aller sur la page pap.php
        $I->amOnPage('pap.php');
        // Je vérifie que je suis bien sur pap.php
        $I->seeInCurrentUrl('/pap.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        //Je verifie que le champ de prescription d'activité physique est coché en "non" 
        $I->seeCheckBoxIsChecked('non');

        //Je verifie que aucune prescription n'a été joint
        $I->

        // Je rempli le champ "date de prescription" (champ date de prescription) avec la valeur "16/03/2200"
        $I->fillField('date', '16/03/2200');

        //Je verifie que l'une des options du champ "Type d'activité à privilégier" est coché, ici : Endurance cardio-respiratoire
        $I->seeCheckBoxIsChecked('Endurance cardio-respiratoire');

        //Je verifie que l'une des options du champ "Intensité recommandé est coché, ici : Légère
        $I->seeCheckBoxIsChecked('Légère');

        //Je verifie que l'une des options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->seeCheckBoxIsChecked('Endurance');

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur "60"
        $I->fillField('frequence_cardiaque', '60');

        //Je verifie que l'une des options du champ "Articulation à ne pas solliciter" est coché, ici : Rachis
        $I->seeCheckBoxIsChecked('Rachis');

        //Je verifie que l'une des options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->seeCheckBoxIsChecked('Courrir');

         //Je verifie que l'une des options du champ "arret en cas de" est coché, ici : Fatigue
        $I->seeCheckBoxIsChecked('Fatigue');

        // Je rempli le champ "autre" (autre) avec la valeur "Ceci est un test"
        $I->fillField('autre', 'Ceci est un test');

        // Je click sur le bouton pour enregistrer les données
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il y est le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');

    }
    
    public function cas13(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 13 : Erreur
        //On saisie aucune Date + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
        //Affichage message d’erreur


        // J'essaie d'aller sur la page pap.php
        $I->amOnPage('pap.php');
        // Je vérifie que je suis bien sur pap.php
        $I->seeInCurrentUrl('/pap.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        //Je verifie que le champ de prescription d'activité physique est coché en "non" 
        $I->seeCheckBoxIsChecked('non');

        //Je verifie que aucune prescription n'a été joint
        $I->

        // Je rempli le champ "date de prescription" (champ date de prescription) avec la valeur ""
        $I->fillField('date', '');

        //Je verifie que l'une des options du champ "Type d'activité à privilégier" est coché, ici : Endurance cardio-respiratoire
        $I->seeCheckBoxIsChecked('Endurance cardio-respiratoire');

        //Je verifie que l'une des options du champ "Intensité recommandé est coché, ici : Légère
        $I->seeCheckBoxIsChecked('Légère');

        //Je verifie que l'une des options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->seeCheckBoxIsChecked('Endurance');

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur "60"
        $I->fillField('frequence_cardiaque', '60');

        //Je verifie que l'une des options du champ "Articulation à ne pas solliciter" est coché, ici : Rachis
        $I->seeCheckBoxIsChecked('Rachis');

        //Je verifie que l'une des options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->seeCheckBoxIsChecked('Courrir');

         //Je verifie que l'une des options du champ "arret en cas de" est coché, ici : Fatigue
        $I->seeCheckBoxIsChecked('Fatigue');

        // Je rempli le champ "autre" (autre) avec la valeur "Ceci est un test"
        $I->fillField('autre', 'Ceci est un test');

        // Je click sur le bouton pour enregistrer les données
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il y est le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');

    }

}