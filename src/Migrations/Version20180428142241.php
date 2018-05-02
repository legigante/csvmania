<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180428142241 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task ADD name VARCHAR(55) NOT NULL');
        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13BB8E08577');
        $this->addSql('DROP INDEX IDX_5F37A13BB8E08577 ON token');
        $this->addSql('ALTER TABLE token CHANGE task_id_id task_id INT NOT NULL');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13B8DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('CREATE INDEX IDX_5F37A13B8DB60186 ON token (task_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task DROP name');
        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13B8DB60186');
        $this->addSql('DROP INDEX IDX_5F37A13B8DB60186 ON token');
        $this->addSql('ALTER TABLE token CHANGE task_id task_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13BB8E08577 FOREIGN KEY (task_id_id) REFERENCES task (id)');
        $this->addSql('CREATE INDEX IDX_5F37A13BB8E08577 ON token (task_id_id)');
    }
}
