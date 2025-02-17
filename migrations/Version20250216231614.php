<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250216231614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE todo_list ADD studente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE todo_list ADD CONSTRAINT FK_1B199E076FAAD853 FOREIGN KEY (studente_id) REFERENCES studente (id)');
        $this->addSql('CREATE INDEX IDX_1B199E076FAAD853 ON todo_list (studente_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE todo_list DROP FOREIGN KEY FK_1B199E076FAAD853');
        $this->addSql('DROP INDEX IDX_1B199E076FAAD853 ON todo_list');
        $this->addSql('ALTER TABLE todo_list DROP studente_id');
    }
}
