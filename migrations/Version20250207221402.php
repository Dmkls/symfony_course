<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207221402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD project_group_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN project.project_group_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE project
                           ADD CONSTRAINT FK_2FB3D0EEC31A529C FOREIGN KEY (project_group_id)
                           REFERENCES project_group (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEC31A529C ON project (project_group_id)');
        $this->addSql('ALTER TABLE task ADD project_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN task.project_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25166D1F9C FOREIGN KEY (project_id)
                           REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_527EDB25166D1F9C ON task (project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25166D1F9C');
        $this->addSql('DROP INDEX IDX_527EDB25166D1F9C');
        $this->addSql('ALTER TABLE task DROP project_id');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EEC31A529C');
        $this->addSql('DROP INDEX IDX_2FB3D0EEC31A529C');
        $this->addSql('ALTER TABLE project DROP project_group_id');
    }
}
