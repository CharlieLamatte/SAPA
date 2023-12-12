<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;

class PAPfrequenceCardiaqueCest  // /!\ Cest est obligatoire après le nom de la classe
{
    //FREQUENCE CARDIAQUE
    public function cas20(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 20 : Ok
        //On saisit une FC à ne pas dépasser : 60bpm + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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

        //Je test en ne cochant aucune options du champ Intensité recommendée
        $I->seeCheckBoxIsChecked('Légère');
        $I->dontSeeCheckBoxIsChecked('Modérée');
        $I->dontSeeCheckBoxIsChecked('Elevée');

        //Je verifie que l'une des options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->seeCheckBoxIsChecked('Endurance');
        $I->dontSeeCheckBoxIsChecked('Vitesse');
        $I->dontSeeCheckBoxIsChecked('Résistance');

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

        // Je teste qu'il n'y a pas le texte suivant : "Message d'erreur"
        $I->dontSee('Message d erreur');

    }

    public function cas21(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 21 : Erreur
        //On saisie une FC à ne pas dépasser négative : -35bpm + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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

        // Je rempli le champ "date de prescription" (champ date de prescription) avec la valeur "11/06/2020"
        $I->fillField('date', '11/06/2020');

        //Je verifie que l'une des options du champ "Type d'activité à privilégier" est coché, ici : Endurance cardio-respiratoire
        $I->seeCheckBoxIsChecked('Endurance cardio-respiratoire');

        //Je test en ne cochant aucune options du champ Intensité recommendée
        $I->seeCheckBoxIsChecked('Légère');
        $I->dontSeeCheckBoxIsChecked('Modérée');
        $I->dontSeeCheckBoxIsChecked('Elevée');

        //Je verifie que l'une des options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->seeCheckBoxIsChecked('Endurance');
        $I->dontSeeCheckBoxIsChecked('Vitesse');
        $I->dontSeeCheckBoxIsChecked('Résistance');

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur "-35"
        $I->fillField('frequence_cardiaque', '-35');

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

        // Je teste qu'il y a le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');

    }

    public function cas22(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 22 : Erreur
        //On saisie une FC à ne pas dépasser inférieur à 50 : 25bpm + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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

        // Je rempli le champ "date de prescription" (champ date de prescription) avec la valeur "11/06/2020"
        $I->fillField('date', '11/06/2020');

        //Je verifie que l'une des options du champ "Type d'activité à privilégier" est coché, ici : Endurance cardio-respiratoire
        $I->seeCheckBoxIsChecked('Endurance cardio-respiratoire');

        //Je test en ne cochant aucune options du champ Intensité recommendée
        $I->seeCheckBoxIsChecked('Légère');
        $I->dontSeeCheckBoxIsChecked('Modérée');
        $I->dontSeeCheckBoxIsChecked('Elevée');

        //Je verifie que l'une des options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->seeCheckBoxIsChecked('Endurance');
        $I->dontSeeCheckBoxIsChecked('Vitesse');
        $I->dontSeeCheckBoxIsChecked('Résistance');

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur "25"
        $I->fillField('frequence_cardiaque', '25');

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

        // Je teste qu'il y a le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');

    }

    public function cas23(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 23 : Erreur
        //On saisie une FC à ne pas dépasser supérieur à 250 : 293bpm + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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

        // Je rempli le champ "date de prescription" (champ date de prescription) avec la valeur "11/06/2020"
        $I->fillField('date', '11/06/2020');

        //Je verifie que l'une des options du champ "Type d'activité à privilégier" est coché, ici : Endurance cardio-respiratoire
        $I->seeCheckBoxIsChecked('Endurance cardio-respiratoire');

        //Je test en ne cochant aucune options du champ Intensité recommendée
        $I->seeCheckBoxIsChecked('Légère');
        $I->dontSeeCheckBoxIsChecked('Modérée');
        $I->dontSeeCheckBoxIsChecked('Elevée');

        //Je verifie que l'une des options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->seeCheckBoxIsChecked('Endurance');
        $I->dontSeeCheckBoxIsChecked('Vitesse');
        $I->dontSeeCheckBoxIsChecked('Résistance');

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur "293"
        $I->fillField('frequence_cardiaque', '293');

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

        // Je teste qu'il y a le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');

    }

    public function cas24(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 24 : Erreur
        //On saisie une FC à ne pas dépasser avec autre chose que des chiffres : ARRP + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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

        // Je rempli le champ "date de prescription" (champ date de prescription) avec la valeur "11/06/2020"
        $I->fillField('date', '11/06/2020');

        //Je verifie que l'une des options du champ "Type d'activité à privilégier" est coché, ici : Endurance cardio-respiratoire
        $I->seeCheckBoxIsChecked('Endurance cardio-respiratoire');

        //Je test en ne cochant aucune options du champ Intensité recommendée
        $I->seeCheckBoxIsChecked('Légère');
        $I->dontSeeCheckBoxIsChecked('Modérée');
        $I->dontSeeCheckBoxIsChecked('Elevée');

        //Je verifie que l'une des options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->seeCheckBoxIsChecked('Endurance');
        $I->dontSeeCheckBoxIsChecked('Vitesse');
        $I->dontSeeCheckBoxIsChecked('Résistance');

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur "ARRP"
        $I->fillField('frequence_cardiaque', 'ARRP');

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

        // Je teste qu'il y a le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');

    }

    public function cas25(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 25 : Erreur
        //On saisie aucune FC à ne pas dépasser + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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

        // Je rempli le champ "date de prescription" (champ date de prescription) avec la valeur "11/06/2020"
        $I->fillField('date', '11/06/2020');

        //Je verifie que l'une des options du champ "Type d'activité à privilégier" est coché, ici : Endurance cardio-respiratoire
        $I->seeCheckBoxIsChecked('Endurance cardio-respiratoire');

        //Je test en ne cochant aucune options du champ Intensité recommendée
        $I->seeCheckBoxIsChecked('Légère');
        $I->dontSeeCheckBoxIsChecked('Modérée');
        $I->dontSeeCheckBoxIsChecked('Elevée');

        //Je verifie que l'une des options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->seeCheckBoxIsChecked('Endurance');
        $I->dontSeeCheckBoxIsChecked('Vitesse');
        $I->dontSeeCheckBoxIsChecked('Résistance');

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur ""
        $I->fillField('frequence_cardiaque', '');

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

        // Je teste qu'il y a le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');

    }

}