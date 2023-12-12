<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;

class PAPautreCest  // /!\ Cest est obligatoire après le nom de la classe
{
	 //AUTRE
    public function cas35(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 35 : Ok 
        //On saisie une phrase correct : Ceci est un test + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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
        $I->dontSeeCheckBoxIsChecked('Genou');
        $I->dontSeeCheckBoxIsChecked('Epaule');
        $I->dontSeeCheckBoxIsChecked('Cheville');
        $I->dontSeeCheckBoxIsChecked('Hanche');

        //Je verifie que l'une des options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->seeCheckBoxIsChecked('Courrir');
        $I->dontSeeCheckBoxIsChecked('Sauter');
        $I->dontSeeCheckBoxIsChecked('Marcher');
        $I->dontSeeCheckBoxIsChecked('Porter');
        $I->dontSeeCheckBoxIsChecked('Pousser');
        $I->dontSeeCheckBoxIsChecked('Tirer');
        $I->dontSeeCheckBoxIsChecked('Sallonger sur le sol');
        $I->dontSeeCheckBoxIsChecked('Se relever du sol');
        $I->dontSeeCheckBoxIsChecked('Mettre la tête en arrière');

         //Je verifie que l'un des options du champ "arret en cas de" ici : Fatigue 
        $I->seeCheckBoxIsChecked('Fatigue');
        $I->dontSeeCheckBoxIsChecked('Douleur');
        $I->dontSeeCheckBoxIsChecked('Essouflement');

        // Je rempli le champ "autre" (autre) avec la valeur "Ceci est un test"
        $I->fillField('autre', 'Ceci est un test');

        // Je click sur le bouton pour enregistrer les données
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Message d'erreur"
        $I->dontSee('Message d erreur');

    }

     public function cas36(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 36 : Ok
        //On saisie une phrase correct avec des chiffres : Ceci est un test 22 + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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
        $I->dontSeeCheckBoxIsChecked('Genou');
        $I->dontSeeCheckBoxIsChecked('Epaule');
        $I->dontSeeCheckBoxIsChecked('Cheville');
        $I->dontSeeCheckBoxIsChecked('Hanche');

        //Je verifie que l'une des options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->seeCheckBoxIsChecked('Courrir');
        $I->dontSeeCheckBoxIsChecked('Sauter');
        $I->dontSeeCheckBoxIsChecked('Marcher');
        $I->dontSeeCheckBoxIsChecked('Porter');
        $I->dontSeeCheckBoxIsChecked('Pousser');
        $I->dontSeeCheckBoxIsChecked('Tirer');
        $I->dontSeeCheckBoxIsChecked('Sallonger sur le sol');
        $I->dontSeeCheckBoxIsChecked('Se relever du sol');
        $I->dontSeeCheckBoxIsChecked('Mettre la tête en arrière');

         //Je verifie que l'un des options du champ "arret en cas de" ici : Fatigue 
        $I->seeCheckBoxIsChecked('Fatigue');
        $I->dontSeeCheckBoxIsChecked('Douleur');
        $I->dontSeeCheckBoxIsChecked('Essouflement');

        // Je rempli le champ "autre" (autre) avec la valeur "Ceci est un test"
        $I->fillField('autre', 'Ceci est un test 22');

        // Je click sur le bouton pour enregistrer les données
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Message d'erreur"
        $I->dontSee('Message d erreur');

    }

