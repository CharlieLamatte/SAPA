<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;

class PAPactionCest  // /!\ Cest est obligatoire après le nom de la classe
{
    
    public function cas29(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //cas 29 : OK 
        //On coche une seule case dans la catégorie Actions a ne pas réaliser + formulaire remplie avec des valeur cohérente( cocher au moins une case partout et remplir les champs de saisie correctement )
        //Affichage message de succès.



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

    public function cas29(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //cas 29 : OK 
        //On coche une seule case dans la catégorie Actions a ne pas réaliser + formulaire remplie avec des valeur cohérente( cocher au moins une case partout et remplir les champs de saisie correctement )
        //Affichage message de succès.



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

    public function cas30(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //cas 30 : OK 
        //On coche toute les cases de la catégorie Actions a ne pas réaliser + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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

        //Je test en cochant toute les options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->seeCheckBoxIsChecked('Courrir');
        $I->seeCheckBoxIsChecked('Sauter');
        $I->seeCheckBoxIsChecked('Marcher');
        $I->seeCheckBoxIsChecked('Porter');
        $I->seeCheckBoxIsChecked('Pousser');
        $I->seeCheckBoxIsChecked('Tirer');
        $I->seeCheckBoxIsChecked('Sallonger sur le sol');
        $I->seeCheckBoxIsChecked('Se relever du sol');
        $I->seeCheckBoxIsChecked('Mettre la tête en arrière');

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

    public function cas31(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //cas 31 : Erreur
        //On ne coche aucune case de la catégorie Actions a ne pas réaliser + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
        //Affichage d’un message d’erreur
 

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

        //Je test que aucune des options du champ "Actions à ne pas realiser  " est coché, ici : Courrir
        $I->dontSeeCheckBoxIsChecked('Courrir');
        $I->dontSeeCheckBoxIsChecked('Sauter');
        $I->dontSeeCheckBoxIsChecked('Marcher');
        $I->dontSeeCheckBoxIsChecked('Porter');
        $I->dontSeeCheckBoxIsChecked('Pousser');
        $I->dontSeeCheckBoxIsChecked('Tirer');
        $I->dontSeeCheckBoxIsChecked('Sallonger sur le sol');
        $I->dontSeeCheckBoxIsChecked('Se relever du sol');
        $I->dontSeeCheckBoxIsChecked('Mettre la tête en arrière');

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