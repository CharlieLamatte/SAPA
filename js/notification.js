"use strict";

document.addEventListener('DOMContentLoaded', function () {
    notifications.init();
}, false);

const notifications = (function () {
    const notification = document.getElementById('notification');
    const versionInfoButton = document.getElementById('version-info');
    const closeNotification = document.getElementById('close-notification');
    const deleteNotifications = document.getElementById('delete-notifications');
    const notificationBadge = document.getElementById('notification-badge');
    const notificationMenu = document.getElementById('notification-menu');

    let isNotificationMenuOpen = false;

    function init() {
        notification.addEventListener('click', () => {
            openNotificationMenu();
        });

        versionInfoButton.addEventListener('click', () => {
            openNotificationVersionMenu();
        });

        closeNotification.addEventListener('click', () => {
            closeNotificationMenu();
            setAllNotificationVu();
            if (isNotificationMenuOpen) {
                setBadgeCount(0);
            }
            removeAllNotifications();

            isNotificationMenuOpen = false;
        });

        if (deleteNotifications) {
            deleteNotifications.addEventListener('click', () => {
                closeNotificationMenu();
                deleteAll();
            });
        }
    }

    /**
     * Affiche le nombre de notifications non lu
     * Si c'est égal à 0, il est caché
     */
    function setBadgeCount(count) {
        notificationBadge.style.display = count > 0 ? 'inline' : 'none';
        notificationBadge.textContent = count;
    }

    /**
     * Enlève toutes les notifications du menu
     */
    function removeAllNotifications() {
        const notifs = document.getElementsByClassName('notif-item');

        while (notifs.item(0)) {
            notifs.item(0).remove();
        }
    }

    /**
     * Met toutes les notifications du menu comme vu (changement de couleur)
     */
    function setAllNotificationVu() {
        const notifs = document.getElementsByClassName('notif-item');

        for (let i = 0; i < notifs.length; i++) {
            notifs.item(i).classList.replace("panel-danger", "panel-primary");
        }
    }

    /**
     * Envoie une requête qui met toutes les notifications du menu en vu
     * dans la BDD
     */
    function setAllEstVu() {
        // recupération des id_notification des notifications qui ne sont pas encore vu
        const notifs = document.getElementsByClassName('notif-item');
        const ids = [];
        for (let i = 0; i < notifs.length; i++) {
            if (notifs.item(i).classList.contains("panel-danger")) {
                ids.push(notifs.item(i).getAttribute('data-id_notification'));
            }
        }

        fetch('/PHP/Notifications/SetNotificationsVu.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"ids": ids}),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .catch((error) => console.error(error));
    }

    /**
     * Envoie une requête qui supprime toutes les notifications de l'utilisateur
     * dans la BDD
     */
    function deleteAll() {
        fetch('/PHP/Notifications/DeteleteAllUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_user": localStorage.getItem('id_user')}),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .then(() => {
                removeAllNotifications();
                setBadgeCount(0);
            })
            .catch((error) => console.error(error));
    }

    /**
     * Ajoutes les notifications au menu
     */
    function addNotifications(notifications) {
        notifications?.forEach(n => {
            notificationMenu.append(createNotification(n));
        });
    }

    /**
     * Creation d'un élément notification
     */
    function createNotification(notification) {
        const panel = document.createElement('div');
        panel.classList.add("panel", "notif-item");
        panel.setAttribute('data-id_notification', notification.id_notification);

        if (notification.est_vu == 0) {
            panel.classList.add("panel-danger");
        } else {
            panel.classList.add("panel-primary");
        }
        panel.style.margin = "4px";

        const panelHeading = document.createElement('div');
        panelHeading.className = "panel-heading";

        const panelTitle = document.createElement('div');
        panelTitle.className = "panel-title";
        panelTitle.textContent = notification.date_notification + ' ' + notification.type_notification;

        const panelBody = document.createElement('div');
        panelBody.className = "panel-body";
        panelBody.innerHTML = notification.text_notification;

        panelHeading.append(panelTitle);
        panel.append(panelHeading, panelBody);

        return panel;
    }

    /**
     * Ouvre le menu des notifications
     */
    function openNotificationMenu() {
        notificationMenu.style.display = "block";
        isNotificationMenuOpen = true;

        fetch('/PHP/Notifications/ReadAllNotification.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_user": notification.getAttribute('data-id_user')}),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .then(data => {
                addNotifications(data);
            })
            .catch((error) => console.error(error))
            .finally(() => setAllEstVu());
    }

    /**
     * Ouvre le menu des changements de versions
     */
    function openNotificationVersionMenu() {
        notificationMenu.style.display = "block";

        fetch('/PHP/Notifications/ReadAllNotificationMaj.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .then(data => {
                addNotifications(data);
            })
            .catch((error) => console.error(error));
    }

    /**
     * Ferme le menu des notifications
     */
    function closeNotificationMenu() {
        notificationMenu.style.display = "none";
    }

    return {
        init,
    };
})();
