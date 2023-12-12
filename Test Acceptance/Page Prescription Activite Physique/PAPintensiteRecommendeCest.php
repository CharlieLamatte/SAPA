<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;

class PAPintensiteRecommendeCest  // /!\ Cest est obligatoire après le nom de la classe
{
    //INTENSITE RECOMMENDE
    public function cas14(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //cas 14 : OK 
        //On coche une seule case dans la catégorie Intensité recommandée + formulaire remplie avec des valeur cohérente( cocher au moins une case partout et remplir les champs de saisie correctement )   
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

    public function cas15(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //cas 15 : Erreur 
        //On coche toute les cases de la catégorie Intensité recommandée + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
        //Affichage message d'erreur



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

        //Je test en cochant toute les options du champ Intensité recommendée
        $I->seeCheckBoxIsChecked('Légère');
        $I->seeCheckBoxIsChecked('Modérée');
        $I->seeCheckBoxIsChecked('Elevée');
        

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

    public function cas16(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //cas 16 : Erreur
        //On ne coche aucune case de la catégorie Intensité recommandée + remplir le formulaire correctement ( cocher au moins une case partout et remplir les champs de saisie correctement )
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
        $I->dontSeeCheckBoxIsChecked('Légère');
        $I->dontSeeCheckBoxIsChecked('Modérée');
        $I->dontSCheckBoxIsChecked('Elevée');
        

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