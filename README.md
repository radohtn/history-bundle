# Htn History Bundle

Un petit bundle PHP réutilisable permettant d’**enregistrer l’historique des modifications de la base de données**  
(création, modification, suppression).  

Il fonctionne aussi bien sur des projets **PHP natifs**, **frameworks** (ex: Symfony, Laravel) ou autres,  
grâce à une architecture avec des **adapters de base de données** (MySQL, PostgreSQL, MongoDB).


## ✨ Fonctionnalités

- Enregistrement d’un historique dans une table/collection `histories`
- Stocke : `table_name`, `action`, `user`, `created_at`
- Adapters disponibles :
  - ✅ MySQL (PDO)
  - ✅ PostgreSQL (PDO)
  - ✅ SQLite (PDO)
  - ✅ MongoDB (via `mongodb/mongodb`)
- Commande CLI `bin/history` pour initialiser l’historique
- Extensible : ajoutez vos propres adapters

## 📦 Installation

1- Ajouter le bundle via composer :

```bash
composer require htn/history-bundle


2- (Optionnel) Installer les extensions nécessaires si vous utilisez un SGBD particulier :

MySQL → extension pdo_mysql

PostgreSQL → extension pdo_pgsql

MongoDB → extension ext-mongodb + package mongodb/mongodb


## ⚙️ Utilisation

1. Créer la table/collection histories

Une commande CLI est fournie dans bin/history.

php bin/history --action=install \
    --dsn="mysql:host=127.0.0.1;dbname=test" \
    --user=root \
    --password=secret

--action=install → crée la table/collection histories
--dsn → connexion DSN PDO ou MongoDB URI
--user / --password → identifiants si nécessaire

Exemples :

MySQL
--dsn="mysql:host=127.0.0.1;dbname=myapp"

PostgreSQL
--dsn="pgsql:host=127.0.0.1;dbname=myapp"

SQLLite
--dsn="sqlite:var/dbname.db"

MongoDB
--dsn="mongodb://127.0.0.1:27017"


2. Enregistrer un historique

Depuis votre code :

use Htn\HistoryBundle\Entity\History;
use Htn\HistoryBundle\Database\MysqlAdapter;

$pdo = new \PDO("mysql:host=127.0.0.1;dbname=myapp", "root", "secret");
$adapter = new MysqlAdapter($pdo);

$history = new History("users", "create", "admin");
$adapter->save($history);
