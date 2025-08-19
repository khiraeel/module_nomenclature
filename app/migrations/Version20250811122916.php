<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250811122916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_catalog ADD supplier_id UUID NOT NULL');
        $this->addSql('ALTER TABLE product_catalog ADD CONSTRAINT FK_CAF529F72ADD6D8C FOREIGN KEY (supplier_id) REFERENCES "product_supplier" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CAF529F72ADD6D8C ON product_catalog (supplier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product_catalog DROP CONSTRAINT FK_CAF529F72ADD6D8C');
        $this->addSql('DROP INDEX IDX_CAF529F72ADD6D8C');
        $this->addSql('ALTER TABLE product_catalog DROP supplier_id');
    }
}
