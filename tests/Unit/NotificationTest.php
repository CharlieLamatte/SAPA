<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\Notification;
use Tests\Support\UnitTester;

class NotificationTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Notification $notification;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->notification = new Notification($pdo);
        $this->assertNotNull($this->notification);
    }

    protected function _after()
    {
    }

    public function testCreateOk()
    {
        // obligatoire
        $id_envoyeur = "1";
        $id_destinataire = "2";
        $id_type_notification = Notification::TYPE_NOTIFICATION_AJOUT;
        $text_notification = "Bob dupond was created";

        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $id_notification = $this->notification->create([
            'id_envoyeur' => $id_envoyeur,
            'id_destinataire' => $id_destinataire,
            'id_type_notification' => $id_type_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertNotFalse($id_notification, $this->notification->getErrorMessage());

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before + 1, $notifications_count_after);

        $this->tester->seeInDatabase('notifications', array(
            'id_envoyeur' => $id_envoyeur,
            'id_destinataire' => $id_destinataire,
            'id_type_notification' => $id_type_notification,
            'text_notification' => $text_notification,
            'est_vu' => "0",
        ));
    }

    public function testCreateNotOkId_envoyeurNull()
    {
        // obligatoire
        $id_envoyeur = null;
        $id_destinataire = "2";
        $id_type_notification = Notification::TYPE_NOTIFICATION_AJOUT;
        $text_notification = "Bob dupond was created";

        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $id_notification = $this->notification->create([
            'id_envoyeur' => $id_envoyeur,
            'id_destinataire' => $id_destinataire,
            'id_type_notification' => $id_type_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($id_notification);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testCreateNotOkId_destinataireNull()
    {
        // obligatoire
        $id_envoyeur = "1";
        $id_destinataire = null;
        $id_type_notification = Notification::TYPE_NOTIFICATION_AJOUT;
        $text_notification = "Bob dupond was created";

        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $id_notification = $this->notification->create([
            'id_envoyeur' => $id_envoyeur,
            'id_destinataire' => $id_destinataire,
            'id_type_notification' => $id_type_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($id_notification);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testCreateNotOkId_type_notificationNull()
    {
        // obligatoire
        $id_envoyeur = "1";
        $id_destinataire = "2";
        $id_type_notification = null;
        $text_notification = "Bob dupond was created";

        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $id_notification = $this->notification->create([
            'id_envoyeur' => $id_envoyeur,
            'id_destinataire' => $id_destinataire,
            'id_type_notification' => $id_type_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($id_notification);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testCreateNotOkText_notificationNull()
    {
        // obligatoire
        $id_envoyeur = "1";
        $id_destinataire = "2";
        $id_type_notification = Notification::TYPE_NOTIFICATION_AJOUT;
        $text_notification = null;

        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $id_notification = $this->notification->create([
            'id_envoyeur' => $id_envoyeur,
            'id_destinataire' => $id_destinataire,
            'id_type_notification' => $id_type_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($id_notification);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testCreateMajOk()
    {
        // obligatoire
        $id_envoyeur = "1";
        $text_notification = "Bob dupond was sdfgsdfg sdfgsdfg sdfg sdfg sdfg";

        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $id_notification = $this->notification->createMaj([
            'id_envoyeur' => $id_envoyeur,
            'text_notification' => $text_notification,
        ]);
        $this->assertNotFalse($id_notification, $this->notification->getErrorMessage());

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before + 1, $notifications_count_after);

        $this->tester->seeInDatabase('notifications', [
            'id_envoyeur' => $id_envoyeur,
            'id_destinataire' => $id_envoyeur,
            'id_type_notification' => Notification::TYPE_MAJ_SAPA,
            'text_notification' => $text_notification,
            'est_vu' => "0",
        ]);
    }

    public function testCreateMajNotOkId_envoyeurNull()
    {
        // obligatoire
        $id_envoyeur = null;
        $text_notification = "Bob dupond was sdfgsdfg sdfgsdfg sdfg sdfg sdfg";

        $id_notification = $this->notification->createMaj([
            'id_envoyeur' => $id_envoyeur,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($id_notification, $this->notification->getErrorMessage());
    }

    public function testCreateMajNotOkText_notificationNull()
    {
        // obligatoire
        $id_envoyeur = "1";
        $text_notification = null;

        $id_notification = $this->notification->createMaj([
            'id_envoyeur' => $id_envoyeur,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($id_notification, $this->notification->getErrorMessage());
    }

    public function testUpdateMajOk()
    {
        // obligatoire
        $id_notification = "1";
        $text_notification = "Bob dupond was sdfgsdfg sdfgsdfg sdfg sdfg sdfg";

        $update_ok = $this->notification->updateMaj([
            'id_notification' => $id_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertTrue($update_ok, $this->notification->getErrorMessage());

        $this->tester->seeInDatabase('notifications', [
            'id_notification' => $id_notification,
            'text_notification' => $text_notification,
        ]);
    }

    public function testUpdateMajNotOkId_notificationNull()
    {
        // obligatoire
        $id_notification = null;
        $text_notification = "Bob dupond was sdfgsdfg sdfgsdfg sdfg sdfg sdfg";

        $update_ok = $this->notification->updateMaj([
            'id_notification' => $id_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($update_ok, $this->notification->getErrorMessage());
    }

    public function testUpdateMajNotOkText_notificationNull()
    {
        // obligatoire
        $id_notification = "1";
        $text_notification = null;

        $update_ok = $this->notification->updateMaj([
            'id_notification' => $id_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($update_ok, $this->notification->getErrorMessage());
    }

    public function testCreateMultipleOk()
    {
        // obligatoire
        $id_envoyeur = "1";
        $destinataires = ["2", "3", "4"];
        $id_type_notification = Notification::TYPE_MAJ_SAPA;
        $text_notification = "Le site a été MAJ";

        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $ids = $this->notification->createMultiple([
            'id_envoyeur' => $id_envoyeur,
            'destinataires' => $destinataires,
            'id_type_notification' => $id_type_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertIsArray($ids, $this->notification->getErrorMessage());
        $this->assertCount(3, $ids);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before + 3, $notifications_count_after);

        foreach ($destinataires as $id_user) {
            $this->tester->seeInDatabase('notifications', array(
                'id_envoyeur' => $id_envoyeur,
                'id_destinataire' => $id_user,
                'id_type_notification' => $id_type_notification,
                'text_notification' => $text_notification,
                'est_vu' => "0",
            ));
        }

        foreach ($ids as $id_notification) {
            $this->tester->seeInDatabase('notifications', array(
                'id_envoyeur' => $id_envoyeur,
                'id_notification' => $id_notification,
                'id_type_notification' => $id_type_notification,
                'text_notification' => $text_notification,
                'est_vu' => "0",
            ));
        }
    }

    public function testCreateMultipleNotOkId_envoyeurNull()
    {
        // obligatoire
        $id_envoyeur = null;
        $destinataires = ["2", "3", "4"];
        $id_type_notification = Notification::TYPE_MAJ_SAPA;
        $text_notification = "Le site a été MAJ";

        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $ids = $this->notification->createMultiple([
            'id_envoyeur' => $id_envoyeur,
            'destinataires' => $destinataires,
            'id_type_notification' => $id_type_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($ids);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testCreateMultipleNotOkDestinatairesNull()
    {
        // obligatoire
        $id_envoyeur = "1";
        $destinataires = null;
        $id_type_notification = Notification::TYPE_MAJ_SAPA;
        $text_notification = "Le site a été MAJ";

        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $ids = $this->notification->createMultiple([
            'id_envoyeur' => $id_envoyeur,
            'destinataires' => $destinataires,
            'id_type_notification' => $id_type_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($ids);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testCreateMultipleNotOkId_type_notificationNull()
    {
        // obligatoire
        $id_envoyeur = "1";
        $destinataires = ["2", "3", "4"];
        $id_type_notification = null;
        $text_notification = "Le site a été MAJ";

        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $ids = $this->notification->createMultiple([
            'id_envoyeur' => $id_envoyeur,
            'destinataires' => $destinataires,
            'id_type_notification' => $id_type_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($ids);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testCreateMultipleNotOkText_notificationNull()
    {
        // obligatoire
        $id_envoyeur = "1";
        $destinataires = ["2", "3", "4"];
        $id_type_notification = Notification::TYPE_MAJ_SAPA;
        $text_notification = null;

        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $ids = $this->notification->createMultiple([
            'id_envoyeur' => $id_envoyeur,
            'destinataires' => $destinataires,
            'id_type_notification' => $id_type_notification,
            'text_notification' => $text_notification,
        ]);
        $this->assertFalse($ids);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testSetEstVuOk()
    {
        // update 1 => set to true
        $id_notification = "1";
        $est_vu = true;

        $update_ok = $this->notification->setEstVu($id_notification, $est_vu);

        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('notifications', array(
            'id_notification' => $id_notification,
            'est_vu' => "1",
        ));

        // update 2 => set to false
        $id_notification = "1";
        $est_vu = false;

        $update_ok = $this->notification->setEstVu($id_notification, $est_vu);

        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('notifications', array(
            'id_notification' => $id_notification,
            'est_vu' => "0",
        ));
    }

    public function testSetEstVuNotOkId_notificationNull()
    {
        // update 1 => set to true
        $id_notification = null;
        $est_vu = true;

        $update_ok = $this->notification->setEstVu($id_notification, $est_vu);

        $this->assertFalse($update_ok);
    }

    public function testSetEstVuNotOkEst_vuNull()
    {
        $id_notification = "1";
        $est_vu = null;

        $update_ok = $this->notification->setEstVu($id_notification, $est_vu);

        $this->assertFalse($update_ok);
    }

    public function testSetEstVuNotOkId_notificationNullAndEst_vuNull()
    {
        $id_notification = null;
        $est_vu = null;

        $update_ok = $this->notification->setEstVu($id_notification, $est_vu);

        $this->assertFalse($update_ok);
    }

    public function testSetEstVuNotOkId_notificationInvalid()
    {
        $id_notification = "-1";
        $est_vu = true;

        $update_ok = $this->notification->setEstVu($id_notification, $est_vu);

        $this->assertFalse($update_ok);
    }

    public function testReadOneOk()
    {
        $id_notification = "2";

        $notification = $this->notification->readOne($id_notification);
        $this->assertIsArray($notification);

        $this->assertArrayHasKey('id_notification', $notification);
        $this->assertArrayHasKey('id_envoyeur', $notification);
        $this->assertArrayHasKey('id_destinataire', $notification);
        $this->assertArrayHasKey('type_notification', $notification);
        $this->assertArrayHasKey('text_notification', $notification);
        $this->assertArrayHasKey('date_notification', $notification);
        $this->assertArrayHasKey('date_default_format', $notification);
        $this->assertArrayHasKey('est_vu', $notification);

        $this->assertEquals('2', $notification['id_notification']);
        $this->assertEquals('1', $notification['id_envoyeur']);
        $this->assertEquals('2', $notification['id_destinataire']);
        $this->assertEquals('Mise à jour SAPA', $notification['type_notification']);
        $this->assertEquals('SAPA a été mis à jour v2', $notification['text_notification']);
        $this->assertEquals('14/06/2022 09:11', $notification['date_notification']);
        $this->assertEquals('2022-06-14 09:11:15', $notification['date_default_format']);
        $this->assertEquals('0', $notification['est_vu']);
    }

    public function testReadOneNotOkId_notificationNull()
    {
        $id_notification = null;

        $notification = $this->notification->readOne($id_notification);
        $this->assertFalse($notification);
    }

    public function testReadAllOk()
    {
        $id_user = "2";

        $notifications = $this->notification->readAll($id_user);

        $this->assertNotFalse($notifications);
        $this->assertIsArray($notifications);

        $total = $this->tester->grabNumRecords('notifications', ['id_destinataire' => '2']);

        $this->assertCount($total, $notifications);

        $this->assertArrayHasKey('id_notification', $notifications[0]);
        $this->assertArrayHasKey('id_envoyeur', $notifications[0]);
        $this->assertArrayHasKey('id_destinataire', $notifications[0]);
        $this->assertArrayHasKey('type_notification', $notifications[0]);
        $this->assertArrayHasKey('text_notification', $notifications[0]);
        $this->assertArrayHasKey('date_notification', $notifications[0]);
        $this->assertArrayHasKey('date_default_format', $notifications[0]);
        $this->assertArrayHasKey('est_vu', $notifications[0]);

        $this->assertEquals('2', $notifications[0]['id_notification']);
        $this->assertEquals('1', $notifications[0]['id_envoyeur']);
        $this->assertEquals('2', $notifications[0]['id_destinataire']);
        $this->assertEquals('Mise à jour SAPA', $notifications[0]['type_notification']);
        $this->assertEquals('SAPA a été mis à jour v2', $notifications[0]['text_notification']);
        $this->assertEquals('14/06/2022 09:11', $notifications[0]['date_notification']);
        $this->assertEquals('2022-06-14 09:11:15', $notifications[0]['date_default_format']);
        $this->assertEquals('0', $notifications[0]['est_vu']);
    }

    public function testReadAllOkEmptyResult()
    {
        $id_user = "-1";

        $notifications = $this->notification->readAll($id_user);

        $this->assertNotFalse($notifications);
        $this->assertIsArray($notifications);

        $this->assertCount(0, $notifications);
    }

    public function testReadAllNotOkId_userNull()
    {
        $id_user = null;

        $notifications = $this->notification->readAll($id_user);

        $this->assertFalse($notifications);
    }

    public function testDeleteAllUserOk()
    {
        $id_user = "2";

        $notifications_all_count_before = $this->tester->grabNumRecords('notifications');
        $notifications_user_count_before = $this->tester->grabNumRecords(
            'notifications',
            ['id_destinataire' => $id_user]
        );
        $this->assertGreaterThan(0, $notifications_user_count_before);

        $delete_ok = $this->notification->deleteAllUser($id_user);
        $this->assertTrue($delete_ok);

        $notifications_all_count_after = $this->tester->grabNumRecords('notifications');
        $notifications_user_count_after = $this->tester->grabNumRecords('notifications', ['id_destinataire' => $id_user]
        );
        $this->assertEquals(0, $notifications_user_count_after);
        $this->assertEquals(
            $notifications_all_count_before - $notifications_user_count_before,
            $notifications_all_count_after
        );
    }

    public function testDeleteAllUserNotOkId_userNull()
    {
        $id_user = null;

        $notifications_all_count_before = $this->tester->grabNumRecords('notifications');

        $delete_ok = $this->notification->deleteAllUser($id_user);
        $this->assertFalse($delete_ok);

        $notifications_all_count_after = $this->tester->grabNumRecords('notifications');
        $this->assertEquals($notifications_all_count_before, $notifications_all_count_after);
    }

    public function testDeleteOk()
    {
        $id_notification = "2";

        $this->tester->seeInDatabase("notifications", ['id_notification' => $id_notification]);

        $delete_ok = $this->notification->delete($id_notification);
        $this->assertTrue($delete_ok);

        $this->tester->dontSeeInDatabase("notifications", ['id_notification' => $id_notification]);
    }

    public function testDeleteNotOkId_notificationNull()
    {
        $id_notification = null;

        $delete_ok = $this->notification->delete($id_notification);
        $this->assertFalse($delete_ok);
    }

    public function testReadNewCountOk()
    {
        $id_user = "2";

        $expected_count = $this->tester->grabNumRecords('notifications', ['id_destinataire' => $id_user, 'est_vu' => 0]
        );
        $this->assertGreaterThan(0, $expected_count);

        $count = $this->notification->readNewCount($id_user);
        $this->assertEquals($expected_count, $count);
    }

    public function testReadNewCountOkUserHasNoNotification()
    {
        $id_user = "1";

        $expected_count = $this->tester->grabNumRecords('notifications', ['id_destinataire' => $id_user, 'est_vu' => 0]
        );
        $this->assertEquals(0, $expected_count);

        $count = $this->notification->readNewCount($id_user);
        $this->assertEquals($expected_count, $count);
    }

    public function testReadNewCountNotOkId_userNull()
    {
        $id_user = null;

        $count = $this->notification->readNewCount($id_user);
        $this->assertFalse($count);
    }

    public function testReadAllMajOk()
    {
        $notifications = $this->notification->readAllMaj();
        $this->assertIsArray($notifications);

        $total = $this->tester->grabNumRecords('notifications', ['id_type_notification' => Notification::TYPE_MAJ_SAPA]
        );

        $this->assertGreaterThan(0, $total);
        $this->assertCount($total, $notifications);

        foreach ($notifications as $notification) {
            $this->assertArrayHasKey('id_notification', $notification);
            $this->assertArrayHasKey('type_notification', $notification);
            $this->assertArrayHasKey('text_notification', $notification);
            $this->assertArrayHasKey('date_notification', $notification);
            $this->assertArrayHasKey('date_default_format', $notification);
        }
    }
}