    public function cas37(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 37 : Ok
        //On saisie une phrase correct avec des caractères spéciaux : Ceci est un test avant-gardiste!,;:!*$^ù + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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
        $I->dontSeeCheckBoxIsChecked('Genou');
        $I->dontSeeCheckBoxIsChecked('Epaule');
        $I->dontSeeCheckBoxIsChecked('Cheville');
        $I->dontSeeCheckBoxIsChecked('Hanche');

        //Je verifie que l'une des options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->seeCheckBoxIsChecked('Courrir');
        $I->dontSeeCheckBoxIsChecked('Sauter');
        $I->dontSeeCheckBoxIsChecked('Marcher');
        $I->dontSeeCheckBoxIsChecked('Porter');
        $I->dontSeeCheckBoxIsChecked('Pousser');
        $I->dontSeeCheckBoxIsChecked('Tirer');
        $I->dontSeeCheckBoxIsChecked('Sallonger sur le sol');
        $I->dontSeeCheckBoxIsChecked('Se relever du sol');
        $I->dontSeeCheckBoxIsChecked('Mettre la tête en arrière');

         //Je verifie que l'un des options du champ "arret en cas de" ici : Fatigue 
        $I->seeCheckBoxIsChecked('Fatigue');
        $I->dontSeeCheckBoxIsChecked('Douleur');
        $I->dontSeeCheckBoxIsChecked('Essouflement');

        // Je rempli le champ "autre" (autre) avec la valeur "Ceci est un test"
        $I->fillField('autre', 'Ceci est un test avant-gardiste!,;:!*$^ù');

        // Je click sur le bouton pour enregistrer les données
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Message d'erreur"
        $I->dontSee('Message d erreur');

    }

    public function cas38(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 38 : Erreur
        //On saisie un hyperlien : https://www.google.com/ + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur "60"
        $I->fillField('frequence_cardiaque', '60');

        //Je verifie que l'une des options du champ "Articulation à ne pas solliciter" est coché, ici : Rachis
        $I->seeCheckBoxIsChecked('Rachis');
        $I->dontSeeCheckBoxIsChecked('Genou');
        $I->dontSeeCheckBoxIsChecked('Epaule');
        $I->dontSeeCheckBoxIsChecked('Cheville');
        $I->dontSeeCheckBoxIsChecked('Hanche');

        //Je verifie que l'une des options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->seeCheckBoxIsChecked('Courrir');
        $I->dontSeeCheckBoxIsChecked('Sauter');
        $I->dontSeeCheckBoxIsChecked('Marcher');
        $I->dontSeeCheckBoxIsChecked('Porter');
        $I->dontSeeCheckBoxIsChecked('Pousser');
        $I->dontSeeCheckBoxIsChecked('Tirer');
        $I->dontSeeCheckBoxIsChecked('Sallonger sur le sol');
        $I->dontSeeCheckBoxIsChecked('Se relever du sol');
        $I->dontSeeCheckBoxIsChecked('Mettre la tête en arrière');

         //Je verifie que l'un des options du champ "arret en cas de" ici : Fatigue 
        $I->seeCheckBoxIsChecked('Fatigue');
        $I->dontSeeCheckBoxIsChecked('Douleur');
        $I->dontSeeCheckBoxIsChecked('Essouflement');

        // Je rempli le champ "autre" (autre) avec la valeur "https://www.google.com/"
        $I->fillField('autre', 'https://www.google.com/');

        // Je click sur le bouton pour enregistrer les données
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il y est le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');

    }

    public function cas39(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 39 : Ok
        //On ne saisit rien dans le champ Autre + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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
        $I->dontSeeCheckBoxIsChecked('Genou');
        $I->dontSeeCheckBoxIsChecked('Epaule');
        $I->dontSeeCheckBoxIsChecked('Cheville');
        $I->dontSeeCheckBoxIsChecked('Hanche');

        //Je verifie que l'une des options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->seeCheckBoxIsChecked('Courrir');
        $I->dontSeeCheckBoxIsChecked('Sauter');
        $I->dontSeeCheckBoxIsChecked('Marcher');
        $I->dontSeeCheckBoxIsChecked('Porter');
        $I->dontSeeCheckBoxIsChecked('Pousser');
        $I->dontSeeCheckBoxIsChecked('Tirer');
        $I->dontSeeCheckBoxIsChecked('Sallonger sur le sol');
        $I->dontSeeCheckBoxIsChecked('Se relever du sol');
        $I->dontSeeCheckBoxIsChecked('Mettre la tête en arrière');

         //Je verifie que l'un des options du champ "arret en cas de" ici : Fatigue 
        $I->seeCheckBoxIsChecked('Fatigue');
        $I->dontSeeCheckBoxIsChecked('Douleur');
        $I->dontSeeCheckBoxIsChecked('Essouflement');

        // Je rempli le champ "autre" (autre) avec la valeur ""
        $I->fillField('autre', '');

        // Je click sur le bouton pour enregistrer les données
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Message d'erreur"
        $I->dontSee('Message d erreur');

    }

