<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180421201926 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, assigned_to_id INT DEFAULT NULL, validated_by_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, category SMALLINT NOT NULL, deadline DATETIME NOT NULL, created_at DATETIME NOT NULL, assigned_at DATETIME DEFAULT NULL, done_at DATETIME DEFAULT NULL, validated_at DATETIME DEFAULT NULL, INDEX IDX_527EDB25B03A8386 (created_by_id), INDEX IDX_527EDB25F4BD7827 (assigned_to_id), INDEX IDX_527EDB25C69DE5E5 (validated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, task_id_id INT NOT NULL, label VARCHAR(100) NOT NULL, notif1 VARCHAR(100) DEFAULT NULL, notif2 VARCHAR(100) DEFAULT NULL, notif3 VARCHAR(100) DEFAULT NULL, user_comment VARCHAR(255) DEFAULT NULL, notif1_admin VARCHAR(100) DEFAULT NULL, notif2_admin VARCHAR(100) DEFAULT NULL, notif3_admin VARCHAR(100) DEFAULT NULL, admin_comment VARCHAR(255) DEFAULT NULL, done_at DATETIME DEFAULT NULL, validated_at DATETIME DEFAULT NULL, INDEX IDX_5F37A13BB8E08577 (task_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, roles JSON NOT NULL, nb_failed_connexion SMALLINT NOT NULL, created_at DATETIME NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25F4BD7827 FOREIGN KEY (assigned_to_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13BB8E08577 FOREIGN KEY (task_id_id) REFERENCES task (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13BB8E08577');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25B03A8386');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25F4BD7827');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25C69DE5E5');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE user');
    }
}