    public function cas40(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 40 : ok 
        //Ne rien cocher de tout le formulaire et valider 
        //message d’erreur attendu



        // J'essaie d'aller sur la page pap.php
        $I->amOnPage('pap.php');
        // Je vérifie que je suis bien sur pap.php
        $I->seeInCurrentUrl('/pap.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        //Je test en ne cochant rien du champ de prescription d'activité physique 
        $I->dontSeeCheckBoxIsChecked('non');

        //Je verifie que aucune prescription n'a été joint
        $I->

        // Je rempli le champ "date de prescription" (champ date de prescription) avec la valeur "11/06/2020"
        $I->fillField('date', '11/06/2020');

        //Je test en ne cochant aucune options du champ "Type d'activité à privilégier" est coché, ici : Endurance cardio-respiratoire
        $I->dontSeeCheckBoxIsChecked('Endurance cardio-respiratoire');

        //Je test en ne cochant aucune options du champ Intensité recommendée
        $I->dontSeeCheckBoxIsChecked('Légère');
        $I->dontSeeCheckBoxIsChecked('Modérée');
        $I->dontSeeCheckBoxIsChecked('Elevée');

        //Je test en ne cochant aucune options du champ "Efforts à ne pas réaliser" est coché, ici : Endurance
        $I->dontSeeCheckBoxIsChecked('Endurance');
        $I->dontSeeCheckBoxIsChecked('Vitesse');
        $I->dontSeeCheckBoxIsChecked('Résistance');

        // Je rempli le champ "frequence cardiaque à ne pas depasser" (champ frequence cardiaque à ne pas depasser) avec la valeur "60"
        $I->fillField('frequence_cardiaque', '60');

        //Je test en ne cochant aucune options du champ "Articulation à ne pas solliciter" est coché, ici : Rachis
        $I->dontSeeCheckBoxIsChecked('Rachis');
        $I->dontSeeCheckBoxIsChecked('Genou');
        $I->dontSeeCheckBoxIsChecked('Epaule');
        $I->dontSeeCheckBoxIsChecked('Cheville');
        $I->dontSeeCheckBoxIsChecked('Hanche');

        //Je test en ne cochant aucune options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->dontSeeCheckBoxIsChecked('Courrir');
        $I->dontSeeCheckBoxIsChecked('Sauter');
        $I->dontSeeCheckBoxIsChecked('Marcher');
        $I->dontSeeCheckBoxIsChecked('Porter');
        $I->dontSeeCheckBoxIsChecked('Pousser');
        $I->dontSeeCheckBoxIsChecked('Tirer');
        $I->dontSeeCheckBoxIsChecked('Sallonger sur le sol');
        $I->dontSeeCheckBoxIsChecked('Se relever du sol');
        $I->dontSeeCheckBoxIsChecked('Mettre la tête en arrière');

         //Je test en ne cochant aucune options du champ "arret en cas de" ici : Fatigue 
        $I->dontSeeCheckBoxIsChecked('Fatigue');
        $I->dontSeeCheckBoxIsChecked('Douleur');
        $I->dontSeeCheckBoxIsChecked('Essouflement');

        // Je rempli le champ "autre" (autre) avec la valeur ""
        $I->fillField('autre', '');

        // Je click sur le bouton pour enregistrer les données
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il y est le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');

    }
}